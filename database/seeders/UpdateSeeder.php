<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Update;
use App\Models\Campaign;

class UpdateSeeder extends Seeder
{
    public function run(): void
    {
        $main = Campaign::where('slug', 'renovasi-ruang-kelas-sd-negeri-harapan-jaya')->first();

        if ($main) {
            Update::create([
                'campaign_id' => $main->id,
                'title' => 'Progress Renovasi Minggu Ini',
                'content' => "Terima kasih para donatur!\n\nKami sudah mulai membeli material renovasi. Minggu ini fokus pada perbaikan atap dan penggantian papan yang rusak.",
                'image' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=1400&q=80',
            ]);

            Update::create([
                'campaign_id' => $main->id,
                'title' => 'Laporan Penggunaan Dana',
                'content' => "Ringkasan penggunaan dana:\n- Material atap\n- Cat tembok\n- Perbaikan lantai\n\nUpdate berikutnya akan kami kirim setelah progres 50%.",
                'image' => null,
            ]);
        }

        // campaign lain minimal 1 update
        foreach (Campaign::where('slug', '!=', 'renovasi-ruang-kelas-sd-negeri-harapan-jaya')->get() as $c) {
            Update::create([
                'campaign_id' => $c->id,
                'title' => 'Update Awal',
                'content' => 'Terima kasih! Penggalangan dana sudah berjalan.',
                'image' => null,
            ]);
        }
    }
}
