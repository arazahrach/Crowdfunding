@php
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
                // support array atau model
                $title = $c['title'] ?? $c->title ?? 'Campaign';
                $image = $c['image'] ?? $c->image ?? 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
                $location = $c['location'] ?? ($c->location_city ?? $c->location_province ?? 'Indonesia');
                $target = (int) ($c['target'] ?? $c->target_amount ?? 0);
                $collected = (int) ($c['collected'] ?? $c->collected_sum ?? 0);
                $progress = $c['progress'] ?? ($target > 0 ? min(100, round(($collected / $target) * 100)) : 0);
                $link = $c['link'] ?? (isset($c->slug) ? route('donation.show', $c->slug) : '#');
            @endphp

            <a href="{{ $link }}"
               class="block min-w-[260px] max-w-[260px] bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition">
                <img src="{{ $image }}" alt="{{ $title }}" class="h-32 w-full object-cover">

                <div class="p-3">
                    <h3 class="text-sm font-semibold leading-snug line-clamp-2">{{ $title }}</h3>

                    <p class="mt-1 text-xs text-slate-500">{{ $location }}</p>

                    <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                        <span>Terkumpul</span>
                        <span class="font-semibold text-slate-700">{{ $progress }}%</span>
                    </div>

                    <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-teal-600 transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>

                    <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                        <span class="truncate">Rp {{ number_format($collected, 0, ',', '.') }}</span>
                        <span class="font-semibold text-slate-700">dari Rp {{ number_format($target, 0, ',', '.') }}</span>
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
