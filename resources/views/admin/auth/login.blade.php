@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F6F2E8] flex items-center justify-center px-4">
  <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl p-6">
    <h1 class="text-xl font-bold text-slate-800">Admin Login</h1>
    <p class="mt-1 text-sm text-slate-500">Masuk khusus admin.</p>

    <form method="POST" action="{{ route('admin.login.post') }}" class="mt-6 space-y-4">
      @csrf

      <div>
        <label class="text-xs font-semibold text-slate-600">Email</label>
        <input name="email" type="email" value="{{ old('email') }}"
          class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        @error('email') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="text-xs font-semibold text-slate-600">Password</label>
        <input name="password" type="password"
          class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        @error('password') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
      </div>

      <button class="w-full rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
        Masuk
      </button>
    </form>
  </div>
</div>
@endsection
