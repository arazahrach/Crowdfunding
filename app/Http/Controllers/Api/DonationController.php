<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class DonationController extends Controller
{
    protected function initMidtrans()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // ganti true saat production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function store(Request $request)
    {
        $this->initMidtrans();

        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'name' => 'required|string',
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|string', // e.g., "qris", "bca", "bni"
        ]);

        $campaign = Campaign::findOrFail($validated['campaign_id']);
        if (!$campaign->is_active) return response()->json(['error' => 'Campaign closed'], 400);

        $transactionId = 'DON-' . now()->format('YmdHis') . '-' . rand(1000, 9999);

        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => $validated['amount'],
            ],
            'customer_details' => [
                'first_name' => $validated['name'],
                'email' => $request->email ?? '',
                'phone' => $request->phone ?? '',
            ],
            'enabled_payments' => [$validated['payment_method']],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $donation = Donation::create([
                'campaign_id' => $validated['campaign_id'],
                'name' => $validated['name'],
                'email' => $request->email,
                'phone' => $request->phone,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_id' => $transactionId,
                'status' => 'pending',
            ]);

            return response()->json([
                'message' => 'Donation initiated',
                'snap_token' => $snapToken,
                'donation' => $donation
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Webhook dari Midtrans
    public function handleWebhook(Request $request)
    {
        $this->initMidtrans();

        $payload = json_decode($request->getContent(), true);
        $orderId = $payload['order_id'] ?? '';
        $status = $payload['transaction_status'] ?? '';
        $fraud = $payload['fraud_status'] ?? '';

        $donation = Donation::where('transaction_id', $orderId)->first();
        if (!$donation) return response()->json(['error' => 'Donation not found'], 404);

        // Simpan response
        $donation->midtrans_response = $payload;
        $donation->status = $status;

        if ($status == 'capture' || $status == 'settlement' || $fraud == 'accept') {
            $donation->status = 'success';
            // Update collected_amount
            $campaign = $donation->campaign;
            $campaign->collected_amount += $donation->amount;
            $campaign->save();
        }

        $donation->save();
        return response()->json(['message' => 'Webhook received']);
    }
}