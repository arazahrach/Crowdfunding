{{-- Error message --}}
@if ($errors->any())
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        {{ $errors->first() }}
    </div>
@endif

<form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}">
    @csrf

    <div>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            placeholder="Nama"
            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
            required
            autofocus
        >
    </div>

    <div>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Email"
            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
            required
            autocomplete="email"
        >
    </div>

    <div class="relative">
        <input
            id="reg_password"
            type="password"
            name="password"
            placeholder="Password"
            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 pr-11 text-sm outline-none focus:ring-2 focus:ring-teal-200"
            required
            autocomplete="new-password"
        >
        <button type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-teal-700/70 hover:text-teal-800"
                onclick="
                  const p=document.getElementById('reg_password');
                  p.type = (p.type==='password') ? 'text' : 'password';
                ">
            👁
        </button>
    </div>

    <div class="relative">
        <input
            id="reg_password_confirm"
            type="password"
            name="password_confirmation"
            placeholder="Konfirmasi Password"
            class="w-full rounded-xl border border-teal-300 bg-white px-4 py-2 pr-11 text-sm outline-none focus:ring-2 focus:ring-teal-200"
            required
            autocomplete="new-password"
        >
        <button type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-teal-700/70 hover:text-teal-800"
                onclick="
                  const p=document.getElementById('reg_password_confirm');
                  p.type = (p.type==='password') ? 'text' : 'password';
                ">
            👁
        </button>
    </div>

    <div class="pt-2 flex justify-center">
        <button type="submit"
                class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
            Daftar
        </button>
    </div>
</form>
