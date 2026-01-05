@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
@endphp


<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-6xl mx-auto px-4 py-6">

    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Galang Dana Saya</h1>
        <p class="mt-1 text-sm text-slate-500">Hanya menampilkan galang dana yang kamu buat.</p>
      </div>

      <a href="{{ route('fundraising.create') }}"
         class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
        + Buat Galang Dana
      </a>
    </div>

    {{-- optional search kecil --}}
    <form method="GET" class="mt-4">
      <input name="q" value="{{ $q ?? '' }}" placeholder="Cari galang dana kamu..."
             class="w-full md:w-96 rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
    </form>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($campaigns as $c)
        @php
          $target = (int) ($c->target_amount ?? 0);
          $collected = (int) ($c->collected_sum ?? 0); // dari controller (withSum)
          $p = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

          $img = $c->image ?: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
        @endphp

        <a href="{{ route('fundraising.show', $c->slug) }}"
           class="group rounded-2xl bg-white border border-slate-200 overflow-hidden hover:shadow-sm transition">
          <div class="aspect-[16/10] overflow-hidden">
            <img src="{{ $img }}" class="h-full w-full object-cover group-hover:scale-[1.02] transition" alt="">
          </div>

          <div class="p-4">
            <div class="text-sm font-semibold text-slate-800 line-clamp-2">{{ $c->title }}</div>
            <div class="mt-2 text-xs text-slate-500">{{ $c->city ?? $c->province ?? 'Indonesia' }}</div>

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
                {{ $c->status ?? 'active' }}
              </span>
              <span class="text-xs font-semibold text-teal-700 group-hover:underline">
                Lihat Detail →
              </span>
            </div>
          </div>
        </a>
      @empty
        <div class="text-sm text-slate-500">
          Kamu belum membuat galang dana. Klik “Buat Galang Dana”.
        </div>
      @endforelse
    </div>

    <div class="mt-6">
      {{ $campaigns->links() }}
    </div>

  </div>
</div>
@endsection
