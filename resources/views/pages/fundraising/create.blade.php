@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-md mx-auto px-4 py-6">

    <div class="mb-4 flex items-center gap-3">
      <a href="{{ route('fundraising.index') }}"
         class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">←</a>
      <h1 class="text-lg font-bold text-slate-800">Galang Dana</h1>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4">
      <form method="POST" action="{{ route('fundraising.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
          <label class="text-xs font-semibold text-slate-600">Judul / Nama Donasi</label>
          <input name="title" value="{{ old('title') }}"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          @error('title') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Tujuan Penggalangan</label>
          <input name="purpose" value="{{ old('purpose') }}"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          @error('purpose') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-xs font-semibold text-slate-600">Desa</label>
            <input name="village" value="{{ old('village') }}"
                   class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          </div>

          <div>
            <label class="text-xs font-semibold text-slate-600">Kecamatan</label>
            <input name="district" value="{{ old('district') }}"
                   class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          </div>

          <div>
            <label class="text-xs font-semibold text-slate-600">Kabupaten/Kota</label>
            <input name="city" value="{{ old('city') }}"
                   class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          </div>

          <div>
            <label class="text-xs font-semibold text-slate-600">Provinsi</label>
            <input name="province" value="{{ old('province') }}"
                   class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          </div>
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Kategori</label>
          <select name="category_id"
                  class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
            <option value="">(Opsional) Pilih kategori</option>
            @foreach(($categories ?? collect()) as $cat)
              <option value="{{ $cat->id }}" {{ (string)old('category_id') === (string)$cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('category_id') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Target Dana</label>
          <input name="target_amount" type="number" min="10000" value="{{ old('target_amount') }}"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
                 placeholder="contoh: 100000000">
          @error('target_amount') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Periode (Hari)</label>
          <select name="period_days"
                  class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
            @foreach([30,60,90,120] as $d)
              <option value="{{ $d }}" {{ (string)old('period_days','30') === (string)$d ? 'selected' : '' }}>
                {{ $d }} Hari
              </option>
            @endforeach
          </select>
          @error('period_days') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Judul Singkat (opsional)</label>
          <input name="short_title" value="{{ old('short_title') }}"
                 class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
          @error('short_title') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Rincian Penggunaan Dana</label>
          <textarea name="description" rows="5"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"
                    placeholder="Jelaskan penggunaan dana secara rinci">{{ old('description') }}</textarea>
          @error('description') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-xs font-semibold text-slate-600">Tambahkan Foto (opsional)</label>
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
