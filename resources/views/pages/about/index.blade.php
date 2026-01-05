@extends('layouts.app', ['title' => 'Tentang Kami'])

@section('content')
<section class="max-w-5xl mx-auto px-4 md:px-0">
    <div class="rounded-3xl bg-white border border-slate-200 p-6 md:p-10">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Tentang GandengTangan</h1>
                <p class="mt-3 text-slate-600 leading-relaxed">
                    Platform galang dana untuk pendidikan—membantu kebutuhan sekolah, beasiswa, fasilitas,
                    dan perlengkapan belajar. Kita bikin donasi jadi gampang, transparan, dan berdampak.
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="rounded-full bg-teal-50 text-teal-800 px-4 py-2 text-sm font-semibold">Transparan</span>
                    <span class="rounded-full bg-teal-50 text-teal-800 px-4 py-2 text-sm font-semibold">Aman</span>
                    <span class="rounded-full bg-teal-50 text-teal-800 px-4 py-2 text-sm font-semibold">Berdampak</span>
                </div>
            </div>

            <div class="hidden md:block">
                <div class="h-20 w-20 rounded-3xl border border-teal-200 bg-teal-50 flex items-center justify-center text-3xl"
                     aria-hidden="true">
                    ❤
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-sm font-semibold text-teal-800">Misi</div>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Mempertemukan donatur dan penggalang dana pendidikan agar bantuan tepat sasaran.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-sm font-semibold text-teal-800">Visi</div>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Pendidikan yang layak untuk semua, lewat gotong royong yang mudah diakses.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-sm font-semibold text-teal-800">Nilai</div>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Empati, integritas, dan akuntabilitas dalam setiap penggalangan.
            </p>
        </div>
    </div>

    <div class="mt-8 rounded-3xl bg-gradient-to-r from-teal-700 to-teal-600 text-white p-6 md:p-10">
        <h2 class="text-xl font-bold">Mau mulai berdampak hari ini?</h2>
        <p class="mt-2 text-white/90 text-sm">
            Jelajahi penggalangan dana atau mulai galang dana pendidikanmu sendiri.
        </p>

        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('donation.index') }}"
               class="rounded-full bg-white text-teal-800 px-5 py-2 text-sm font-semibold hover:bg-white/90">
                Lihat Donasi
            </a>

            <a href="{{ route('fundraising.create') }}"
               class="rounded-full border border-white/60 px-5 py-2 text-sm font-semibold hover:bg-white/10">
                Mulai Galang Dana
            </a>
        </div>

        {{-- Optional: kecilin teks bantuan --}}
        <p class="mt-3 text-xs text-white/80">
            *Untuk mulai galang dana, kamu perlu login dulu.
        </p>
    </div>
</section>
@endsection
