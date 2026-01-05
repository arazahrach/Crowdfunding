@php
  // helper buat build query tanpa kehilangan parameter
  function qurl($overrides = []) {
    return request()->fullUrlWithQuery($overrides);
  }
@endphp

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
        <option value="newest"    {{ ($sort ?? 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
        <option value="ending"    {{ ($sort ?? '') === 'ending' ? 'selected' : '' }}>Mendesak</option>
        <option value="popular"   {{ ($sort ?? '') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
        <option value="collected" {{ ($sort ?? '') === 'collected' ? 'selected' : '' }}>Terkumpul Terbanyak</option>
        <option value="target"    {{ ($sort ?? '') === 'target' ? 'selected' : '' }}>Target Terbesar</option>
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
