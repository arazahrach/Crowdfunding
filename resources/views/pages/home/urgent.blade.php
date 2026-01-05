@php
    // dari controller: $urgentCampaigns
    // fallback jika belum ada
    $urgentCampaigns = $urgentCampaigns ?? collect();
@endphp

<section id="urgent" class="mt-8">
    <div class="flex items-center gap-2 text-red-600 font-semibold">
        <span>⏰</span>
        <h2>Penggalangan Mendesak</h2>
    </div>

    <div class="mt-4 flex gap-4 overflow-x-auto pb-2">
        @forelse ($urgentCampaigns as $c)
            @php
                $progress = $c['progress'] ?? (isset($c['target'], $c['collected']) && $c['target'] > 0
                    ? min(100, round(($c['collected'] / $c['target']) * 100))
                    : 0);
            @endphp

            <a href="{{ $c['link'] ?? '#' }}"
               class="block min-w-[260px] max-w-[260px] bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition">
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
                        {{ $c['location'] ?? 'Indonesia' }}
                    </p>

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
                        <span class="truncate">Rp {{ number_format($c['collected'] ?? 0, 0, ',', '.') }}</span>
                        <span class="font-semibold text-slate-700">
                            dari Rp {{ number_format($c['target'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-sm text-slate-500">
                Belum ada campaign. Coba buat satu dulu 😄
            </div>
        @endforelse
    </div>
</section>
