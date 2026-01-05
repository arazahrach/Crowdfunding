<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\Campaign;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        $main = Campaign::where('slug', 'renovasi-ruang-kelas-sd-negeri-harapan-jaya')->first();

        if ($main) {
            $targetTotal = 23780000; // biar tampil persis
            $preset = [30000, 50000, 100000, 150000, 200000, 250000, 500000];

            $sum = 0;
            $i = 1;

            while ($sum + 30000 <= $targetTotal) {
                $amount = $preset[array_rand($preset)];

                if ($sum + $amount > $targetTotal) {
                    $amount = 50000;
                    if ($sum + $amount > $targetTotal) $amount = 30000;
                    if ($sum + $amount > $targetTotal) break;
                }

                Donation::create([
                    'campaign_id' => $main->id,
                    'name' => "Donatur {$i}",
                    'amount' => $amount,
                    'message' => 'Semoga bermanfaat 🙏',
                    'is_anonymous' => false,
                    'status' => 'paid',
                ]);

                $sum += $amount;
                $i++;
            }

            $remaining = $targetTotal - $sum;
            if ($remaining > 0) {
                Donation::create([
                    'campaign_id' => $main->id,
                    'name' => null,
                    'amount' => $remaining,
                    'message' => null,
                    'is_anonymous' => true,
                    'status' => 'paid',
                ]);
            }
        }

        // campaign lain sedikit donasi
        $others = Campaign::where('slug', '!=', 'renovasi-ruang-kelas-sd-negeri-harapan-jaya')->get();
        foreach ($others as $c) {
            for ($i = 1; $i <= 5; $i++) {
                Donation::create([
                    'campaign_id' => $c->id,
                    'name' => "Donatur {$i}",
                    'amount' => 30000,
                    'message' => 'Semangat!',
                    'is_anonymous' => false,
                    'status' => 'paid',
                ]);
            }
        }
    }
}
