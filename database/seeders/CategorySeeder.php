<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Fasilitas',       'icon' => '🏫'],
            ['name' => 'Beasiswa',        'icon' => '🎓'],
            ['name' => 'Alat Belajar',    'icon' => '✏️'],
            ['name' => 'Tingkat Sekolah', 'icon' => '🧭'],
        ];

        foreach ($items as $it) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($it['name'])],
                [
                    'name' => $it['name'],
                    'slug' => Str::slug($it['name']),
                    'icon' => $it['icon'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
