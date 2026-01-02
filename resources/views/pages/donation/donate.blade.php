@extends('layouts.app', ['title' => 'Donasi Sekarang'])

@section('content')
@php
  $title = 'Renovasi Ruang Kelas SD Negeri Harapan Jaya';
@endphp

<div class="max-w-3xl mx-auto">
  <a href="{{ route('donation.show', $slug) }}"
     class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
    ←
  </a>

  <div class="mt-4 text-center">
    <div class="text-sm text-slate-500">Donasi Sekarang</div>
    <div class="mt-2 font-semibold text-teal-800">{{ $title }}</div>
  </div>

  <div class="mt-6 rounded-2xl bg-white border border-slate-200 p-6">
    <div class="text-center font-semibold text-slate-800">Masukan Nominal Donasi</div>

    <div class="mt-4 grid gap-3">
      @foreach ([30000, 50000, 100000] as $amt)
        <button type="button"
          class="w-full rounded-xl border border-slate-200 bg-white py-3 text-sm font-semibold hover:bg-slate-50">
          Rp{{ number_format($amt,0,',','.') }}
        </button>
      @endforeach

      <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
        <div class="text-xs text-slate-500 mb-2">Nominal lain</div>
        <div class="flex items-center gap-2">
          <span class="text-sm font-semibold text-slate-700">Rp</span>
          <input type="number" placeholder="0"
                 class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        </div>
        <div class="text-[11px] text-slate-400 mt-2">Minimal nominal Rp10.000</div>
      </div>
    </div>

    <div class="mt-5 flex justify-center">
      <button class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
        Selanjutnya
      </button>
    </div>

    {{-- NOTES (Midtrans nanti)
    - tombol Selanjutnya akan create donation record (pending)
    - panggil Midtrans Snap token dari backend
    - redirect / open snap popup
    --}}
  </div>
</div>
@endsection
