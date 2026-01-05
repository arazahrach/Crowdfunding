@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }

  $target = (int) ($campaign->target_amount ?? 0);
  $collected = (int) ($campaign->collected_amount ?? 0);
  $progress = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;
  $shortage = max(0, $target - $collected);

  $img = $campaign->image ?? null;
  if (!$img) $img = 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=1400&q=80';

  $organizer = $campaign->organizer ?? (optional($campaign->user)->name ?? 'Penggalang Dana');
  $location  = $campaign->location_city ?? $campaign->location_province ?? $campaign->location ?? 'Indonesia';
@endphp

<div class="max-w-6xl mx-auto px-4 md:px-0 py-6">
  @if (session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- LEFT --}}
    <div class="lg:col-span-2">
      <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white">
        <img src="{{ $img }}" alt="{{ $campaign->title }}" class="w-full h-72 object-cover">

        <div class="p-5">
          <h1 class="text-xl md:text-2xl font-bold text-slate-800">{{ $campaign->title }}</h1>

          <div class="mt-2 text-sm text-slate-500">
            {{ $location }} • oleh <span class="font-semibold text-slate-700">{{ $organizer }}</span>
          </div>

          <div class="mt-5">
            <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
              <div class="h-full bg-teal-700" style="width: {{ $progress }}%"></div>
            </div>

            <div class="mt-3 flex items-center justify-between text-sm">
              <div class="text-slate-600">
                <span class="font-semibold text-slate-800">{{ rupiah($collected) }}</span>
                terkumpul dari {{ rupiah($target) }}
              </div>
              <div class="font-semibold text-slate-800">{{ $progress }}%</div>
            </div>

            <div class="mt-1 text-xs text-slate-500">
              Kurang {{ rupiah($shortage) }}
              @if (!is_null($daysLeft))
                • Sisa {{ $daysLeft }} hari
              @endif
              • {{ $donors ?? 0 }} donatur
            </div>
          </div>

          <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('donation.donate', $slug) }}"
               class="inline-flex items-center justify-center rounded-full bg-teal-700 px-6 py-2 text-sm font-semibold text-white hover:bg-teal-800">
              Donasi Sekarang
            </a>

            <a href="{{ route('donation.updates', $slug) }}"
               class="inline-flex items-center justify-center rounded-full border border-slate-200 px-6 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
              Lihat Update
            </a>
          </div>

          <hr class="my-6">

          <div class="prose prose-sm max-w-none text-slate-700">
            {!! nl2br(e($campaign->description ?? 'Belum ada deskripsi.')) !!}
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT --}}
    <aside class="lg:col-span-1">
      <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="text-sm font-semibold text-slate-800">Ringkasan</div>

        <div class="mt-4 space-y-3 text-sm">
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Target</span>
            <span class="font-semibold text-slate-800">{{ rupiah($target) }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Terkumpul</span>
            <span class="font-semibold text-slate-800">{{ rupiah($collected) }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Donatur</span>
            <span class="font-semibold text-slate-800">{{ $donors ?? 0 }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Sisa hari</span>
            <span class="font-semibold text-slate-800">{{ is_null($daysLeft) ? '-' : $daysLeft }}</span>
          </div>
        </div>

        <div class="mt-6">
          <a href="{{ route('donation.donate', $slug) }}"
             class="w-full inline-flex items-center justify-center rounded-full bg-teal-700 px-6 py-2 text-sm font-semibold text-white hover:bg-teal-800">
            Donasi Sekarang
          </a>
        </div>
      </div>
    </aside>
  </div>
</div>
@endsection
