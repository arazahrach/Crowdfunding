<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // default masuk tab galang donasi saya
        return redirect()->route('profile.fundraising');
    }

    // Tab 1: Galang Donasi Saya (campaign milik user)
    public function fundraising(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $query = Campaign::query()
            ->where('user_id', auth()->id())
            ->with(['category'])
            ->withSum(['donations as collected_sum' => function ($q) {
                $q->where('status', 'paid');
            }], 'amount')
            ->latest();

        if ($q !== '') {
            $query->where('title', 'like', "%{$q}%");
        }

        $campaigns = $query->paginate(8)->withQueryString();

        return view('pages.profile.index', [
            'tab' => 'fundraising',
            'q' => $q,
            'campaigns' => $campaigns,
            'donations' => null,
        ]);
    }

    // Tab 2: Riwayat Donasi (donation yang user lakukan)
    public function donations(Request $request)
    {
        $donations = Donation::query()
            ->where('user_id', auth()->id())
            ->with(['campaign'])
            ->latest()
            ->paginate(10);

        return view('pages.profile.index', [
            'tab' => 'donations',
            'q' => null,
            'campaigns' => null,
            'donations' => $donations,
        ]);
    }
}
