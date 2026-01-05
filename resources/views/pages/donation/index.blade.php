@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
@endphp

<div class="max-w-6xl mx-auto px-4 md:px-0 py-6">
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Donasi</h1>
      <p class="mt-1 text-sm text-slate-500">Pilih penggalangan dana yang ingin kamu bantu.</p>
    </div>

    <form method="GET" action="{{ route('donation.index') }}" class="flex gap-2">
      <input
        name="q"
        value="{{ $q ?? '' }}"
        placeholder="Cari penggalangan dana..."
        class="w-full md:w-80 rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
      >
      <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
        Cari
      </button>
    </form>
  </div>

  <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($campaigns as $c)
      @php
        $target = (int) ($c->target_amount ?? 0);
        $collected = (int) ($c->collected_amount ?? 0);
        $p = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

        $img = $c->image ?? null;
        if (!$img) $img = 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';

        $location = $c->location_city ?? $c->location_province ?? $c->location ?? 'Indonesia';
        $slugOrId = $c->slug ?? $c->id;
      @endphp

      <a href="{{ route('donation.show', $slugOrId) }}"
         class="group rounded-2xl bg-white border border-slate-200 overflow-hidden hover:shadow-sm transition">
        <div class="aspect-[16/10] overflow-hidden">
          <img src="{{ $img }}" alt="{{ $c->title }}"
               class="h-full w-full object-cover group-hover:scale-[1.02] transition">
        </div>

        <div class="p-4">
          <div class="text-sm font-semibold text-slate-800 line-clamp-2">
            {{ $c->title }}
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
        Belum ada penggalangan dana. Login lalu buat “Galang Dana” dulu 😄
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $campaigns->links() }}
  </div>
</div>
@endsection
