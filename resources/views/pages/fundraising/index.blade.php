@extends('layouts.app', ['title' => 'Galang Dana Saya'])

@section('content')
@php
  $items = [
    [
      'slug' => 'renovasi-kelas-harapan-jaya',
      'title' => 'Renovasi Ruang Kelas SD Negeri Harapan Jaya',
      'status' => 'Aktif',
      'target' => 100000000,
      'collected' => 23780000,
      'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80',
    ],
    [
      'slug' => 'kursi-meja-darurat',
      'title' => 'Pengadaan Kursi & Meja Darurat untuk Siswa Korban…',
      'status' => 'Pending',
      'target' => 20000000,
      'collected' => 0,
      'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
    ],
  ];
  function rupiah($n){ return 'Rp '.number_format($n,0,',','.'); }
@endphp

<div class="max-w-6xl mx-auto">
  <div class="flex items-end justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Galang Dana Saya</h1>
      <p class="mt-1 text-sm text-slate-500">Daftar penggalangan dana yang kamu buat.</p>
    </div>

    <a href="{{ route('fundraising.create') }}"
       class="rounded-full bg-teal-700 px-5 py-2 text-sm font-semibold text-white hover:bg-teal-800">
      + Buat Baru
    </a>
  </div>

  <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($items as $it)
      @php
        $p = $it['target'] ? min(100, round($it['collected'] / $it['target'] * 100)) : 0;
        $statusClass = $it['status'] === 'Aktif'
          ? 'bg-teal-50 text-teal-800 border-teal-200'
          : 'bg-amber-50 text-amber-800 border-amber-200';
      @endphp

      <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden">
        <div class="aspect-[16/10] overflow-hidden">
          <img src="{{ $it['image'] }}" alt="" class="h-full w-full object-cover">
        </div>

        <div class="p-4">
          <div class="flex items-center justify-between gap-2">
            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}">
              {{ $it['status'] }}
            </span>
            <a href="{{ route('fundraising.edit', $it['slug']) }}"
               class="text-xs font-semibold text-teal-700 hover:underline">
              Edit
            </a>
          </div>

          <div class="mt-3 text-sm font-semibold text-slate-800 line-clamp-2">
            {{ $it['title'] }}
          </div>

          <div class="mt-4">
            <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
              <div class="h-full bg-teal-700" style="width: {{ $p }}%"></div>
            </div>
            <div class="mt-2 flex items-center justify-between text-xs text-slate-600">
              <span>{{ rupiah($it['collected']) }}</span>
              <span>dari {{ rupiah($it['target']) }}</span>
            </div>
          </div>

          <div class="mt-4 flex justify-end">
            <a href="{{ route('fundraising.show', $it['slug']) }}"
               class="text-xs font-semibold text-teal-700 hover:underline">
              Lihat Detail →
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- NOTES (DB nanti)
  - items = campaigns milik user login (user_id)
  --}}
</div>
@endsection
