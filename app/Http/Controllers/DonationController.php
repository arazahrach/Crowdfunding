<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function index(Request $request)
        {
            $q        = trim((string) $request->query('q', ''));
            $category = trim((string) $request->query('category', '')); // slug
            $sort     = trim((string) $request->query('sort', 'newest'));
            $min      = $request->query('min');
            $max      = $request->query('max');

            // whitelist sort biar gak aneh
            $allowedSort = ['newest', 'ending', 'collected', 'target', 'popular'];
            if (!in_array($sort, $allowedSort, true)) {
                $sort = 'newest';
            }

            $query = Campaign::query()
                ->when($this->hasColumn('campaigns', 'is_active'), fn($qq) => $qq->where('is_active', true))
                ->when($this->hasColumn('campaigns', 'category_id'), fn($qq) => $qq->with('category')); // eager load

            if ($q !== '' && $this->hasColumn('campaigns', 'title')) {
                $query->where('title', 'like', "%{$q}%");
            }

            // ✅ Filter kategori (jalan kalau category_id ada)
            if ($category !== '' && $this->hasColumn('campaigns', 'category_id')) {
                $query->whereHas('category', function ($qq) use ($category) {
                    $qq->where('slug', $category);
                });
            }

            // range target
            if (is_numeric($min) && $this->hasColumn('campaigns', 'target_amount')) {
                $query->where('target_amount', '>=', (int) $min);
            }
            if (is_numeric($max) && $this->hasColumn('campaigns', 'target_amount')) {
                $query->where('target_amount', '<=', (int) $max);
            }

            switch ($sort) {
                case 'ending':
                    // sort mendesak (end_date paling dekat, yang lewat taruh bawah, null paling bawah)
                    if ($this->hasColumn('campaigns', 'end_date')) {
                        $query->orderByRaw("
                            CASE
                                WHEN end_date IS NULL THEN 2
                                WHEN end_date < NOW() THEN 1
                                ELSE 0
                            END ASC,
                            end_date ASC
                        ");
                    } else {
                        $query->latest();
                    }
                    break;

                case 'collected':
                    $this->hasColumn('campaigns', 'collected_amount')
                        ? $query->orderByDesc('collected_amount')
                        : $query->latest();
                    break;

                case 'target':
                    $this->hasColumn('campaigns', 'target_amount')
                        ? $query->orderByDesc('target_amount')
                        : $query->latest();
                    break;

                case 'popular':
                    $query->withCount(['donations as paid_donations_count' => function ($qq) {
                        if ($this->hasColumn('donations', 'status')) {
                            $qq->where('status', 'paid');
                        }
                    }])->orderByDesc('paid_donations_count');
                    break;

                case 'newest':
                default:
                    $query->latest();
                    break;
            }

            $campaigns = $query->paginate(12)->withQueryString();

            // kategori list untuk filter bar
            $categories = collect();
            try {
                $categories = \App\Models\Category::query()->orderBy('name')->get(['name','slug']);
            } catch (\Throwable $e) {
                $categories = collect([
                    (object)['name'=>'Fasilitas','slug'=>'fasilitas'],
                    (object)['name'=>'Beasiswa','slug'=>'beasiswa'],
                    (object)['name'=>'Alat Belajar','slug'=>'alat-belajar'],
                    (object)['name'=>'Tingkat Sekolah','slug'=>'tingkat-sekolah'],
                ]);
            }

            return view('pages.donation.search', compact('campaigns', 'categories', 'q', 'category', 'sort', 'min', 'max'));
        }


    public function show(string $slug)
    {
        $campaign = $this->findCampaignBySlug($slug);

        // hitung donors dari donations yang paid (kalau ada status)
        $donors = Donation::query()
            ->where('campaign_id', $campaign->id)
            ->when($this->hasColumn('donations', 'status'), fn($q) => $q->where('status', 'paid'))
            ->count();

        $daysLeft = $campaign->end_date
            ? max(0, now()->startOfDay()->diffInDays($campaign->end_date, false))
            : null;

        return view('pages.donation.show', compact('campaign', 'donors', 'daysLeft', 'slug'));
    }

    public function updates(string $slug)
    {
        $campaign = $this->findCampaignBySlug($slug);

        $updates = $campaign->updates()
            ->latest()
            ->get();

        return view('pages.donation.updates', compact('campaign', 'updates', 'slug'));
    }

    public function donateForm(string $slug)
    {
        $campaign = $this->findCampaignBySlug($slug);
        return view('pages.donation.donate', compact('campaign', 'slug'));
    }

    public function donateStore(Request $request, string $slug)
    {
        $campaign = $this->findCampaignBySlug($slug);

        $data = $request->validate([
            'amount' => ['required','integer','min:10000'],
            'name'   => ['nullable','string','max:100'],
            'email'  => ['nullable','email','max:120'],
            'phone'  => ['nullable','string','max:30'],
            'is_anonymous' => ['nullable','boolean'],
            'message' => ['nullable','string','max:255'],
        ]);

        // kalau user login, isi name/email dari user (opsional)
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
            $data['name'] = $data['name'] ?: $request->user()->name;
            $data['email'] = $data['email'] ?: $request->user()->email;
        }

        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'user_id'     => $data['user_id'] ?? null,
            'name'        => $data['name'] ?? null,
            'email'       => $data['email'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'amount'      => (int) $data['amount'],
            'status'      => 'pending',
            'is_anonymous'=> (bool) ($data['is_anonymous'] ?? false),
            'message'     => $data['message'] ?? null,
        ]);

        // Untuk sekarang: tanpa Midtrans dulu -> simulasi sukses (buat demo cepat)
        // NANTI: di sini kamu generate snap_token Midtrans dan return ke FE.
        // sementara kita redirect balik ke detail + flash message
        return redirect()
            ->route('donation.show', $slug)
            ->with('success', 'Donasi kamu tercatat (pending). Lanjutkan integrasi Midtrans biar bisa bayar.');
    }

    public function midtransCallback(Request $request)
    {
        // placeholder dulu—nanti kita isi pas Midtrans masuk
        return response()->json(['ok' => true]);
    }

    // ===== helpers =====

    private function findCampaignBySlug(string $slug): Campaign
    {
        // kalau kolom slug ada, pakai slug
        if ($this->hasColumn('campaigns', 'slug')) {
            $c = Campaign::query()
                ->where('slug', $slug)
                ->first();

            if ($c) return $c;
        }

        // fallback: kalau belum ada slug, coba cari by id
        if (ctype_digit($slug)) {
            return Campaign::findOrFail((int) $slug);
        }

        // fallback terakhir: cari title mirip slug
        if ($this->hasColumn('campaigns', 'title')) {
            $candidates = Campaign::query()->get();
            foreach ($candidates as $c) {
                if (Str::slug($c->title) === $slug) return $c;
            }
        }

        abort(404);
    }

    private function hasColumn(string $table, string $col): bool
    {
        static $cache = [];
        $key = "{$table}.{$col}";
        if (array_key_exists($key, $cache)) return $cache[$key];

        try {
            $columns = \Schema::getColumnListing($table);
            return $cache[$key] = in_array($col, $columns, true);
        } catch (\Throwable $e) {
            return $cache[$key] = false;
        }
    }

    public function imgUrl(?string $path): string
    {
        if (!$path) {
            return 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return Storage::url($path);
    }
}
