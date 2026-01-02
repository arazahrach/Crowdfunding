@extends('layouts.app', ['title' => 'Update'])

@section('content')
@php
  $title = 'Renovasi Ruang Kelas SD Negeri Harapan Jaya';
@endphp

<div class="max-w-3xl mx-auto">
  <a href="{{ route('donation.show', $slug) }}"
     class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
    ←
  </a>

  <div class="mt-4 text-center font-semibold text-teal-800">{{ $title }}</div>

  <div class="mt-5 rounded-2xl bg-white border border-slate-200 p-4">
    <div class="flex rounded-xl overflow-hidden border border-slate-200 text-sm">
      <a href="{{ route('donation.show', $slug) }}"
         class="flex-1 px-4 py-2 text-center bg-white text-slate-700 hover:bg-slate-50">
        Deskripsi
      </a>
      <a href="{{ route('donation.updates', $slug) }}"
         class="flex-1 px-4 py-2 text-center bg-teal-700 text-white font-semibold">
        Update
      </a>
    </div>

    <div class="mt-4 space-y-4">
      @foreach ([1,2] as $i)
        <article class="rounded-2xl border border-slate-200 bg-[#F7F9FC] p-4">
          <div class="text-sm font-semibold text-slate-800">Update #{{ $i }}</div>
          <div class="text-xs text-slate-500 mt-1">01 Jan 2026</div>
          <p class="mt-3 text-sm text-slate-600 leading-relaxed">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Update kegiatan terbaru penggalangan dana…
          </p>

          <div class="mt-3 rounded-xl overflow-hidden border border-slate-200">
            <img class="w-full h-56 object-cover"
                 src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1400&q=80"
                 alt="">
          </div>
        </article>
      @endforeach
    </div>
  </div>

  <div class="mt-5 flex justify-center gap-3">
    <button class="rounded-full border border-teal-600 px-6 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-50">
      Bagikan
    </button>
    <a href="{{ route('donation.donate', $slug) }}"
       class="rounded-full bg-teal-700 px-6 py-2 text-sm font-semibold text-white hover:bg-teal-800">
      Donasi Sekarang
    </a>
  </div>

  {{-- NOTES (DB nanti)
  - updates table: campaign_id, title, body, image_url, created_at
  --}}
</div>
@endsection
