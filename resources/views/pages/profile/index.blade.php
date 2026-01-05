@extends('layouts.app')

@section('content')
@php
  function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }

  $user = auth()->user();
  $activeTab = $tab ?? 'fundraising';
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-3xl mx-auto px-4 py-8">

    <div class="mb-4">
      <a href="{{ url()->previous() }}"
         class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">←</a>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-6">
      {{-- Header profile --}}
      <div class="flex flex-col items-center">
        <div class="h-20 w-20 rounded-full bg-teal-50 flex items-center justify-center text-teal-700 text-3xl font-bold">
          {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
        </div>

        <div class="mt-3 text-sm font-semibold text-slate-800">
          {{ $user->name ?? 'User' }}
        </div>

        <div class="mt-1 text-xs text-slate-500">
          {{ $user->email ?? '' }}
        </div>
      </div>

      {{-- Tabs --}}
      <div class="mt-6 flex rounded-xl bg-slate-100 p-1">
        <a href="{{ route('profile.fundraising') }}"
           class="flex-1 text-center text-sm font-semibold rounded-lg py-2 {{ $activeTab==='fundraising' ? 'bg-teal-700 text-white' : 'text-slate-700 hover:bg-white' }}">
          Galang Donasi Saya
        </a>

        <a href="{{ route('profile.donations') }}"
           class="flex-1 text-center text-sm font-semibold rounded-lg py-2 {{ $activeTab==='donations' ? 'bg-teal-700 text-white' : 'text-slate-700 hover:bg-white' }}">
          Riwayat Donasi
        </a>
      </div>

      {{-- Content tab --}}
      <div class="mt-6">

        {{-- TAB: GALANG DONASI SAYA --}}
        @if($activeTab === 'fundraising')
          <div class="flex items-center justify-between gap-3">
            <div class="text-sm font-semibold text-slate-800">Kelola Galang Dana</div>

            <a href="{{ route('fundraising.create') }}"
               class="rounded-full bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
              + Buat Galang Dana Baru
            </a>
          </div>

          <form method="GET" action="{{ route('profile.fundraising') }}" class="mt-3">
            <input name="q" value="{{ $q ?? '' }}" placeholder="Cari galang dana kamu..."
                   class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          </form>

          <div class="mt-4 space-y-3">
            @forelse(($campaigns ?? collect()) as $c)
              @php
                $target = (int) ($c->target_amount ?? 0);
                $collected = (int) ($c->collected_sum ?? 0);
                $p = $target > 0 ? min(100, (int) round(($collected / $target) * 100)) : 0;

                $img = $c->image ?: 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1400&q=80';

                $daysLeft = null;
                if ($c->end_date) {
                  $daysLeft = now()->startOfDay()->diffInDays($c->end_date->startOfDay(), false);
                  if ($daysLeft < 0) $daysLeft = 0;
                }
              @endphp

              <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                <div class="flex gap-3">
                  <img src="{{ $img }}" class="h-16 w-20 rounded-xl object-cover border border-slate-200" alt="">

                  <div class="flex-1">
                    <div class="text-sm font-semibold text-slate-800 line-clamp-2">
                      {{ $c->title }}
                    </div>

                    <div class="mt-2 h-2 rounded-full bg-slate-200 overflow-hidden">
                      <div class="h-full bg-teal-700" style="width: {{ $p }}%"></div>
                    </div>

                    <div class="mt-2 flex items-center justify-between text-xs text-slate-600">
                      <span>Terkumpul</span>
                      <span class="font-semibold text-slate-800">{{ rupiah($collected) }}</span>
                    </div>

                    <div class="mt-1 flex items-center justify-between text-xs text-slate-500">
                      <span>dari {{ rupiah($target) }}</span>
                      <span>{{ is_null($daysLeft) ? '-' : $daysLeft }} Hari Tersisa</span>
                    </div>

                    <div class="mt-3 flex gap-2">
                      <a href="{{ route('fundraising.edit', $c->slug) }}"
                         class="rounded-full border border-slate-200 bg-white px-4 py-1.5 text-xs font-semibold text-teal-700 hover:bg-slate-50">
                        Edit
                      </a>

                      <a href="{{ route('fundraising.updates.create', $c->slug) }}"
                         class="rounded-full bg-teal-700 px-4 py-1.5 text-xs font-semibold text-white hover:bg-teal-800">
                        Update
                      </a>

                      <a href="{{ route('fundraising.show', $c->slug) }}"
                         class="ml-auto text-xs font-semibold text-teal-700 hover:underline self-center">
                        Detail →
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="text-sm text-slate-500">
                Kamu belum punya galang dana.
              </div>
            @endforelse
          </div>

          <div class="mt-4">
            {{ $campaigns->links() }}
          </div>
        @endif

        {{-- TAB: RIWAYAT DONASI --}}
        @if($activeTab === 'donations')
          <div class="text-sm font-semibold text-slate-800">Riwayat Donasi</div>

          <div class="mt-4 space-y-3">
            @forelse(($donations ?? collect()) as $d)
              @php
                $title = optional($d->campaign)->title ?? 'Campaign';
                $slug  = optional($d->campaign)->slug ?? null;
                $status = $d->status ?? 'pending';
              @endphp

              <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <div class="text-sm font-semibold text-slate-800 line-clamp-2">
                      {{ $title }}
                    </div>
                    <div class="mt-1 text-xs text-slate-500">
                      {{ optional($d->created_at)->format('d M Y, H:i') }}
                    </div>

                    <div class="mt-2 text-sm font-semibold text-slate-800">
                      {{ rupiah($d->amount) }}
                    </div>

                    <div class="mt-1 text-xs text-slate-600">
                      Status: <span class="font-semibold">{{ $status }}</span>
                    </div>
                  </div>

                  @if($slug)
                    <a href="{{ route('donation.show', $slug) }}"
                       class="text-xs font-semibold text-teal-700 hover:underline">
                      Lihat →
                    </a>
                  @endif
                </div>
              </div>
            @empty
              <div class="text-sm text-slate-500">
                Kamu belum pernah donasi.
              </div>
            @endforelse
          </div>

          <div class="mt-4">
            {{ $donations->links() }}
          </div>
        @endif

      </div>
    </div>

  </div>
</div>
@endsection
