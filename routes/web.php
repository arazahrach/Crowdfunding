<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'pages.home.index')->name('home');
Route::view('/about', 'pages.about.index')->name('about');

Route::view('/login', 'pages.auth.login')->name('login');
Route::view('/register', 'pages.auth.register')->name('register');

Route::prefix('donation')->group(function () {
    Route::get('/{slug}', fn($slug) => view('pages.donation.show', compact('slug')))->name('donation.show');
    Route::get('/{slug}/donate', fn($slug) => view('pages.donation.donate', compact('slug')))->name('donation.donate');
    Route::get('/{slug}/updates', fn($slug) => view('pages.donation.updates', compact('slug')))->name('donation.updates');
});
Route::get('/donasi', fn() => view('pages.donation.index'))->name('donation.index');

Route::middleware('auth')->prefix('fundraising')->group(function () {
    Route::get('/', fn() => view('pages.fundraising.index'))->name('fundraising.index');
    Route::get('/{slug}', fn($slug) => view('pages.fundraising.show', compact('slug')))->name('fundraising.show');
    Route::get('/{slug}/edit', fn($slug) => view('pages.fundraising.edit', compact('slug')))->name('fundraising.edit');
});
Route::get('/galang-dana', fn() => view('pages.fundraising.create'))->name('fundraising.create');

Route::middleware('auth')->group(function () {
    Route::get('/galang-dana', fn() => view('pages.fundraising.create'))
        ->name('fundraising.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('pages.profile.index');
    })->name('profile.index');
});

require __DIR__.'/auth.php';
