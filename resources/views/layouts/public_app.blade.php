<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DESDM Sumsel') }} - @yield('title', 'Portal Resmi')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div id="app">
        {{-- Header (akan diisi di partials/header.blade.php) --}}
        @include('partials.header')

        <main class="py-4">
            @yield('content') {{-- PASTIKAN INI ADALAH @yield('content') --}}
        </main>

        {{-- Footer (akan diisi di partials/footer.blade.php) --}}
        @include('partials.footer')
    </div>
</body>
</html>