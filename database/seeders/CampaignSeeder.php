<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Telkom University',
            'email' => 'telkom@demo.test',
        ]);

        $catFasilitas = Category::where('slug', 'fasilitas')->first() ?? Category::first();

        // 1) Campaign utama (sesuai UI/UX)
        Campaign::updateOrCreate(
            ['slug' => 'renovasi-ruang-kelas-sd-negeri-harapan-jaya'],
            [
                'user_id' => $user->id,
                'category_id' => $catFasilitas?->id,
                'title' => 'Renovasi Ruang Kelas SD Negeri Harapan Jaya',
                'short_title' => 'Renovasi Ruang Kelas',
                'purpose' => 'Merenovasi ruang kelas agar kegiatan belajar lebih aman dan nyaman.',
                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\nDana digunakan untuk perbaikan atap, lantai, dan perlengkapan kelas.\n\nTerima kasih untuk dukungan semua donatur 🙏",
                // pakai URL dulu biar langsung tampil (tanpa upload file)
                'image' => 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=1400&q=80',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',

                // target & progress (sesuai contoh: 23.780.000 terkumpul)
                'target_amount' => 100000000,
                'collected_amount' => 23780000,

                // 19 hari tersisa (kira-kira)
                'end_date' => Carbon::now()->addDays(19),

                'status' => 'active',

                // kalau kamu sudah tambah kolom bank_*, ini bikin card Transfer muncul
                'bank_name' => 'BCA',
                'bank_account_number' => '1234567890',
                'bank_account_holder' => 'SDN Harapan Jaya',
            ]
        );

        // 2) Campaign tambahan biar list rame
        $extra = [
            [
                'title' => 'Pengadaan Alat Belajar untuk Siswa',
                'target' => 50000000,
                'collected' => 8200000,
                'category_slug' => 'alat-belajar',
            ],
            [
                'title' => 'Beasiswa Siswa Berprestasi',
                'target' => 30000000,
                'collected' => 4500000,
                'category_slug' => 'beasiswa',
            ],
        ];

        foreach ($extra as $e) {
            $cat = Category::where('slug', $e['category_slug'])->first() ?? Category::first();
            Campaign::updateOrCreate(
                ['slug' => Str::slug($e['title'])],
                [
                    'user_id' => $user->id,
                    'category_id' => $cat?->id,
                    'title' => $e['title'],
                    'short_title' => Str::limit($e['title'], 30),
                    'purpose' => 'Penggalangan dana pendidikan.',
                    'description' => 'Dana akan digunakan sesuai kebutuhan program.',
                    'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1400&q=80',
                    'city' => 'Bandung',
                    'province' => 'Jawa Barat',
                    'target_amount' => $e['target'],
                    'collected_amount' => $e['collected'],
                    'end_date' => Carbon::now()->addDays(rand(15, 60)),
                    'status' => 'active',
                ]
            );
        }
    }
}
