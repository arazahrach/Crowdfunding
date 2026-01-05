@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
  $img = $campaign->image ?: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail Campaign</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $campaign->title }}</p>
      </div>

      <a href="{{ route('admin.campaigns.index') }}"
         class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        ← Kembali
      </a>
    </div>

    @if(session('success'))
      <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        {{ session('success') }}
      </div>
    @endif

    <div class="mt-4 grid gap-4 md:grid-cols-12">
      <div class="md:col-span-5 rounded-2xl overflow-hidden border border-slate-200 bg-white">
        <img src="{{ $img }}" class="w-full h-56 object-cover" alt="">
      </div>

      <div class="md:col-span-7 rounded-2xl border border-slate-200 bg-white p-5">
        <div class="flex items-center justify-between">
          <span class="text-xs text-slate-500">Status</span>
          <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
            {{ ($campaign->status==='active') ? 'bg-emerald-50 text-emerald-800' : (($campaign->status==='ended') ? 'bg-slate-100 text-slate-700' : 'bg-amber-50 text-amber-800') }}">
            {{ $campaign->status ?? '—' }}
          </span>
        </div>

        <div class="mt-3 text-sm text-slate-700">
          <div><span class="text-slate-500">Slug:</span> <span class="font-semibold">{{ $campaign->slug }}</span></div>
          <div class="mt-1"><span class="text-slate-500">Pemilik:</span> <span class="font-semibold">{{ optional($campaign->user)->name ?? '—' }}</span></div>
          <div class="mt-1"><span class="text-slate-500">Kategori:</span> <span class="font-semibold">{{ optional($campaign->category)->name ?? '—' }}</span></div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3">
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Target</div>
            <div class="text-sm font-bold text-slate-800">{{ rupiah($campaign->target_amount ?? 0) }}</div>
          </div>
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Terkumpul (paid)</div>
            <div class="text-sm font-bold text-slate-800">{{ rupiah($collected) }}</div>
          </div>
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Donatur (paid)</div>
            <div class="text-sm font-bold text-slate-800">{{ $donors }}</div>
          </div>
          <div class="rounded-xl bg-slate-50 p-3 border border-slate-200">
            <div class="text-xs text-slate-500">Berakhir</div>
            <div class="text-sm font-bold text-slate-800">{{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') : '—' }}</div>
          </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <form method="POST" action="{{ route('admin.campaigns.approve', $campaign) }}">
            @csrf
            <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
              Approve (Active)
            </button>
          </form>

          <form method="POST" action="{{ route('admin.campaigns.end', $campaign) }}"
                onsubmit="return confirm('Tandai campaign ini berakhir?')">
            @csrf
            <button class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">
              End
            </button>
          </form>

          <a href="{{ route('donation.show', $campaign->slug) }}"
             class="ml-auto rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            Lihat Publik →
          </a>
        </div>
      </div>
    </div>

    <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-5">
      <div class="text-sm font-semibold text-slate-800">Deskripsi</div>
      <div class="mt-2 text-sm text-slate-700 leading-relaxed">
        {!! nl2br(e($campaign->description ?? '—')) !!}
      </div>
    </div>

  </div>
</div>
@endsection
