@extends('layouts.app', ['title' => 'Detail Galang Dana'])

@section('content')
@php
  $item = [
    'title' => 'Renovasi Ruang Kelas SD Negeri Harapan Jaya',
    'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80',
    'target' => 100000000,
    'collected' => 23780000,
    'status' => 'Aktif',
    'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit...'
  ];
  function rupiah($n){ return 'Rp '.number_format($n,0,',','.'); }
  $p = min(100, round($item['collected'] / $item['target'] * 100));
@endphp

<div class="max-w-3xl mx-auto">
  <a href="{{ route('fundraising.index') }}"
     class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
    ←
  </a>

  <div class="mt-4 rounded-3xl bg-white border border-slate-200 overflow-hidden">
    <img src="{{ $item['image'] }}" alt="" class="h-72 w-full object-cover">
    <div class="p-6">
      <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-slate-800">{{ $item['title'] }}</h1>
        <a href="{{ route('fundraising.edit', $slug) }}"
           class="rounded-full border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50">
          Edit
        </a>
      </div>

      <div class="mt-3 text-sm text-slate-600">{{ $item['desc'] }}</div>

      <div class="mt-5 grid grid-cols-2 gap-4 text-sm">
        <div>
          <div class="text-slate-500">Terkumpul</div>
          <div class="font-semibold">{{ rupiah($item['collected']) }}</div>
          <div class="mt-2 h-2 rounded-full bg-slate-200 overflow-hidden">
            <div class="h-full bg-teal-700" style="width: {{ $p }}%"></div>
          </div>
        </div>
        <div class="text-right">
          <div class="text-slate-500">Target</div>
          <div class="font-semibold">{{ rupiah($item['target']) }}</div>
          <div class="mt-1 text-xs text-slate-500">Status: <span class="text-teal-700 font-semibold">{{ $item['status'] }}</span></div>
        </div>
      </div>
    </div>
  </div>

  {{-- NOTES (DB nanti)
  - show campaign by slug/id
  - authorization: hanya owner
  --}}
</div>
@endsection
