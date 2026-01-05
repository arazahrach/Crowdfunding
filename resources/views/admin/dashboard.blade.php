@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }

  // Safe route checker: kalau route belum ada, tombol jadi disabled
  $has = fn($name) => \Illuminate\Support\Facades\Route::has($name);
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola master data, campaign, dan transaksi donasi.</p>
      </div>

      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
          Logout
        </button>
      </form>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="text-xs text-slate-500">Total Campaign</div>
        <div class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['campaigns'] }}</div>
      </div>

      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="text-xs text-slate-500">Total Kategori</div>
        <div class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['categories'] }}</div>
      </div>

      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="text-xs text-slate-500">Donasi Paid</div>
        <div class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['donations_paid'] }}</div>
        <div class="mt-1 text-sm text-slate-600">{{ rupiah($stats['amount_paid']) }}</div>
      </div>

      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="text-xs text-slate-500">Donasi Pending</div>
        <div class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['pending'] }}</div>
      </div>

      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="text-xs text-slate-500">Donasi Failed</div>
        <div class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['failed'] }}</div>
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-10">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-lg font-bold text-slate-800">Menu Admin</h2>
          <p class="mt-1 text-sm text-slate-500">Akses cepat ke fitur utama.</p>
        </div>
      </div>

      <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Categories --}}
        <a href="{{ route('admin.categories.index') }}"
           class="rounded-2xl bg-white border border-slate-200 p-5 hover:shadow-sm transition">
          <div class="text-xs font-semibold text-slate-500">MASTER DATA</div>
          <div class="mt-2 text-lg font-bold text-slate-800">Kelola Kategori</div>
          <div class="mt-1 text-sm text-slate-600">
            Tambah/ubah icon, nama, slug kategori.
          </div>
          <div class="mt-4 text-sm font-semibold text-teal-700">Buka →</div>
        </a>

        {{-- Campaigns --}}
        @if($has('admin.campaigns.index'))
          <a href="{{ route('admin.campaigns.index') }}"
             class="rounded-2xl bg-white border border-slate-200 p-5 hover:shadow-sm transition">
            <div class="text-xs font-semibold text-slate-500">OPERASIONAL</div>
            <div class="mt-2 text-lg font-bold text-slate-800">Kelola Campaign</div>
            <div class="mt-1 text-sm text-slate-600">
              Review, approve, end campaign.
            </div>
            <div class="mt-4 text-sm font-semibold text-teal-700">Buka →</div>
          </a>
        @else
          <div class="rounded-2xl bg-white border border-slate-200 p-5 opacity-60">
            <div class="text-xs font-semibold text-slate-500">OPERASIONAL</div>
            <div class="mt-2 text-lg font-bold text-slate-800">Kelola Campaign</div>
            <div class="mt-1 text-sm text-slate-600">
              Review, approve, end campaign.
            </div>
            <div class="mt-4 text-sm font-semibold text-slate-400">Belum dibuat</div>
          </div>
        @endif

        {{-- Donations --}}
        @if($has('admin.donations.index'))
          <a href="{{ route('admin.donations.index') }}"
             class="rounded-2xl bg-white border border-slate-200 p-5 hover:shadow-sm transition">
            <div class="text-xs font-semibold text-slate-500">TRANSAKSI</div>
            <div class="mt-2 text-lg font-bold text-slate-800">Monitor Donasi</div>
            <div class="mt-1 text-sm text-slate-600">
              Lihat pending/paid/failed, detail callback Midtrans.
            </div>
            <div class="mt-4 text-sm font-semibold text-teal-700">Buka →</div>
          </a>
        @else
          <div class="rounded-2xl bg-white border border-slate-200 p-5 opacity-60">
            <div class="text-xs font-semibold text-slate-500">TRANSAKSI</div>
            <div class="mt-2 text-lg font-bold text-slate-800">Monitor Donasi</div>
            <div class="mt-1 text-sm text-slate-600">
              Lihat pending/paid/failed, detail callback Midtrans.
            </div>
            <div class="mt-4 text-sm font-semibold text-slate-400">Belum dibuat</div>
          </div>
        @endif

      </div>
    </div>

    {{-- Notes --}}
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5">
      <div class="text-sm font-semibold text-slate-800">Catatan</div>
      <ul class="mt-2 list-disc pl-5 text-sm text-slate-600 space-y-1">
        <li>Kategori sudah bisa dikelola dari menu di atas.</li>
        <li>Menu Campaign & Donasi akan otomatis aktif setelah route + controller-nya dibuat.</li>
        <li>Progress donasi di user page tetap dihitung dari status <span class="font-semibold">paid</span>.</li>
      </ul>
    </div>

  </div>
</div>
@endsection
