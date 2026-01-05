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

// Detail campaign (public) + donate + updates

Route::prefix('donation')->group(function () {
    Route::get('/{slug}', [DonationController::class, 'show'])->name('donation.show');
    Route::get('/{slug}/updates', [DonationController::class, 'updates'])->name('donation.updates');

    Route::get('/{slug}/donate', [DonationController::class, 'donateForm'])->name('donation.donate');
    Route::post('/{slug}/donate', [DonationController::class, 'donateStore'])->name('donation.donate.store');

    // nanti kalau sudah midtrans:
    Route::post('/midtrans/callback', [DonationController::class, 'midtransCallback'])->name('midtrans.callback');
});

// Fundraising: wajib login
Route::middleware('auth')->prefix('fundraising')->name('fundraising.')->group(function () {
    Route::get('/', [FundraisingController::class, 'index'])->name('index');
    Route::get('/create', [FundraisingController::class, 'create'])->name('create');
    Route::post('/', [FundraisingController::class, 'store'])->name('store');

    Route::get('/{campaign:slug}', [FundraisingController::class, 'show'])->name('show');
    Route::get('/{campaign:slug}/edit', [FundraisingController::class, 'edit'])->name('edit');
    Route::put('/{campaign:slug}', [FundraisingController::class, 'update'])->name('update');
});


// Profile: wajib login
Route::middleware('auth')->get('/profile', [ProfileController::class, 'index'])->name('profile.index');

require __DIR__.'/auth.php';
