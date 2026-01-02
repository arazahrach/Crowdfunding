@php
    /**
     * DUMMY DATA dulu yaa (buat UI & presentasi)
     * Nanti data ini diambil dari table campaigns
     */
    $campaigns = [
        [
            'title' => 'Renovasi Ruang Kelas SD Negeri Harapan Jaya',
            'location' => 'Jakarta',
            'image' => 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=800&q=60',
            'target' => 30000000,
            'collected' => 15600000,
        ],
        [
            'title' => 'Pengadaan Kursi dan Meja Darurat untuk Siswa Korban Banjir',
            'location' => 'Bekasi',
            'image' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=800&q=60',
            'target' => 20000000,
            'collected' => 9800000,
        ],
        [
            'title' => 'Pembangunan Ulang Ruang Kelas yang Rusak Akibat Longsor',
            'location' => 'Bogor',
            'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=60',
            'target' => 45000000,
            'collected' => 22500000,
        ],
    ];
@endphp

<section id="urgent" class="mt-8">
    {{-- Section title --}}
    <div class="flex items-center gap-2 text-red-600 font-semibold">
        <span>⏰</span>
        <h2>Penggalangan Mendesak</h2>
    </div>

    {{-- Cards --}}
    <div class="mt-4 flex gap-4 overflow-x-auto pb-2">
        @foreach ($campaigns as $c)
            @php
                $progress = min(100, round(($c['collected'] / $c['target']) * 100));
            @endphp

            <article
                class="min-w-[260px] max-w-[260px] bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition"
            >
                <img
                    src="{{ $c['image'] }}"
                    alt="{{ $c['title'] }}"
                    class="h-32 w-full object-cover"
                >

                <div class="p-3">
                    <h3 class="text-sm font-semibold leading-snug line-clamp-2">
                        {{ $c['title'] }}
                    </h3>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $c['location'] }}
                    </p>

                    {{-- Progress bar --}}
                    <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>Terkumpul</span>
                            <span class="font-semibold text-slate-700">{{ $progress }}%</span>
                        </div>

                        <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div
                                class="h-full bg-teal-600 transition-all duration-500"
                                style="width: {{ $progress }}%"
                            ></div>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                            <span class="truncate">Rp {{ number_format($c['collected'], 0, ',', '.') }}</span>
                            <span class="font-semibold text-slate-700">
                                dari Rp {{ number_format($c['target'], 0, ',', '.') }}
                            </span>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- NOTES (NANTI AMBIL DARI DATABASE) --}}
{{--
Controller (contoh):
$campaigns = Campaign::where('is_active', true)
    ->where('is_featured', true)
    ->orderBy('created_at', 'desc')
    ->take(6)
    ->get();

Blade:
@foreach ($campaigns as $c)
    $c->title
    $c->location
    Storage::url($c->image)
    $c->target_amount
    $c->collected_amount
@endforeach
--}}
