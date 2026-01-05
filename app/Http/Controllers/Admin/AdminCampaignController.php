<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class AdminCampaignController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', ''); // optional filter

        $query = Campaign::query()
            ->with(['user', 'category'])
            ->withSum(['donations as collected_sum' => function ($q) {
                $q->where('status', 'paid');
            }], 'amount')
            ->latest();

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                   ->orWhere('slug', 'like', "%{$q}%");
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        $campaigns = $query->paginate(10)->withQueryString();

        return view('admin.campaigns.index', compact('campaigns', 'q', 'status'));
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['user', 'category', 'updates']);

        $collected = (int) $campaign->donations()->where('status', 'paid')->sum('amount');
        $donors    = (int) $campaign->donations()->where('status', 'paid')->count();

        return view('admin.campaigns.show', compact('campaign', 'collected', 'donors'));
    }

    public function approve(Campaign $campaign)
    {
        // kalau kamu mau semua active: set jadi active
        $campaign->update(['status' => 'active']);

        return back()->with('success', 'Campaign berhasil di-approve (status active).');
    }

    public function end(Campaign $campaign)
    {
        // opsi: tandai selesai
        $campaign->update(['status' => 'ended']);

        // optional: kalau end_date kosong, set jadi hari ini biar konsisten
        if (empty($campaign->end_date)) {
            $campaign->update(['end_date' => now()->toDateString()]);
        }

        return back()->with('success', 'Campaign ditandai berakhir.');
    }
}
