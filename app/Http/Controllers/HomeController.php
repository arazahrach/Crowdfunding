<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // 1) HERO SLIDES
        // Kalau kamu belum punya tabel hero_slides, kita generate dari campaign terbaru (atau fallback dummy)
        $slides = Campaign::query()
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get(['id', 'title', 'description', 'image', 'slug'])
            ->map(function ($c) {
                return [
                    'title' => $this->nl2($c->title, 22),
                    'subtitle' => $c->description ? $this->trimWords($c->description, 14) : 'Mari bantu bersama',
                    'image' => $this->imgUrl($c->image),
                    'link'  => $c->slug
                        ? route('donation.show', $c->slug)
                        : '#', // kalau slug belum ada
                ];
            })
            ->values()
            ->toArray();

        if (count($slides) === 0) {
            // fallback kalau DB kosong
            $slides = [
                [
                    'title' => "Solidaritas Sesama\nuntuk korban Banjir\ndi Jakarta",
                    'subtitle' => "Mari bantu saudara bangkit dari musibah",
                    'image' => 'https://images.unsplash.com/photo-1509099836639-18ba02c6d1d8?auto=format&fit=crop&w=1600&q=60',
                    'link'  => '#urgent',
                ],
            ];
        }

        // 2) URGENT CAMPAIGNS (yang mendekati end_date atau yang progressnya belum penuh)
        $urgentCampaigns = Campaign::query()
            ->where('is_active', true)
            ->orderByRaw('end_date is null, end_date asc') // yang ada end_date diutamakan
            ->take(10)
            ->get(['id', 'title', 'image', 'target_amount', 'collected_amount', 'slug'])
            ->map(function ($c) {
                $target = (int) ($c->target_amount ?? 0);
                $collected = (int) ($c->collected_amount ?? 0);
                $progress = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

                return [
                    'title' => $c->title,
                    'location' => $c->location_city ?? $c->location_province ?? 'Indonesia', // kalau ada kolom lokasi, dia kepake
                    'image' => $this->imgUrl($c->image),
                    'target' => $target,
                    'collected' => $collected,
                    'progress' => $progress,
                    'link' => $c->slug ? route('donation.show', $c->slug) : '#',
                ];
            })
            ->values();

        // 3) CATEGORIES (kalau tabel categories belum ada, fallback dummy)
        $categories = collect();
        if (class_exists(Category::class)) {
            try {
                $categories = Category::query()
                    ->orderBy('name')
                    ->take(4)
                    ->get(['name', 'slug', 'icon']);
            } catch (\Throwable $e) {
                // ignore kalau tabel belum dimigrate
            }
        }

        if ($categories->isEmpty()) {
            $categories = collect([
                (object) ['name' => 'Fasilitas', 'icon' => '🏫', 'slug' => null],
                (object) ['name' => 'Beasiswa', 'icon' => '🎓', 'slug' => null],
                (object) ['name' => 'Alat Belajar', 'icon' => '✏️', 'slug' => null],
                (object) ['name' => 'Tingkat Sekolah', 'icon' => '🧭', 'slug' => null],
            ]);
        }

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
