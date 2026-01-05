<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'pages.about.index')->name('about');


// Auth pages (kalau kamu pakai Breeze/Jetstream biasanya ini gak perlu)
// Route::view('/login', 'pages.auth.login')->name('login');
// Route::view('/register', 'pages.auth.register')->name('register');

// List semua campaign (public)
Route::get('/donasi', [DonationController::class, 'index'])->name('donation.index');


Route::get('/donasi', [DonationController::class, 'index'])->name('donation.index');

Route::prefix('donation')->group(function () {
    Route::get('/{slug}', [DonationController::class, 'show'])->name('donation.show');
    Route::get('/{slug}/updates', [DonationController::class, 'updates'])->name('donation.updates');

    Route::get('/{slug}/donate', [DonationController::class, 'donateForm'])->name('donation.donate');
    Route::post('/{slug}/donate', [DonationController::class, 'donateStore'])->name('donation.donate.store');

    Route::post('/midtrans/callback', [DonationController::class, 'midtransCallback'])->name('midtrans.callback');
});


// Fundraising: wajib login
Route::middleware('auth')->prefix('fundraising')->group(function () {
    Route::get('/', [FundraisingController::class, 'index'])->name('fundraising.index');
    Route::get('/create', [FundraisingController::class, 'create'])->name('fundraising.create');
    Route::post('/', [FundraisingController::class, 'store'])->name('fundraising.store');

    Route::get('/{slug}', [FundraisingController::class, 'show'])->name('fundraising.show');
    Route::get('/{slug}/edit', [FundraisingController::class, 'edit'])->name('fundraising.edit');
    Route::put('/{slug}', [FundraisingController::class, 'update'])->name('fundraising.update');
    Route::get('/{slug}/updates', [FundraisingController::class, 'updates'])->name('fundraising.updates');


    // ✅ tambahan untuk “Add Update” sesuai desain kamu
    Route::get('/{slug}/updates/create', [FundraisingController::class, 'createUpdate'])->name('fundraising.updates.create');
    Route::post('/{slug}/updates', [FundraisingController::class, 'storeUpdate'])->name('fundraising.updates.store');
});

// Profile: wajib login
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');

    // 2 tab profile
    Route::get('/fundraising', [ProfileController::class, 'fundraising'])->name('profile.fundraising');
    Route::get('/donations', [ProfileController::class, 'donations'])->name('profile.donations');
});


Route::post('/midtrans/callback', [DonationController::class, 'midtransCallback'])->name('midtrans.callback');

require __DIR__.'/auth.php';
