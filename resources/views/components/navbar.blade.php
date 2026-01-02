<header class="bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="mx-auto max-w-6xl px-4 py-3 flex items-center gap-4">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-teal-700">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-teal-200">
                ❤
            </span>
            <span>GandengTangan</span>
        </a>

        {{-- Search --}}
        <form action="#" class="flex-1">
            <div class="relative">
                <input
                    type="text"
                    placeholder="Search"
                    class="w-full rounded-full border border-slate-200 bg-white px-4 py-2 pr-10 text-sm outline-none focus:ring-2 focus:ring-teal-200"
                />
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">⌕</span>
            </div>
        </form>

        {{-- Menu --}}
        <nav class="hidden md:flex items-center gap-5 text-sm">
            <a class="hover:text-teal-700" href="{{ route('donation.index') }}">Donasi</a>
            <a class="hover:text-teal-700" href="{{ route('fundraising.create') }}">Galang Dana</a>
            <a class="hover:text-teal-700" href="{{ route('about') }}">Tentang Kami</a>
        </nav>


        {{-- Auth buttons --}}
        <div class="flex items-center gap-3">
            @auth
                <a
                    href="{{ route('profile.index') }}"
                    class="text-sm font-medium text-teal-700 hover:underline"
                >
                    {{ auth()->user()->name }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-full border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                class="rounded-full border border-teal-600 px-4 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-50">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                class="rounded-full bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</header>
