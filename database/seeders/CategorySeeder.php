<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Alat Belajar',     'icon' => 'pencil'],
            ['name' => 'Beasiswa',        'icon' => 'graduation-cap'],
            ['name' => 'Fasilitas',       'icon' => 'building'],
            ['name' => 'Tingkat Sekolah', 'icon' => 'school'],
        ];

        foreach ($items as $it) {
            Category::updateOrCreate(
                ['slug' => Str::slug($it['name'])],
                ['name' => $it['name'], 'icon' => $it['icon']]
            );
        }
    }

    public function campaigns()
    {
        return $this->hasMany(\App\Models\Campaign::class);
    }

}
