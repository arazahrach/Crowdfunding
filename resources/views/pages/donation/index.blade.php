@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
@endphp

<div class="max-w-6xl mx-auto px-4 md:px-0 py-6">
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Cari Penggalangan Dana</h1>
      <p class="mt-1 text-sm text-slate-500">Temukan campaign berdasarkan kategori, target, dan urutan yang kamu mau.</p>
    </div>
  </div>

  @include('pages.donation.search')

  {{-- RESULT META --}}
  <div class="mt-5 flex items-center justify-between">
    <div class="text-sm text-slate-600">
      Menampilkan <span class="font-semibold">{{ $campaigns->count() }}</span> dari
      <span class="font-semibold">{{ $campaigns->total() }}</span> campaign
      @if(!empty($q)) • untuk “<span class="font-semibold">{{ $q }}</span>” @endif
    </div>
  </div>

  {{-- GRID --}}
  <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($campaigns as $c)
      @php
        $target = (int) ($c->target_amount ?? 0);

        $collected = (int) ($c->collected_sum ?? 0);

        $p = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

        $img = $c->image ?: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
        $location = $c->city ?? $c->province ?? 'Indonesia';
        $slugOrId = $c->slug ?? $c->id;

        $catName = optional($c->category)->name;
      @endphp

      <a href="{{ route('donation.show', $slugOrId) }}"
         class="group rounded-2xl bg-white border border-slate-200 overflow-hidden hover:shadow-sm transition">
        <div class="aspect-[16/10] overflow-hidden">
          <img src="{{ $img }}" alt="{{ $c->title }}"
               class="h-full w-full object-cover group-hover:scale-[1.02] transition">
        </div>

        <div class="p-4">
          <div class="flex items-start justify-between gap-2">
            <div class="text-sm font-semibold text-slate-800 line-clamp-2">
              {{ $c->title }}
            </div>

            @if($catName)
              <span class="shrink-0 rounded-full bg-teal-50 text-teal-800 px-3 py-1 text-[11px] font-semibold">
                {{ $catName }}
              </span>
            @endif
          </div>

          <div class="mt-2 text-xs text-slate-500">{{ $location }}</div>

          <div class="mt-4">
            <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
              <div class="h-full bg-teal-700" style="width: {{ $p }}%"></div>
            </div>

            <div class="mt-2 flex items-center justify-between text-xs">
              <span class="text-slate-600">Terkumpul</span>
              <span class="font-semibold text-slate-800">{{ $p }}%</span>
            </div>

            <div class="mt-1 flex items-center justify-between text-xs text-slate-600">
              <span>{{ rupiah($collected) }}</span>
              <span>dari {{ rupiah($target) }}</span>
            </div>
          </div>

          <div class="mt-4 flex items-center justify-between">
            <span class="inline-flex rounded-full bg-teal-50 text-teal-800 px-3 py-1 text-xs font-semibold">
              Donasi
            </span>
            <span class="text-xs font-semibold text-teal-700 group-hover:underline">
              Lihat Detail →
            </span>
          </div>
        </div>
      </a>
    @empty
      <div class="text-sm text-slate-500">
        Tidak ada campaign yang cocok. Coba ganti kata kunci.
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $campaigns->links() }}
  </div>
</div>
@endsection
