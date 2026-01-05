<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\MidtransService;


class DonationController extends Controller
{
    // /donasi (list + filter)
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = $request->query('category', 'all'); // all | id | slug
        $sort = $request->query('sort', 'newest');      // newest|oldest|target_high|target_low
        $min = $request->query('min');
        $max = $request->query('max');

     

        $query = Campaign::query()
            ->with(['category'])
            ->withSum(['donations as collected_sum' => function ($q) {
                $q->where('status', 'paid');
            }], 'amount')
            ->where('status', 'active');


        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('short_title', 'like', "%{$q}%")
                    ->orWhere('purpose', 'like', "%{$q}%");
            });
        }

        if ($category !== 'all' && $category !== '') {
            $query->where(function ($sub) use ($category) {
                if (ctype_digit((string) $category)) {
                    $sub->where('category_id', (int) $category);
                } else {
                    $sub->whereHas('category', fn ($c) => $c->where('slug', $category));
                }
            });
        }

        if ($min !== null && $min !== '') $query->where('target_amount', '>=', (int) $min);
        if ($max !== null && $max !== '') $query->where('target_amount', '<=', (int) $max);

        switch ($sort) {
            case 'ending':
                $query->orderBy('end_date', 'asc');
                break;
            case 'popular':
                $query->withCount(['donations as donors_count' => function ($q) {
                    $q->where('status', 'paid');
                }])->orderBy('donors_count', 'desc');
                break;
            case 'collected':
                $query->orderBy('collected_sum', 'desc');
                break;
            case 'target':
                $query->orderBy('target_amount', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
}


        $campaigns = $query->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('pages.donation.index', compact(
            'campaigns',
            'categories',
            'q',
            'category',
            'sort',
            'min',
            'max'
        ));
    }

    // /donation/{slug} (detail)
    public function show(string $slug)
    {
        $campaign = Campaign::with(['user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // ✅ otomatis konsisten: SUM dari donations paid
        $collected = (int) $campaign->donations()->paid()->sum('amount');
        $donors    = (int) $campaign->donations()->paid()->count();

        $daysLeft = null;
        if ($campaign->end_date) {
            $daysLeft = now()->startOfDay()->diffInDays($campaign->end_date->startOfDay(), false);
            if ($daysLeft < 0) $daysLeft = 0;
        }

        return view('pages.donation.show', compact('campaign', 'slug', 'donors', 'daysLeft', 'collected'));
    }

    // /donation/{slug}/updates
    public function updates(string $slug)
    {
        $campaign = Campaign::with(['user'])->where('slug', $slug)->firstOrFail();

        $updates = $campaign->updates()->latest()->get();

        // ✅ otomatis konsisten
        $collected = (int) $campaign->donations()->paid()->sum('amount');

        return view('pages.donation.updates', compact('campaign', 'slug', 'updates', 'collected'));
    }

    // /donation/{slug}/donate (form)
    public function donateForm(string $slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        // ✅ otomatis konsisten
        $collected = (int) $campaign->donations()->paid()->sum('amount');

        return view('pages.donation.donate', compact('campaign', 'slug', 'collected'));
    }

    // POST /donation/{slug}/donate (submit)
    public function donateStore(Request $request, string $slug, MidtransService $midtrans)
{
    $campaign = Campaign::where('slug', $slug)->firstOrFail();

    $data = $request->validate([
        'amount' => ['required', 'integer', 'min:10000'],
        'name' => ['nullable', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:50'],
        'message' => ['nullable', 'string', 'max:1000'],
        'is_anonymous' => ['nullable', 'boolean'],
    ]);

    $isAnonymous = (bool) ($data['is_anonymous'] ?? false);

    // 1) buat record donation dulu (pending)
    $donation = Donation::create([
        'campaign_id' => $campaign->id,
        'user_id' => auth()->id(),
        'name' => $isAnonymous ? null : ($data['name'] ?? null),
        'email' => $data['email'] ?? null,
        'phone' => $data['phone'] ?? null,
        'amount' => (int) $data['amount'],
        'message' => $data['message'] ?? null,
        'is_anonymous' => $isAnonymous,
        'status' => 'pending',
        'payment_ref' => (string) Str::uuid(),
        'order_id' => 'DON-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6)),
    ]);

    // 2) minta snap token
    $donation->snap_token = $midtrans->createSnapToken($donation, $campaign->title);
    $donation->save();

    // 3) tampilkan halaman payment (snap popup)
    return view('pages.donation.payment', [
        'campaign' => $campaign,
        'donation' => $donation,
    ]);
}

    public function midtransCallback(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            return response()->json(['message' => 'Bad payload'], 400);
        }

        // ✅ signature check (Midtrans standard)
        $serverKey = config('midtrans.server_key');
        $expected = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if (!hash_equals($expected, $signatureKey)) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $donation = Donation::where('order_id', $orderId)->first();
        if (!$donation) return response()->json(['message' => 'Donation not found'], 404);

        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        $newStatus = 'pending';
        if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
            $newStatus = 'paid';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true)) {
            $newStatus = 'failed';
        }

        $donation->update([
            'status' => $newStatus,
            'transaction_status' => $transactionStatus,
            'payment_type' => $paymentType,
            'fraud_status' => $fraudStatus,
            'raw_response' => $payload,
        ]);

        return response()->json(['ok' => true]);
    }

}
