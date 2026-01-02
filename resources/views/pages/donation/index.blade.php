@extends('layouts.app', ['title' => 'Donasi'])

@section('content')
@php
  // DUMMY LIST (nanti dari DB campaigns)
  $items = [
    [
      'slug' => 'renovasi-kelas-harapan-jaya',
      'title' => 'Renovasi Ruang Kelas SD Negeri Harapan Jaya',
      'city' => 'Jakarta',
      'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
      'target' => 30000000,
      'collected' => 15600000,
    ],
    [
      'slug' => 'kursi-meja-darurat',
      'title' => 'Pengadaan Kursi & Meja Darurat untuk Siswa Korban…',
      'city' => 'Bekasi',
      'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80',
      'target' => 20000000,
      'collected' => 9800000,
    ],
    [
      'slug' => 'bangun-ulang-ruang-kelas',
      'title' => 'Pembangunan Ulang Ruang Kelas yang Rusak Akibat…',
      'city' => 'Bogor',
      'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1200&q=80',
      'target' => 45000000,
      'collected' => 22500000,
    ],
  ];

  function rupiah($n){ return 'Rp '.number_format($n,0,',','.'); }
@endphp

<div class="max-w-6xl mx-auto">
  <div class="flex items-end justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Donasi</h1>
      <p class="mt-1 text-sm text-slate-500">Pilih penggalangan dana yang ingin kamu bantu.</p>
    </div>

    <a href="{{ route('home') }}"
       class="text-sm font-semibold text-teal-700 hover:underline">
      Kembali ke Beranda
    </a>
  </div>

  <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($items as $it)
      @php
        $p = min(100, round($it['collected'] / $it['target'] * 100));
      @endphp

      <a href="{{ route('donation.show', $it['slug']) }}"
         class="group rounded-2xl bg-white border border-slate-200 overflow-hidden hover:shadow-sm transition">
        <div class="aspect-[16/10] overflow-hidden">
          <img src="{{ $it['image'] }}" alt=""
               class="h-full w-full object-cover group-hover:scale-[1.02] transition">
        </div>

        <div class="p-4">
          <div class="text-sm font-semibold text-slate-800 line-clamp-2">
            {{ $it['title'] }}
          </div>

          <div class="mt-2 text-xs text-slate-500">{{ $it['city'] }}</div>

          <div class="mt-4">
            <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
              <div class="h-full bg-teal-700" style="width: {{ $p }}%"></div>
            </div>

            <div class="mt-2 flex items-center justify-between text-xs">
              <span class="text-slate-600">Terkumpul</span>
              <span class="font-semibold text-slate-800">{{ $p }}%</span>
            </div>

            <div class="mt-1 flex items-center justify-between text-xs text-slate-600">
              <span>{{ rupiah($it['collected']) }}</span>
              <span>dari {{ rupiah($it['target']) }}</span>
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
    @endforeach
  </div>

  {{-- NOTES (DB nanti)
  - items dari table campaigns
  - slug bisa dari title (Str::slug)
  - image bisa dari storage atau url
  --}}
</div>
@endsection
