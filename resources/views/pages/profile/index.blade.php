@extends('layouts.app', ['title' => 'Profil'])

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">Profil</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="rounded-full border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50">
                Logout
            </button>
        </form>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-3">
        {{-- Card user --}}
        <div class="md:col-span-2 rounded-2xl bg-white border border-slate-200 p-6">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-teal-700 text-white flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <div class="flex-1">
                    <div class="text-lg font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ auth()->user()->email }}
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="text-slate-500">Nama</div>
                    <div class="font-semibold text-slate-800 mt-1">{{ auth()->user()->name }}</div>
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="text-slate-500">Email</div>
                    <div class="font-semibold text-slate-800 mt-1">{{ auth()->user()->email }}</div>
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="text-slate-500">Bergabung sejak</div>
                    <div class="font-semibold text-slate-800 mt-1">
                        {{ optional(auth()->user()->created_at)->format('d M Y') }}
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="text-slate-500">Status</div>
                    <div class="font-semibold text-teal-700 mt-1">
                        Aktif
                    </div>
                </div>
            </div>

            {{-- tombol edit (FE dulu, route nanti) --}}
            <div class="mt-6 flex gap-2">
                <a href="#"
                   class="rounded-full bg-teal-700 px-5 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                    Edit Profil
                </a>
                <a href="{{ route('home') }}"
                   class="rounded-full border border-teal-600 px-5 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-50">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        {{-- Sidebar menu --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-4">
            <div class="text-sm font-semibold text-slate-700">Menu</div>

            <div class="mt-3 flex flex-col gap-2 text-sm">
                <a href="{{ route('profile.index') }}"
                   class="rounded-xl px-3 py-2 bg-teal-50 text-teal-800 font-semibold">
                    Profil Saya
                </a>
                <a href="#"
                   class="rounded-xl px-3 py-2 hover:bg-slate-50 text-slate-700">
                    Donasi Saya (soon)
                </a>
                <a href="{{ route('fundraising.index') }}"
                    class="rounded-xl px-3 py-2 hover:bg-slate-50 text-slate-700">
                        Galang Dana Saya
                </a>

                <a href="#"
                   class="rounded-xl px-3 py-2 hover:bg-slate-50 text-slate-700">
                    Pengaturan (soon)
                </a>
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 p-3 text-xs text-slate-500">
                *SABARRRRRR FE LAGI MELEDEAK ABANGKU
            </div>
        </div>
    </div>
</div>
@endsection
