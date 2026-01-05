<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Update as CampaignUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FundraisingController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $query = Campaign::query()
            ->where('user_id', auth()->id())
            ->with(['category'])
            // biar card fundraising bisa tampil progress konsisten (SUM paid)
            ->withSum(['donations as collected_sum' => function ($q) {
                $q->where('status', 'paid');
            }], 'amount')
            ->latest();

        if ($q !== '') {
            $query->where('title', 'like', "%{$q}%");
        }

        $campaigns = $query->paginate(9)->withQueryString();

        return view('pages.fundraising.index', compact('campaigns', 'q'));
    }

    public function create()
    {
        // kalau kamu mau pilih kategori di form, pakai ini
        $categories = Category::orderBy('name')->get();

        return view('pages.fundraising.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'purpose' => ['required','string','max:255'],
            'village' => ['nullable','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'province' => ['nullable','string','max:255'],
            'target_amount' => ['required','integer','min:10000'],
            'period_days' => ['required','integer','min:1','max:365'],
            'short_title' => ['nullable','string','max:100'],
            'description' => ['required','string','max:5000'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'image' => ['nullable','image','max:4096'],
        ]);

        // slug unik
        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $i = 2;
        while (Campaign::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
        }

        $campaign = Campaign::create([
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'slug' => $slug,
            'short_title' => $data['short_title'] ?? null,
            'purpose' => $data['purpose'],
            'description' => $data['description'],
            'image' => $imagePath ? Storage::url($imagePath) : null,

            'village' => $data['village'] ?? null,
            'district' => $data['district'] ?? null,
            'city' => $data['city'] ?? null,
            'province' => $data['province'] ?? null,

            'target_amount' => (int) $data['target_amount'],
            'end_date' => now()->addDays((int) $data['period_days']),
            'status' => 'active', // atau 'draft' kalau mau approval
        ]);

        return redirect()->route('fundraising.show', $campaign->slug)
            ->with('success', 'Galang dana berhasil dibuat.');
    }

    public function show(string $slug)
    {
        $campaign = Campaign::where('user_id', auth()->id())
            ->where('slug', $slug)
            ->firstOrFail();

        // progress konsisten
        $collected = (int) $campaign->donations()->where('status','paid')->sum('amount');
        $donors = (int) $campaign->donations()->where('status','paid')->count();

        return view('pages.fundraising.show', compact('campaign', 'slug', 'collected', 'donors'));
    }

    public function edit(string $slug)
    {
        $campaign = Campaign::where('user_id', auth()->id())
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = Category::orderBy('name')->get();

        return view('pages.fundraising.edit', compact('campaign','slug','categories'));
    }

    public function update(Request $request, string $slug)
    {
        $campaign = Campaign::where('user_id', auth()->id())
            ->where('slug', $slug)
            ->firstOrFail();

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'purpose' => ['required','string','max:255'],
            'village' => ['nullable','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'province' => ['nullable','string','max:255'],
            'target_amount' => ['required','integer','min:10000'],
            'period_days' => ['required','integer','min:1','max:365'],
            'short_title' => ['nullable','string','max:100'],
            'description' => ['required','string','max:5000'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'image' => ['nullable','image','max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $campaign->image = Storage::url($imagePath);
        }

        $campaign->fill([
            'title' => $data['title'],
            'purpose' => $data['purpose'],
            'short_title' => $data['short_title'] ?? null,
            'description' => $data['description'],
            'category_id' => $data['category_id'] ?? null,

            'village' => $data['village'] ?? null,
            'district' => $data['district'] ?? null,
            'city' => $data['city'] ?? null,
            'province' => $data['province'] ?? null,

            'target_amount' => (int) $data['target_amount'],
            'end_date' => now()->addDays((int) $data['period_days']),
        ])->save();

        return redirect()->route('fundraising.show', $campaign->slug)
            ->with('success', 'Galang dana berhasil diupdate.');
    }

    // ====== UPDATE POSTS (sesuai desain Add Update) ======

    public function createUpdate(string $slug)
    {
        $campaign = Campaign::where('user_id', auth()->id())
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.fundraising.update-create', compact('campaign','slug'));
    }

    public function storeUpdate(Request $request, string $slug)
    {
        $campaign = Campaign::where('user_id', auth()->id())
            ->where('slug', $slug)
            ->firstOrFail();

        $data = $request->validate([
            'content' => ['required','string','max:5000'],
            'image' => ['nullable','image','max:4096'],
        ]);

        $img = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('updates', 'public');
            $img = Storage::url($path);
        }

        CampaignUpdate::create([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->id(),
            'title' => 'Update',
            'content' => $data['content'],
            'image' => $img,
        ]);

        return redirect()->route('fundraising.show', $campaign->slug)
            ->with('success', 'Update berhasil ditambahkan.');

    }

        public function updates(string $slug)
            {
                $campaign = Campaign::where('user_id', auth()->id())
                    ->where('slug', $slug)
                    ->firstOrFail();

                $updates = $campaign->updates()->latest()->get();

                $collected = (int) $campaign->donations()->where('status','paid')->sum('amount');
                $donors    = (int) $campaign->donations()->where('status','paid')->count();

                return view('pages.fundraising.updates', compact('campaign','slug','updates','collected','donors'));
            }

            
}
