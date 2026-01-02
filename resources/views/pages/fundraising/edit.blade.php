@extends('layouts.app', ['title' => 'Edit Galang Dana'])

@section('content')
<div class="max-w-3xl mx-auto">
  <a href="{{ route('fundraising.show', $slug) }}"
     class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
    ←
  </a>

  <h1 class="mt-4 text-center text-lg font-semibold text-teal-700">
    Edit Galang Dana
  </h1>

  <div class="mt-6 rounded-2xl bg-[#F7F9FC] border border-slate-200 px-8 py-8">
    <form action="#" method="POST" class="space-y-5" enctype="multipart/form-data">
      {{-- NOTES BACKEND
      method PUT/PATCH
      action="{{ route('fundraising.update', $slug) }}"
      --}}

      <div>
        <label class="text-xs font-semibold text-slate-600">Judul / Nama Donasi</label>
        <input type="text" value="Renovasi Ruang Kelas SD Negeri Harapan Jaya"
               class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="text-xs font-semibold text-slate-600">Judul Singkat</label>
          <input type="text" value="Renovasi Ruang Kelas"
                 class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
        </div>
        <div>
          <label class="text-xs font-semibold text-slate-600">Rincian Penggunaan Dana</label>
          <textarea rows="4"
                    class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">Lorem ipsum...</textarea>
        </div>
      </div>

      <div class="pt-4 flex justify-center gap-2">
        <button type="button"
                class="rounded-full border border-slate-300 px-8 py-2 text-sm hover:bg-slate-50">
          Batal
        </button>
        <button type="button"
                class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
