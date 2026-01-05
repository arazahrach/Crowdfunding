<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1) Categories untuk section kategori
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        // 2) Urgent campaigns: contoh rule "mendesak" = end_date paling dekat
        // + hitung terkumpul dari donations status=paid
        $urgentModels = Campaign::query()
            ->with(['category'])
            ->withSum(['donations as collected_sum' => function ($q) {
                $q->where('status', 'paid');
            }], 'amount')
            ->whereNotNull('end_date')
            ->orderBy('end_date', 'asc')
            ->limit(8)
            ->get();

        // Siapkan format data untuk urgent.blade.php (lebih aman karena urgent view kamu pakai array keys)
        $urgentCampaigns = $urgentModels->map(function ($c) {
            $target = (int) ($c->target_amount ?? 0);
            $collected = (int) ($c->collected_sum ?? 0);
            $progress = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

            $img = $c->image ?: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
            $location = $c->city ?? $c->location_city ?? $c->province ?? $c->location_province ?? 'Indonesia';
            $slugOrId = $c->slug ?? $c->id;

            return [
                'title' => $c->title,
                'image' => $img,
                'location' => $location,
                'target' => $target,
                'collected' => $collected,
                'progress' => $progress,
                'link' => route('donation.show', $slugOrId),
            ];
        });

        // 3) Slides untuk hero (bisa statis dulu, nanti bisa tarik dari campaign featured)
        $slides = [
            [
                'title' => "Solidaritas Sesama\nuntuk Pendidikan",
                'subtitle' => "Bantu sekolah, beasiswa, dan fasilitas belajar di Indonesia",
                'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=60',
                'link' => route('donation.index'),
            ],
            [
                'title' => "Mulai Galang Dana",
                'subtitle' => "Ajak orang lain bantu tujuan baikmu",
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1600&q=60',
                'link' => route('fundraising.create'),
            ],
        ];

        return view('pages.home.index', compact('slides', 'urgentCampaigns', 'categories'));
    }



    private function imgUrl(?string $path): string
    {
        if (!$path) {
            return 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=1200&q=60';
        }

        // kalau kamu simpan full URL di DB, langsung pakai
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // kalau simpan path di storage
        return Storage::url($path);
    }

    private function trimWords(string $text, int $maxWords): string
    {
        $words = preg_split('/\s+/', strip_tags($text));
        if (!$words) return '';
        if (count($words) <= $maxWords) return implode(' ', $words);
        return implode(' ', array_slice($words, 0, $maxWords)) . '...';
    }

    private function nl2(string $text, int $everyNChars): string
    {
        // biar title hero enak (mirip dummy kamu yang pakai \n)
        $text = trim($text);
        if (mb_strlen($text) <= $everyNChars) return $text;
        $out = '';
        $len = mb_strlen($text);
        for ($i = 0; $i < $len; $i += $everyNChars) {
            $out .= mb_substr($text, $i, $everyNChars) . "\n";
        }
        return trim($out);
    }
}
