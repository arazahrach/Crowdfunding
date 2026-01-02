@php
    /**
     * DUMMY dulu yaa (buat UI).
     * Nanti kalau udah ada kategori di DB, tinggal sambung.
     */
    $categories = [
        ['label' => 'Fasilitas', 'icon' => '🏫', 'link' => '#'],
        ['label' => 'Beasiswa', 'icon' => '🎓', 'link' => '#'],
        ['label' => 'Alat Belajar', 'icon' => '✏️', 'link' => '#'],
        ['label' => 'Tingkat Sekolah', 'icon' => '🧭', 'link' => '#'],
    ];
@endphp

<section class="mt-12 text-center">
    <h2 class="text-teal-700 font-bold text-lg">
        Pilih Kategori Favorit kamu
    </h2>

    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-6 place-items-center">
        @foreach ($categories as $cat)
            <a href="{{ $cat['link'] }}" class="group flex flex-col items-center gap-2">
                <div
                    class="h-16 w-16 rounded-2xl border border-teal-200 bg-white flex items-center justify-center text-2xl
                           group-hover:shadow group-hover:-translate-y-0.5 transition"
                >
                    {{ $cat['icon'] }}
                </div>
                <span class="text-sm font-semibold text-teal-700">
                    {{ $cat['label'] }}
                </span>
            </a>
        @endforeach
    </div>
</section>

{{-- NOTES (NANTI AMBIL DARI DATABASE) --}}
{{--
Kalau nanti kamu punya:
- table categories (id, name, slug, icon)
- campaigns punya category_id

Controller (contoh):
$categories = Category::orderBy('name')->take(4)->get();

Blade:
@foreach($categories as $cat)
  $cat->name
  $cat->icon (bisa emoji atau class icon)
  route('campaigns.index', ['category' => $cat->slug])
@endforeach
--}}
