<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'campaigns' => Campaign::count(),
            'categories' => Category::count(),
            'donations_total' => Donation::count(),
            'donations_paid' => Donation::where('status','paid')->count(),
            'amount_paid' => (int) Donation::where('status','paid')->sum('amount'),
            'pending' => Donation::where('status','pending')->count(),
            'failed' => Donation::where('status','failed')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
