<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FundraisingController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::query()
            ->where('user_id', $request->user()->id)
            ->with('category')
            ->latest()
            ->paginate(12);

        return view('pages.fundraising.index', compact('campaigns'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get(['id','name','slug','icon']);
        return view('pages.fundraising.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'   => ['required','exists:categories,id'],
            'title'         => ['required','string','max:255'],
            'short_title'   => ['nullable','string','max:255'],
            'goal'          => ['required','string','max:255'],

            'village'       => ['nullable','string','max:120'],
            'district'      => ['nullable','string','max:120'],
            'city'          => ['nullable','string','max:120'],
            'province'      => ['nullable','string','max:120'],

            'target_amount' => ['required','integer','min:10000'],
            'period_days'   => ['required','integer','min:1','max:365'],

            'description'   => ['required','string','max:5000'],
            'usage_details' => ['nullable','string','max:5000'],

            'image'         => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $i = 2;
        while (Campaign::where('slug', $slug)->exists()) $slug = $baseSlug.'-'.$i++;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
        }

        $endDate = now()->addDays((int) $data['period_days'])->endOfDay();

        $campaign = Campaign::create([
            'user_id'         => $request->user()->id,
            'category_id'     => (int) $data['category_id'],
            'title'           => $data['title'],
            'short_title'     => $data['short_title'] ?? null,
            'slug'            => $slug,
            'goal'            => $data['goal'],

            'village'         => $data['village'] ?? null,
            'district'        => $data['district'] ?? null,
            'city'            => $data['city'] ?? null,
            'province'        => $data['province'] ?? null,

            'description'     => $data['description'],
            'usage_details'   => $data['usage_details'] ?? null,

            'image'           => $imagePath,
            'target_amount'   => (int) $data['target_amount'],
            'collected_amount'=> 0,
            'end_date'        => $endDate,

            'is_active'       => 0,
            'status'          => 'pending',
        ]);

        return redirect()->route('fundraising.show', $campaign->slug)
            ->with('success', 'Galang dana berhasil dibuat. Status masih pending (menunggu persetujuan).');
    }

    public function show(Campaign $campaign)
    {
        $this->authorizeOwner($campaign);

        $campaign->load('category');

        $progress = $campaign->target_amount > 0
            ? min(100, (int) round(($campaign->collected_amount / $campaign->target_amount) * 100))
            : 0;

        return view('pages.fundraising.show', compact('campaign', 'progress'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorizeOwner($campaign);

        $categories = Category::query()->orderBy('name')->get(['id','name','slug','icon']);
        return view('pages.fundraising.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorizeOwner($campaign);

        $data = $request->validate([
            'category_id'   => ['required','exists:categories,id'],
            'title'         => ['required','string','max:255'],
            'short_title'   => ['nullable','string','max:255'],
            'goal'          => ['required','string','max:255'],

            'village'       => ['nullable','string','max:120'],
            'district'      => ['nullable','string','max:120'],
            'city'          => ['nullable','string','max:120'],
            'province'      => ['nullable','string','max:120'],

            'target_amount' => ['required','integer','min:10000'],
            'period_days'   => ['nullable','integer','min:1','max:365'],

            'description'   => ['required','string','max:5000'],
            'usage_details' => ['nullable','string','max:5000'],

            'image'         => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($campaign->title !== $data['title']) {
            $baseSlug = Str::slug($data['title']);
            $slug = $baseSlug;
            $i = 2;
            while (Campaign::where('slug', $slug)->where('id','!=',$campaign->id)->exists()) $slug = $baseSlug.'-'.$i++;
            $campaign->slug = $slug;
        }

        if ($request->hasFile('image')) {
            if ($campaign->image) Storage::disk('public')->delete($campaign->image);
            $campaign->image = $request->file('image')->store('campaigns', 'public');
        }

        if (!empty($data['period_days'])) {
            $campaign->end_date = now()->addDays((int) $data['period_days'])->endOfDay();
        }

        $campaign->category_id = (int) $data['category_id'];
        $campaign->title = $data['title'];
        $campaign->short_title = $data['short_title'] ?? null;
        $campaign->goal = $data['goal'];

        $campaign->village = $data['village'] ?? null;
        $campaign->district = $data['district'] ?? null;
        $campaign->city = $data['city'] ?? null;
        $campaign->province = $data['province'] ?? null;

        $campaign->target_amount = (int) $data['target_amount'];
        $campaign->description = $data['description'];
        $campaign->usage_details = $data['usage_details'] ?? null;

        // setelah edit, set ulang jadi pending (opsional)
        $campaign->status = 'pending';
        $campaign->is_active = 0;

        $campaign->save();

        return redirect()->route('fundraising.show', $campaign->slug)
            ->with('success', 'Campaign berhasil di-update. Status kembali pending.');
    }

    private function authorizeOwner(Campaign $campaign): void
    {
        abort_unless(auth()->check() && $campaign->user_id === auth()->id(), 403);
    }

    public static function imgUrl(?string $path): string
    {
        if (!$path) return 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
        return Storage::url($path);
    }
}
