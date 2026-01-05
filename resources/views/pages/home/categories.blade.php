@php
    $categories = $categories ?? collect();
@endphp

<section class="mt-12 text-center">
    <h2 class="text-teal-700 font-bold text-lg">
        Pilih Kategori Favorit kamu
    </h2>

    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-6 place-items-center">
        @foreach ($categories as $cat)
            @php
                $label = $cat->name ?? $cat['name'] ?? $cat['label'] ?? 'Kategori';
                $icon  = $cat->icon ?? $cat['icon'] ?? '🏷️';

                $slug = $cat->slug ?? $cat['slug'] ?? null;
                
                $link = $slug
                    ? route('donation.index', ['category' => $slug, 'sort' => 'newest', 'page' => 1])
                    : route('donation.index');

            @endphp

            <a href="{{ $link }}" class="group flex flex-col items-center gap-2">
                <div
                    class="h-16 w-16 rounded-2xl border border-teal-200 bg-white flex items-center justify-center text-2xl
                           group-hover:shadow group-hover:-translate-y-0.5 transition"
                >
                    {{ $icon }}
                </div>
                <span class="text-sm font-semibold text-teal-700">
                    {{ $label }}
                </span>
            </a>
        @endforeach
    </div>
</section>
