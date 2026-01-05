<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');

        $query = Donation::query()
            ->with(['campaign', 'user'])
            ->latest();

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('order_id', 'like', "%{$q}%")
                   ->orWhere('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        $donations = $query->paginate(15)->withQueryString();

        return view('admin.donations.index', compact('donations', 'q', 'status'));
    }

    public function show(Donation $donation)
    {
        $donation->load(['campaign', 'user']);

        return view('admin.donations.show', compact('donation'));
    }
}
