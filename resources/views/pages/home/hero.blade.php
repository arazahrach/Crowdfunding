@php
    // dari controller: $slides
    // fallback kalau view dipanggil tanpa controller
    $slides = $slides ?? [
        [
            'title' => "Solidaritas Sesama\nuntuk korban Banjir\ndi Jakarta",
            'subtitle' => "Mari bantu saudara bangkit dari musibah",
            'image' => 'https://images.unsplash.com/photo-1509099836639-18ba02c6d1d8?auto=format&fit=crop&w=1600&q=60',
            'link'  => '#urgent',
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

    <div class="absolute inset-0 bg-black/35 pointer-events-none"></div>

    <div class="absolute inset-0 flex items-center z-10">
        <div class="p-6 md:p-10 max-w-xl text-white">
            <h1 class="text-2xl md:text-4xl font-extrabold leading-tight whitespace-pre-line"
                x-text="slides[current].title"></h1>

            <p class="mt-2 text-sm md:text-base text-white/90"
               x-text="slides[current].subtitle"></p>

            <div class="mt-5 flex gap-2">
                <a :href="slides[current].link ?? '#urgent'"
                   class="inline-flex items-center justify-center rounded-full bg-white px-5 py-2 text-sm font-semibold text-teal-800 hover:bg-white/90">
                    Donasi Sekarang
                </a>

                <a href="{{ route('donation.index') }}"
                   class="inline-flex items-center justify-center rounded-full border border-white/60 px-5 py-2 text-sm font-semibold text-white hover:bg-white/10">
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>

    {{-- tombol prev/next + dots tetap sama --}}
    <button type="button"
        class="absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/30 text-white hover:bg-black/40 z-20"
        @click="prev()" aria-label="Previous">‹</button>

    <button type="button"
        class="absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/30 text-white hover:bg-black/40 z-20"
        @click="next()" aria-label="Next">›</button>

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
