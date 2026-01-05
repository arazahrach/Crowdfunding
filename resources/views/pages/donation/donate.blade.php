@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }

  $target    = (int) ($campaign->target_amount ?? 0);
  $collected = (int) ($collected ?? 0); // ✅ dari controller
  $progress  = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;
  $shortage  = max(0, $target - $collected);

  $img = $campaign->image ?: 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=1400&q=80';
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-md mx-auto px-4 py-6">

    <div class="mb-3">
      <a href="{{ route('donation.show', $slug) }}"
         class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">←</a>
    </div>

    <div class="rounded-2xl overflow-hidden bg-white shadow-sm border border-slate-100">
      <div class="aspect-[16/10] bg-slate-100">
        <img src="{{ $img }}" class="h-full w-full object-cover" alt="">
      </div>

      <div class="p-4">
        <h1 class="text-center font-semibold text-slate-800">{{ $campaign->title }}</h1>

        <div class="mt-4">
          <div class="flex items-end justify-between text-xs">
            <div>
              <div class="text-slate-500">Terkumpul</div>
              <div class="font-semibold text-slate-800">{{ rupiah($collected) }}</div>
            </div>
            <div class="text-right">
              <div class="text-slate-500">Kekurangan</div>
              <div class="font-semibold text-slate-800">{{ rupiah($shortage) }}</div>
            </div>
          </div>

          <div class="mt-2 h-2 w-full rounded-full bg-slate-200 overflow-hidden">
            <div class="h-full bg-teal-700" style="width: {{ $progress }}%"></div>
          </div>
        </div>

        <div class="mt-6 text-center font-semibold text-slate-700">
          Masukan Nominal Donasi
        </div>

        <form method="POST" action="{{ route('donation.donate.store', $slug) }}" class="mt-4">
          @csrf

          <div class="space-y-3">
            <button type="button" class="preset w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-left font-semibold text-teal-700 hover:bg-slate-50" data-value="30000">
              Rp30.000
            </button>
            <button type="button" class="preset w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-left font-semibold text-teal-700 hover:bg-slate-50" data-value="50000">
              Rp50.000
            </button>
            <button type="button" class="preset w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-left font-semibold text-teal-700 hover:bg-slate-50" data-value="100000">
              Rp100.000
            </button>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
              <div class="text-xs text-slate-500 mb-2">Nominal Lain :</div>
              <div class="flex items-center gap-2">
                <span class="text-slate-600 font-semibold">Rp</span>
                <input id="amount" name="amount" type="number" min="10000"
                       value="{{ old('amount') }}"
                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-800 outline-none focus:ring-2 focus:ring-teal-200"
                       placeholder="0">
              </div>
              <div class="mt-2 text-[11px] text-slate-500">Min. donasi sebesar Rp10.000</div>

              @error('amount')
                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mt-5 flex justify-center">
            <button class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
              Selanjutnya
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<script>
  (function () {
    const amountInput = document.getElementById('amount');
    document.querySelectorAll('.preset').forEach(btn => {
      btn.addEventListener('click', () => {
        amountInput.value = btn.dataset.value;
        amountInput.focus();
      });
    });
  })();
</script>
@endsection
