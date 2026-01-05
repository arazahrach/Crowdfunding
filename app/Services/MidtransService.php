<?php

namespace App\Services;

use App\Models\Donation;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.sanitized');
        Config::$is3ds = (bool) config('midtrans.3ds');
    }

    /**
     * Create Snap token for a donation
     */
    public function createSnapToken(Donation $donation, string $campaignTitle): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $donation->order_id,
                'gross_amount' => (int) $donation->amount,
            ],
            'item_details' => [
                [
                    'id' => (string) $donation->campaign_id,
                    'price' => (int) $donation->amount,
                    'quantity' => 1,
                    'name' => mb_substr($campaignTitle, 0, 50),
                ],
            ],
            'customer_details' => [
                'first_name' => $donation->name ?? 'Donatur',
                'email' => $donation->email ?? 'donatur@example.com',
                'phone' => $donation->phone ?? null,
            ],
            // optional callbacks / redirect
            'callbacks' => [
                'finish' => route('donation.show', $donation->campaign->slug),
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
