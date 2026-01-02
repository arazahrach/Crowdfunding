@php
    /**
     * DUMMY DATA dulu yaa (buat presentasi).
     * Nanti kalau udah siap DB, ganti $slides ini dari controller.
     */
    $slides = [
        [
            'title' => "Solidaritas Sesama\nuntuk korban Banjir\ndi Jakarta",
            'subtitle' => "Mari bantu saudara bangkit dari musibah",
            'image' => 'https://images.unsplash.com/photo-1509099836639-18ba02c6d1d8?auto=format&fit=crop&w=1600&q=60',
        ],
        [
            'title' => "Bantu Renovasi\nRuang Kelas\nSekolah Pinggiran",
            'subtitle' => "Akses belajar yang nyaman untuk anak-anak",
            'image' => 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=1600&q=60',
        ],
        [
            'title' => "Alat Belajar\nuntuk Siswa\nKorban Bencana",
            'subtitle' => "Satu paket alat tulis = satu harapan",
            'image' => 'https://images.unsplash.com/photo-1455885666463-8919a3f0c3c1?auto=format&fit=crop&w=1600&q=60',
        ],
        [
            'title' => "Beasiswa\nAnak Berprestasi\nKeluarga Rentan",
            'subtitle' => "Bantu biaya sekolah & kebutuhan belajar",
            'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=60',
        ],
        [
            'title' => "Perbaikan\nFasilitas Sekolah\nyang Rusak",
            'subtitle' => "Bangun kembali ruang belajar yang aman",
            'image' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=1600&q=60',
        ],
    ];
@endphp

<section
    x-data="heroSlider({{ json_encode($slides) }})"
    x-init="start()"
    class="relative overflow-hidden rounded-2xl bg-teal-700"
>
    <div
        class="h-[220px] md:h-[280px] w-full bg-cover bg-center transition-all duration-700"
        :style="`background-image:url('${slides[current].image}')`"
    ></div>

    {{-- overlay gelap biar teks kebaca --}}
    <div class="absolute inset-0 bg-black/35 pointer-events-none"></div>

    {{-- Overlay content --}}
    <div class="absolute inset-0 flex items-center z-10">
        <div class="p-6 md:p-10 max-w-xl text-white">
            <h1 class="text-2xl md:text-4xl font-extrabold leading-tight whitespace-pre-line"
                x-text="slides[current].title"></h1>

            <p class="mt-2 text-sm md:text-base text-white/90"
               x-text="slides[current].subtitle"></p>

            <div class="mt-5 flex gap-2">
                <a href="#urgent"
                   class="inline-flex items-center justify-center rounded-full bg-white px-5 py-2 text-sm font-semibold text-teal-800 hover:bg-white/90">
                    Donasi Sekarang
                </a>
                <a href="#"
                   class="inline-flex items-center justify-center rounded-full border border-white/60 px-5 py-2 text-sm font-semibold text-white hover:bg-white/10">
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>

    {{-- Prev/Next --}}
    <button type="button"
        class="absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/30 text-white hover:bg-black/40 z-20"
        @click="prev()"
        aria-label="Previous"
    >‹</button>

    <button type="button"
        class="absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/30 text-white hover:bg-black/40 z-20"
        @click="next()"
        aria-label="Next"
    >›</button>

    {{-- Dots --}}
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-20">
        <template x-for="(s, i) in slides" :key="i">
            <button type="button"
                class="h-2 w-2 rounded-full"
                :class="i === current ? 'bg-white/90' : 'bg-white/40'"
                @click="go(i)"
                :aria-label="`Go to slide ${i+1}`"
            ></button>
        </template>
    </div>
</section>

{{-- NOTES (NANTI AMBIL DARI DATABASE) --}}
{{--
Controller (contoh):
$slides = HeroSlide::where('is_active', true)->orderBy('priority')->take(5)->get()
    ->map(fn($s)=>[
        'title' => $s->title,
        'subtitle' => $s->subtitle,
        'image' => Storage::url($s->image_path),
    ])->toArray();

return view('pages.home.index', compact('slides'));

Lalu di blade:
x-data="heroSlider(@js($slides))"
--}}
