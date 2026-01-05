@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }

  $target    = (int) ($campaign->target_amount ?? 0);
  $collected = (int) ($collected ?? 0); // ✅ dari controller
  $progress  = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;
  $shortage  = max(0, $target - $collected);

  $img = $campaign->image ?: 'https://images.unsplash.com/photo-1588072432836-7fb78b0d43c5?auto=format&fit=crop&w=1400&q=80';
  $organizer = $campaign->organizer ?? (optional($campaign->user)->name ?? 'Penggalang Dana');
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

        <div class="mt-6 text-center text-sm font-semibold text-teal-700">
          Informasi Penggalangan Dana
        </div>

        <div class="mt-3 rounded-2xl border border-slate-200 p-4">
          <div class="text-xs text-slate-500">Penggalang Dana</div>
          <div class="mt-1 flex items-center gap-2">
            <div class="h-9 w-9 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">🏫</div>
            <div class="font-semibold text-slate-800">{{ $organizer }}</div>
            <span class="text-teal-700 text-xs">✔</span>
          </div>

          <div class="mt-4 flex rounded-xl bg-slate-100 p-1">
            <a href="{{ route('donation.show', $slug) }}"
               class="flex-1 text-center text-sm font-semibold rounded-lg py-2 text-slate-700 hover:bg-white">Deskripsi</a>
            <a href="{{ route('donation.updates', $slug) }}"
               class="flex-1 text-center text-sm font-semibold rounded-lg py-2 bg-teal-700 text-white">Update</a>
          </div>

          <div class="mt-4 space-y-4">
            @forelse ($updates as $u)
              <div class="rounded-xl border border-slate-200 bg-white p-3">
                <div class="text-sm font-semibold text-slate-800">
                  {{ $u->title ?: 'Update' }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1">
                  {{ optional($u->created_at)->format('d M Y, H:i') }}
                </div>

                <div class="mt-2 text-sm text-slate-700 leading-relaxed">
                  {!! nl2br(e($u->content)) !!}
                </div>

                @if (!empty($u->image))
                  <div class="mt-3 rounded-xl overflow-hidden border border-slate-200">
                    <img class="w-full h-48 object-cover" src="{{ $u->image }}" alt="">
                  </div>
                @endif
              </div>
            @empty
              <div class="text-sm text-slate-500">Belum ada update.</div>
            @endforelse
          </div>

          {{-- OPTIONAL transfer card (muncul kalau kolom bank ada dan terisi) --}}
          @if (!empty($campaign->bank_name) || !empty($campaign->bank_account_number) || !empty($campaign->bank_account_holder))
            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
              <div class="text-sm font-semibold text-slate-800 text-center">Transfer</div>
              <div class="mt-2 text-xs text-slate-700 space-y-1">
                @if(!empty($campaign->bank_name)) <div><b>Bank:</b> {{ $campaign->bank_name }}</div> @endif
                @if(!empty($campaign->bank_account_number)) <div><b>No Rek:</b> {{ $campaign->bank_account_number }}</div> @endif
                @if(!empty($campaign->bank_account_holder)) <div><b>Atas Nama:</b> {{ $campaign->bank_account_holder }}</div> @endif
              </div>
            </div>
          @endif
        </div>

        <div class="mt-5 flex items-center justify-center gap-3">
          <button type="button"
                  onclick="navigator.share ? navigator.share({title:'{{ $campaign->title }}', url: window.location.href}) : alert('Copy link: ' + window.location.href)"
                  class="rounded-full border border-slate-200 px-6 py-2 text-sm font-semibold text-teal-700 hover:bg-slate-50">
            Bagikan
          </button>

          <a href="{{ route('donation.donate', $slug) }}"
             class="rounded-full bg-teal-700 px-6 py-2 text-sm font-semibold text-white hover:bg-teal-800">
            Donasi Sekarang
          </a>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection
