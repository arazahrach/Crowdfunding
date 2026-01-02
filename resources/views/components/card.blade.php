<div class="bg-white rounded-xl shadow-sm overflow-hidden w-[320px]">

    <img src="{{ $image ?? 'https://via.placeholder.com/400x240' }}" class="w-full h-40 object-cover">

    <div class="p-4">

        <h3 class="font-semibold mb-1">
            {{ $title ?? 'Judul Penggalangan Dana' }}
        </h3>

        <p class="text-sm text-slate-500 mb-2">
            {{ $subtitle ?? 'Deskripsi singkat penggalangan dana' }}
        </p>

        {{-- Progress Bar --}}
        <div class="w-full bg-slate-200 rounded-full h-2 mt-2">
            <div class="h-2 rounded-full bg-[var(--primary)]"
                 style="width: {{ $progress ?? '50' }}%"></div>
        </div>

        <div class="flex justify-between text-xs mt-2">
            <span>{{ $collected ?? '0' }} terkumpul</span>
            <span>{{ $days ?? '0 hari lagi' }}</span>
        </div>

    </div>
</div>
