<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'GandengTangan' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F3F0E6] text-slate-800">
    @include('components.navbar')

    <main class="mx-auto max-w-6xl px-4 py-8">
        @yield('content')
    </main>

    <div class="h-10"></div>

    @include('components.footer')
</body>
</html>
