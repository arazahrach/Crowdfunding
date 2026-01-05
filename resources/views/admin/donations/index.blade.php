@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-6xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Donasi</h1>
        <p class="mt-1 text-sm text-slate-500">Monitor transaksi donasi & status Midtrans.</p>
      </div>

      <a href="{{ route('admin.dashboard') }}"
         class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        ← Dashboard
      </a>
    </div>

    <div class="mt-4 grid gap-3 md:grid-cols-12">
      <form method="GET" class="md:col-span-8">
        <input name="q" value="{{ $q ?? '' }}"
               placeholder="Cari order ID / nama / email..."
               class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
      </form>

      <form method="GET" class="md:col-span-4">
        <input type="hidden" name="q" value="{{ $q ?? '' }}">
        <select name="status"
                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
                onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="pending" {{ ($status ?? '')==='pending' ? 'selected' : '' }}>pending</option>
          <option value="paid"    {{ ($status ?? '')==='paid' ? 'selected' : '' }}>paid</option>
          <option value="failed"  {{ ($status ?? '')==='failed' ? 'selected' : '' }}>failed</option>
        </select>
      </form>
    </div>

    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white">
      <table class="w-full text-sm">
        <thead class="bg-slate-50">
          <tr class="text-left text-slate-600">
            <th class="px-4 py-3">Order ID</th>
            <th class="px-4 py-3">Donatur</th>
            <th class="px-4 py-3">Campaign</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Jumlah</th>
            <th class="px-4 py-3 w-32">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($donations as $d)
            <tr class="border-t border-slate-100">
              <td class="px-4 py-3">
                <div class="font-semibold text-slate-800">{{ $d->order_id }}</div>
                <div class="text-xs text-slate-500">{{ $d->created_at->format('d M Y H:i') }}</div>
              </td>

              <td class="px-4 py-3 text-slate-700">
                <div class="font-semibold">{{ $d->name }}</div>
                <div class="text-xs text-slate-500">{{ $d->email }}</div>
              </td>

              <td class="px-4 py-3 text-slate-700">
                {{ optional($d->campaign)->title ?? '—' }}
              </td>

              <td class="px-4 py-3">
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                  {{ $d->status==='paid' ? 'bg-emerald-50 text-emerald-800' :
                     ($d->status==='pending' ? 'bg-amber-50 text-amber-800' :
                     'bg-red-50 text-red-800') }}">
                  {{ $d->status }}
                </span>
              </td>

              <td class="px-4 py-3 font-semibold text-slate-800">
                {{ rupiah($d->amount) }}
              </td>

              <td class="px-4 py-3">
                <a href="{{ route('admin.donations.show', $d) }}"
                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                  Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-6 text-slate-500">Belum ada donasi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $donations->links() }}
    </div>

  </div>
</div>
@endsection
