@extends('layouts.app')

@section('content')
@php
  $title = $campaign->title ?? 'Donasi';
@endphp

<div class="max-w-xl mx-auto px-4 md:px-0 py-6">
  <div class="text-center">
    <div class="text-sm text-slate-500">Donasi untuk</div>
    <h1 class="mt-1 text-lg font-bold text-slate-800">{{ $title }}</h1>
  </div>

  <form method="POST" action="{{ route('donation.donate.store', $slug) }}"
        class="mt-6 rounded-2xl bg-white border border-slate-200 p-6">
    @csrf

    <div class="text-center font-semibold text-slate-800">Masukan Nominal Donasi</div>

    @if ($errors->any())
      <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        {{ $errors->first() }}
      </div>
    @endif

    <div x-data="donateForm()" class="mt-4 grid gap-3">
      <div class="grid gap-2">
        @foreach ([30000, 50000, 100000] as $amt)
          <button type="button"
            class="w-full rounded-xl border border-slate-200 bg-white py-3 text-sm font-semibold hover:bg-slate-50"
            @click="setAmount({{ $amt }})"
          >
            Rp{{ number_format($amt,0,',','.') }}
          </button>
        @endforeach
      </div>

      <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
        <div class="text-xs text-slate-500 mb-2">Nominal lain</div>
        <div class="flex items-center gap-2">
          <span class="text-sm font-semibold text-slate-700">Rp</span>
          <input type="number" min="10000" name="amount" x-model="amount"
                 placeholder="0"
                 class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        </div>
        <div class="text-[11px] text-slate-400 mt-2">Minimal nominal Rp10.000</div>
      </div>

      <div class="grid gap-2">
        <input name="name" value="{{ old('name') }}" placeholder="Nama (opsional)"
               class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        <input name="email" value="{{ old('email') }}" placeholder="Email (opsional)"
               class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        <input name="phone" value="{{ old('phone') }}" placeholder="No HP (opsional)"
               class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">

        <input name="message" value="{{ old('message') }}" placeholder="Pesan (opsional)"
               class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">

        <label class="flex items-center gap-2 text-sm text-slate-600">
          <input type="checkbox" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
          Sembunyikan nama (anonim)
        </label>
      </div>
    </div>

    <div class="mt-5 flex justify-center">
      <button class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
        Selanjutnya
      </button>
    </div>
  </form>
</div>
@endsection
