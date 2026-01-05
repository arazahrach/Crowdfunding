@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-0 py-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-xl font-bold text-slate-800">Kabar Terbaru</h1>
      <p class="text-sm text-slate-500 mt-1">{{ $campaign->title }}</p>
    </div>

    <a href="{{ route('donation.show', $slug) }}"
       class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
      Kembali
    </a>
  </div>

  <div class="mt-6 space-y-4">
    @forelse ($updates as $u)
      <article class="rounded-2xl border border-slate-200 bg-[#F7F9FC] p-4">
        <div class="flex items-start justify-between gap-3">
          <div>
            <div class="text-sm font-semibold text-slate-800">Update</div>
            <div class="text-xs text-slate-500 mt-1">
              {{ $u->created_at?->format('d M Y') }}
            </div>
          </div>
        </div>

        <p class="mt-3 text-sm text-slate-600 leading-relaxed">
          {{ $u->content }}
        </p>

        @if (!empty($u->image))
          <div class="mt-3 rounded-xl overflow-hidden border border-slate-200">
            <img class="w-full h-56 object-cover" src="{{ $u->image }}" alt="">
          </div>
        @endif
      </article>
    @empty
      <div class="text-sm text-slate-500">Belum ada update.</div>
    @endforelse
  </div>
</div>
@endsection
