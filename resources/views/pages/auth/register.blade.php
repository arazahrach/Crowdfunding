@extends('layouts.app', ['title' => 'Daftar'])

@section('content')
<div class="relative">
    {{-- Back button --}}
    <a href="{{ route('home') }}"
       class="absolute left-0 top-0 inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
        ←
    </a>

    <div class="flex justify-center pt-10 md:pt-14">
        <div class="w-full max-w-xl">
            <div class="mx-auto w-full max-w-md rounded-2xl bg-[#F7F9FC] px-8 py-10 shadow-sm border border-slate-200">
                {{-- Logo + Brand --}}
                <div class="flex flex-col items-center">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white border border-slate-200">
                            <span class="text-teal-700">❤</span>
                        </span>
                        <span class="font-semibold text-slate-700">GandengTangan</span>
                    </div>

                    <h1 class="mt-6 text-teal-700 font-semibold">Buat Akun Baru</h1>
                </div>

                <form class="mt-6 space-y-4" method="POST" action="#">
                    @csrf

                    <div>
                        <input
                            type="text"
                            name="name"
                            placeholder="Nama"
                            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none
                                   focus:ring-2 focus:ring-teal-200"
                            autocomplete="name"
                        >
                    </div>

                    <div>
                        <input
                            type="email"
                            name="email"
                            placeholder="Email"
                            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none
                                   focus:ring-2 focus:ring-teal-200"
                            autocomplete="email"
                        >
                    </div>

                    <div class="relative">
                        <input
                            id="reg_password"
                            type="password"
                            name="password"
                            placeholder="Password"
                            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 pr-11 text-sm outline-none
                                   focus:ring-2 focus:ring-teal-200"
                            autocomplete="new-password"
                        >
                        <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-teal-700/70 hover:text-teal-800"
                                onclick="
                                  const p=document.getElementById('reg_password');
                                  p.type = (p.type==='password') ? 'text' : 'password';
                                "
                                aria-label="Toggle password visibility">
                            👁
                        </button>
                    </div>

                    <div class="relative">
                        <input
                            id="reg_password_confirm"
                            type="password"
                            name="password_confirmation"
                            placeholder="Konfirmasi Password"
                            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 pr-11 text-sm outline-none
                                   focus:ring-2 focus:ring-teal-200"
                            autocomplete="new-password"
                        >
                        <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-teal-700/70 hover:text-teal-800"
                                onclick="
                                  const p=document.getElementById('reg_password_confirm');
                                  p.type = (p.type==='password') ? 'text' : 'password';
                                "
                                aria-label="Toggle password visibility">
                            👁
                        </button>
                    </div>

                    <div class="pt-2 flex justify-center">
                        <button type="submit"
                                class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                            Daftar
                        </button>
                    </div>

                    <div class="pt-2 text-center text-xs text-slate-500">Atau</div>

                    <div class="flex items-center justify-center gap-3">
                        <button type="button"
                                class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-semibold
                                       border border-slate-200 hover:bg-slate-50">
                            <span class="text-base">G</span>
                            Google
                        </button>

                        <button type="button"
                                class="inline-flex items-center gap-2 rounded-full bg-[#1877F2] px-4 py-2 text-xs font-semibold
                                       text-white hover:opacity-90">
                            <span class="text-base">f</span>
                            Facebook
                        </button>
                    </div>

                    <p class="pt-4 text-center text-xs text-slate-500 leading-relaxed">
                        Dengan mendaftar, kamu menyetujui
                        <a href="#" class="text-teal-700 hover:underline">Syarat & Ketentuan</a>.
                    </p>
                </form>
            </div>

            <div class="pt-6 text-center text-xs text-slate-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-teal-700 hover:underline">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</div>

{{-- NOTES (NANTI AUTH BENERAN) --}}
{{--
Nanti kalau auth beneran:
- action="{{ route('register') }}"
- validasi error tampilkan di bawah input
- Laravel Fortify/Breeze akan handle store user
--}}
@endsection
