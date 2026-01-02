<div class="donation-card">
    <img src="{{ $image ?? '/img/placeholder.jpg' }}" alt="cover">

    <h3>{{ $title ?? 'Judul Donasi' }}</h3>

    <p>Progress: {{ $progress ?? '0%' }}</p>

    <a href="{{ $link ?? '#' }}">Lihat Detail</a>
</div>
