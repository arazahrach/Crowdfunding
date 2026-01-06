@extends('layouts.admin')

@section('content')
@php
  $isEdit = ($mode ?? 'create') === 'edit';
@endphp

<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">
          {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
        </h1>
        <p class="mt-1 text-sm text-slate-500">Isi master data kategori.</p>
      </div>

      <a href="{{ route('admin.categories.index') }}"
         class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Kembali
      </a>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5">
      <form method="POST"
            action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
            class="space-y-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
          <label class="text-xs font-semibold text-slate-600">Nama</label>
          <input name="name" value="{{ old('name', $category->name) }}"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          @error('name') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Icon (opsional)</label>
          <input name="icon" value="{{ old('icon', $category->icon) }}" placeholder="contoh: 🩺 atau 📚"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          <div class="mt-1 text-xs text-slate-500">Boleh emoji atau teks pendek.</div>
          @error('icon') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Slug (opsional)</label>
          <input name="slug" value="{{ old('slug', $category->slug) }}" placeholder="otomatis dari nama jika kosong"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          @error('slug') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <button class="w-full rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
          {{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}
        </button>
      </form>
    </div>

  </div>
</div>
@endsection
