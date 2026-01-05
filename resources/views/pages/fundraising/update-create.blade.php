@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-md mx-auto px-4 py-6">

    <div class="mb-4 flex items-center gap-3">
      <a href="{{ route('fundraising.show', $slug) }}"
         class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">←</a>
      <h1 class="text-lg font-bold text-slate-800">Add Update</h1>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4">
      <form method="POST" action="{{ route('fundraising.updates.store', $slug) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
          <label class="text-xs font-semibold text-slate-600">Judul / Deskripsi</label>
          <textarea name="content" rows="5"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
                    placeholder="Tulis update terbaru...">{{ old('content') }}</textarea>
          @error('content') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Tambahkan Foto / Dokumentasi (opsional)</label>
          <input type="file" name="image"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm bg-white">
          @error('image') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <button class="w-full rounded-full bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
          Simpan
        </button>
      </form>
    </div>

  </div>
</div>
@endsection
