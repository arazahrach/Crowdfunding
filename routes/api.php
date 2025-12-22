<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\UpdateController;

Route::prefix('v1')->group(function () {
    Route::apiResource('campaigns', CampaignController::class);
    Route::post('donations', [DonationController::class, 'store']);
    Route::post('webhook/midtrans', [DonationController::class, 'handleWebhook']);
    Route::post('campaigns/{campaignId}/updates', [UpdateController::class, 'store']);
});