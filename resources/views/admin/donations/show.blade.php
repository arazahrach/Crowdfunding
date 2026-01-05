@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail Donasi</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $donation->order_id }}</p>
      </div>

      <a href="{{ route('admin.donations.index') }}"
         class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        ← Kembali
      </a>
    </div>

    <div class="mt-4 grid gap-4 md:grid-cols-12">
      <div class="md:col-span-6 rounded-2xl border border-slate-200 bg-white p-5">
        <div class="text-sm font-semibold text-slate-800">Informasi Donatur</div>

        <div class="mt-2 text-sm text-slate-700 space-y-1">
          <div><span class="text-slate-500">Nama:</span> <span class="font-semibold">{{ $donation->name }}</span></div>
          <div><span class="text-slate-500">Email:</span> <span class="font-semibold">{{ $donation->email }}</span></div>
          <div><span class="text-slate-500">User:</span> <span class="font-semibold">{{ optional($donation->user)->name ?? 'Guest' }}</span></div>
        </div>

        <div class="mt-4 text-sm font-semibold text-slate-800">Donasi</div>
        <div class="mt-2 grid grid-cols-2 gap-3">
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Jumlah</div>
            <div class="text-sm font-bold text-slate-800">{{ rupiah($donation->amount) }}</div>
          </div>
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Status</div>
            <div class="text-sm font-bold text-slate-800">{{ $donation->status }}</div>
          </div>
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Payment Type</div>
            <div class="text-sm font-bold text-slate-800">{{ $donation->payment_type ?? '—' }}</div>
          </div>
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Fraud</div>
            <div class="text-sm font-bold text-slate-800">{{ $donation->fraud_status ?? '—' }}</div>
          </div>
        </div>

        <div class="mt-4 text-sm font-semibold text-slate-800">Campaign</div>
        <div class="mt-2 text-sm text-slate-700">
          {{ optional($donation->campaign)->title ?? '—' }}
        </div>
      </div>

      <div class="md:col-span-6 rounded-2xl border border-slate-200 bg-white p-5">
        <div class="text-sm font-semibold text-slate-800">Raw Midtrans Response</div>

        <pre class="mt-3 max-h-[420px] overflow-auto rounded-xl bg-slate-900 p-4 text-xs text-slate-100">
{{ json_encode($donation->raw_response, JSON_PRETTY_PRINT) }}
        </pre>
      </div>
    </div>

  </div>
</div>
@endsection
