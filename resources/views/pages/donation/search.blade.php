@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }

  // helper buat build query tanpa kehilangan parameter
  function qurl($overrides = []) {
    return request()->fullUrlWithQuery($overrides);
  }
@endphp

<div class="max-w-6xl mx-auto px-4 md:px-0 py-6">
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Cari Penggalangan Dana</h1>
      <p class="mt-1 text-sm text-slate-500">Temukan campaign berdasarkan kategori, target, dan urutan yang kamu mau.</p>
    </div>
  </div>

  {{-- FILTER BAR --}}
  <form method="GET" action="{{ route('donation.index') }}"
        class="mt-6 rounded-2xl border border-slate-200 bg-white p-4">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
      {{-- search --}}
      <div class="md:col-span-5">
        <label class="text-xs font-semibold text-slate-600">Kata kunci</label>
        <input name="q" value="{{ $q ?? '' }}" placeholder="misal: banjir, sekolah, beasiswa..."
               class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
      </div>

      {{-- category --}}
      <div class="md:col-span-3">
        <label class="text-xs font-semibold text-slate-600">Kategori</label>
        <select name="category"
                class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          <option value="">Semua</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->slug }}" {{ ($category ?? '') === $cat->slug ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- sort --}}
      <div class="md:col-span-2">
        <label class="text-xs font-semibold text-slate-600">Urutkan</label>
        <select name="sort"
                class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          <option value="newest"   {{ ($sort ?? 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
          <option value="ending"   {{ ($sort ?? '') === 'ending' ? 'selected' : '' }}>Mendesak</option>
          <option value="popular"  {{ ($sort ?? '') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
          <option value="collected"{{ ($sort ?? '') === 'collected' ? 'selected' : '' }}>Terkumpul Terbanyak</option>
          <option value="target"   {{ ($sort ?? '') === 'target' ? 'selected' : '' }}>Target Terbesar</option>
        </select>
      </div>

      {{-- range --}}
      <div class="md:col-span-2">
        <label class="text-xs font-semibold text-slate-600">Target (Rp)</label>
        <div class="mt-1 flex gap-2">
          <input name="min" value="{{ $min ?? '' }}" inputmode="numeric" placeholder="Min"
                 class="w-1/2 rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          <input name="max" value="{{ $max ?? '' }}" inputmode="numeric" placeholder="Max"
                 class="w-1/2 rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        </div>
      </div>
    </div>

    <div class="mt-4 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
      <div class="flex flex-wrap gap-2">
        {{-- quick chips: kategori 4 --}}
        <a href="{{ qurl(['category' => '', 'page' => 1]) }}"
           class="px-3 py-1 rounded-full text-xs font-semibold border {{ ($category ?? '')==='' ? 'bg-teal-700 text-white border-teal-700' : 'bg-white text-slate-700 border-slate-200' }}">
          Semua
        </a>

        @foreach ($categories->take(4) as $cat)
          <a href="{{ qurl(['category' => $cat->slug, 'page' => 1]) }}"
             class="px-3 py-1 rounded-full text-xs font-semibold border {{ ($category ?? '')===$cat->slug ? 'bg-teal-700 text-white border-teal-700' : 'bg-white text-slate-700 border-slate-200' }}">
            {{ $cat->name }}
          </a>
        @endforeach
      </div>

      <div class="flex gap-2">
        <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
          Terapkan
        </button>

        <a href="{{ route('donation.index') }}"
           class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
          Reset
        </a>
      </div>
    </div>
  </form>

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
        $collected = (int) ($c->collected_amount ?? 0);
        $p = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

        $img = $c->image ?: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
        $location = $c->location_city ?? $c->location_province ?? $c->location ?? 'Indonesia';
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
        Tidak ada campaign yang cocok. Coba ganti kata kunci / filter kamu.
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $campaigns->links() }}
  </div>
</div>
@endsection
