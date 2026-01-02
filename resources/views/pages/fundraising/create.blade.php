

@extends('layouts.app', ['title' => 'Galang Dana'])

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Back --}}
    <a href="{{ route('home') }}"
       class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-teal-700 text-white hover:bg-teal-800">
        ←
    </a>

    <h1 class="mt-4 text-center text-lg font-semibold text-teal-700">
        Galang Dana
    </h1>

    <div class="mt-6 rounded-2xl bg-[#F7F9FC] border border-slate-200 px-8 py-8">
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
            {{-- NOTES BACKEND
            action="{{ route('fundraising.store') }}"
            method POST
            auth required
            --}}

            {{-- JUDUL --}}
            <div>
                <label class="text-xs font-semibold text-slate-600">
                    Judul / Nama Donasi
                </label>
                <input type="text"
                       placeholder="Contoh: Renovasi Ruang Kelas SD Negeri Harapan Jaya"
                       class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
            </div>

            {{-- TUJUAN --}}
            <div>
                <label class="text-xs font-semibold text-slate-600">
                    Tujuan Penggalangan
                </label>
                <input type="text"
                       placeholder="Contoh: Renovasi ruang kelas rusak akibat banjir"
                       class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
            </div>

            {{-- LOKASI --}}
            <div>
                <label class="text-xs font-semibold text-slate-600">
                    Lokasi
                </label>

                <div class="mt-2 grid grid-cols-2 gap-3">
                    <input type="text" placeholder="Desa"
                           class="rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
                    <input type="text" placeholder="Kecamatan"
                           class="rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
                    <input type="text" placeholder="Kabupaten/Kota"
                           class="rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
                    <input type="text" placeholder="Provinsi"
                           class="rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
                </div>
            </div>

            {{-- TARGET DANA --}}
            <div>
                <label class="text-xs font-semibold text-slate-600">
                    Target Dana
                </label>
                <div class="mt-2 flex items-center rounded-xl border border-teal-300 bg-white px-4 py-2">
                    <span class="text-sm font-semibold text-slate-600 mr-2">Rp</span>
                    <input type="number" placeholder="0"
                           class="w-full text-sm outline-none">
                </div>
            </div>

            {{-- PERIODE --}}
            <div>
                <label class="text-xs font-semibold text-slate-600">
                    Periode
                </label>

                <div class="mt-2 grid grid-cols-2 gap-3">
                    <button type="button"
                        class="rounded-xl border border-teal-300 bg-white py-2 text-sm hover:bg-teal-50">
                        30 Hari
                    </button>
                    <button type="button"
                        class="rounded-xl border border-teal-300 bg-white py-2 text-sm hover:bg-teal-50">
                        60 Hari
                    </button>
                    <button type="button"
                        class="rounded-xl border border-teal-300 bg-white py-2 text-sm hover:bg-teal-50">
                        90 Hari
                    </button>
                    <select
                        class="rounded-xl border border-teal-300 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
                        <option>Pilih Hari</option>
                    </select>
                </div>
            </div>

            {{-- JUDUL & DESKRIPSI (DIPISAH 2 KOLOM SESUAI REQUEST) --}}
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold text-slate-600">
                        Judul Singkat
                    </label>
                    <input type="text"
                           placeholder="Judul singkat penggalangan"
                           class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-600">
                        Rincian Penggunaan Dana
                    </label>
                    <textarea rows="4"
                              placeholder="Jelaskan penggunaan dana secara rinci"
                              class="mt-2 w-full rounded-xl border border-teal-300 bg-white px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200"></textarea>
                </div>
            </div>

            {{-- FOTO --}}
            <div>
                <label class="text-xs font-semibold text-slate-600">
                    Tambahkan Foto
                </label>
                <div class="mt-2 rounded-xl border border-dashed border-teal-300 bg-white p-6 text-center">
                    <div class="text-sm font-semibold text-teal-700">Upload</div>
                    <input type="file" class="mt-3 text-xs">
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="pt-4 flex justify-center">
                <button type="button"
                        class="rounded-full bg-teal-700 px-10 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                    Simpan
                </button>
            </div>

            {{-- NOTES --}}
            {{--
            BACKEND NANTI:
            - campaigns table
            - status default: pending
            - foto ke storage
            --}}
        </form>
    </div>
</div>
@endsection
