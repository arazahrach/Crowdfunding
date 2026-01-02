@extends('layouts.app', ['title' => 'Detail Donasi'])

@section('content')
@php
  // DUMMY (nanti dari DB)
  $campaign = [
    'title' => 'Renovasi Ruang Kelas SD Negeri Harapan Jaya',
    'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80',
    'donors' => 120,
    'days_left' => 18,
    'target' => 100000000,
    'collected' => 23780000,
    'organizer' => 'Telkom University',
    'location' => 'Jakarta',
  ];

  $progress = min(100, round($campaign['collected'] / $campaign['target'] * 100));
  $shortage = max(0, $campaign['target'] - $campaign['collected']);

  function rupiah($n){ return 'Rp '.number_format($n,0,',','.'); }
@endphp

<div class="max-w-3xl mx-auto">
  <a href="{{ route('home') }}"
     class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
    ←
  </a>

  <div class="mt-4 rounded-3xl overflow-hidden border border-slate-200 bg-white">
    <img src="{{ $campaign['image'] }}" alt="" class="h-72 w-full object-cover">
  </div>

  <h1 class="mt-4 text-center text-teal-800 font-semibold text-lg md:text-xl">
    {{ $campaign['title'] }}
  </h1>

  <div class="mt-4 grid grid-cols-3 gap-3 text-xs text-slate-600">
    <div class="flex items-center justify-center gap-2">
      <span>👥</span> <span>{{ $campaign['donors'] }} Donatur</span>
    </div>
    <div class="flex items-center justify-center gap-2">
      <span>⏳</span> <span>{{ $campaign['days_left'] }} Hari Tersisa</span>
    </div>
    <div class="flex items-center justify-center gap-2">
      <span>📍</span> <span>{{ $campaign['location'] }}</span>
    </div>
  </div>

  <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
    <div>
      <div class="text-slate-500">Terkumpul</div>
      <div class="font-semibold text-slate-800">{{ rupiah($campaign['collected']) }}</div>
      <div class="mt-2 h-2 rounded-full bg-slate-200 overflow-hidden">
        <div class="h-full bg-teal-700" style="width: {{ $progress }}%"></div>
      </div>
    </div>

    <div class="text-right">
      <div class="text-slate-500">Kekurangan</div>
      <div class="font-semibold text-slate-800">{{ rupiah($shortage) }}</div>
      <div class="text-xs text-slate-500 mt-2">Target: {{ rupiah($campaign['target']) }}</div>
    </div>
  </div>

  <div class="mt-6 text-center text-sm font-semibold text-teal-800">
    Informasi Penggalangan Dana
  </div>

  <div class="mt-3 rounded-2xl bg-white border border-slate-200 p-4">
    <div class="flex items-center gap-3">
      <div class="h-10 w-10 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-center">🏫</div>
      <div class="flex-1">
        <div class="text-sm font-semibold text-slate-800">{{ $campaign['organizer'] }}</div>
        <div class="text-xs text-slate-500">Penggalang Dana</div>
      </div>
      <span class="text-teal-700">✓</span>
    </div>

    <div class="mt-4 flex rounded-xl overflow-hidden border border-slate-200 text-sm">
      <a href="{{ route('donation.show', $slug) }}"
         class="flex-1 px-4 py-2 text-center bg-teal-700 text-white font-semibold">
        Deskripsi
      </a>
      <a href="{{ route('donation.updates', $slug) }}"
         class="flex-1 px-4 py-2 text-center bg-white text-slate-700 hover:bg-slate-50">
        Update
      </a>
    </div>

    <div class="mt-4 text-sm text-slate-600 leading-relaxed">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua…
    </div>
  </div>

  <div class="mt-5 flex justify-center gap-3">
    <button class="rounded-full border border-teal-600 px-6 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-50">
      Bagikan
    </button>
    <a href="{{ route('donation.donate', $slug) }}"
       class="rounded-full bg-teal-700 px-6 py-2 text-sm font-semibold text-white hover:bg-teal-800">
      Donasi Sekarang
    </a>
  </div>

  {{-- NOTES (DB nanti)
  - campaign: title, image, target_amount, collected_amount, days_left, organizer, location
  - progress = collected/target
  --}}
@endsection
