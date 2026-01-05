@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-6xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Campaign</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola campaign dan statusnya.</p>
      </div>

      <a href="{{ route('admin.dashboard') }}"
         class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        ← Dashboard
      </a>
    </div>

    @if(session('success'))
      <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        {{ session('success') }}
      </div>
    @endif

    <div class="mt-4 grid gap-3 md:grid-cols-12">
      <form method="GET" class="md:col-span-8">
        <input name="q" value="{{ $q ?? '' }}" placeholder="Cari judul / slug..."
               class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
      </form>

      <form method="GET" class="md:col-span-4">
        <input type="hidden" name="q" value="{{ $q ?? '' }}">
        <select name="status"
                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
                onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="active" {{ ($status ?? '')==='active' ? 'selected' : '' }}>active</option>
          <option value="review" {{ ($status ?? '')==='review' ? 'selected' : '' }}>review</option>
          <option value="ended"  {{ ($status ?? '')==='ended' ? 'selected' : '' }}>ended</option>
        </select>
      </form>
    </div>

    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white">
      <table class="w-full text-sm">
        <thead class="bg-slate-50">
          <tr class="text-left text-slate-600">
            <th class="px-4 py-3">Judul</th>
            <th class="px-4 py-3">Pemilik</th>
            <th class="px-4 py-3">Kategori</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Terkumpul</th>
            <th class="px-4 py-3 w-56">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($campaigns as $c)
            @php
              $target = (int) ($c->target_amount ?? 0);
              $collected = (int) ($c->collected_sum ?? 0);
              $p = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;
            @endphp

            <tr class="border-t border-slate-100">
              <td class="px-4 py-3">
                <div class="font-semibold text-slate-800">{{ $c->title }}</div>
                <div class="text-xs text-slate-500">{{ $c->slug }}</div>
              </td>

              <td class="px-4 py-3 text-slate-700">
                {{ optional($c->user)->name ?? '—' }}
              </td>

              <td class="px-4 py-3 text-slate-700">
                {{ optional($c->category)->name ?? '—' }}
              </td>

              <td class="px-4 py-3">
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                  {{ ($c->status==='active') ? 'bg-emerald-50 text-emerald-800' : (($c->status==='ended') ? 'bg-slate-100 text-slate-700' : 'bg-amber-50 text-amber-800') }}">
                  {{ $c->status ?? '—' }}
                </span>
              </td>

              <td class="px-4 py-3">
                <div class="text-slate-800 font-semibold">{{ rupiah($collected) }}</div>
                <div class="text-xs text-slate-500">{{ $p }}% dari {{ rupiah($target) }}</div>
              </td>

              <td class="px-4 py-3">
                <div class="flex flex-wrap gap-2">
                  <a href="{{ route('admin.campaigns.show', $c) }}"
                     class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Detail
                  </a>

                  <form method="POST" action="{{ route('admin.campaigns.approve', $c) }}">
                    @csrf
                    <button class="rounded-lg bg-teal-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-teal-800">
                      Approve
                    </button>
                  </form>

                  <form method="POST" action="{{ route('admin.campaigns.end', $c) }}"
                        onsubmit="return confirm('Tandai campaign ini berakhir?')">
                    @csrf
                    <button class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">
                      End
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-6 text-slate-500">Belum ada campaign.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $campaigns->links() }}
    </div>

  </div>
</div>
@endsection
