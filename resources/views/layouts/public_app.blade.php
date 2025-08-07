<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['app_name'] ?? 'DESDM SUMSEL' }}</title>

    {{-- Favicon --}}
    @if(isset($settings['app_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings['app_favicon']) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.ico') }}"> {{-- Default fallback --}}
    @endif



    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Ganti link font lama dengan Titillium Web --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
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
    {{-- Tombol "Kembali ke atas" --}}
    <button id="scroll-to-top" class="btn btn-light rounded-pill shadow" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i> Kembali ke atas
    </button>

        {{-- Widget Mengambang (Floating Widget) --}}
    <div class="floating-widget xl:visible">
        <ul class="floating-list">
            <li class="floating-item group">
                <button title="Beri Penilaian" class="floating-button">
                    <i class="floating-icon" style="mask-image:url(/icons/smile.svg); background-color:white;"></i>
                    <p class="floating-text group-hover:block">Beri Penilaian</p>
                </button>
            </li>
            <li class="floating-item group">
                <button title="Aduan Warga" class="floating-button">
                    <i class="floating-icon" style="mask-image:url(/icons/announcement.svg); background-color:white;"></i>
                    <p class="floating-text group-hover:block">Aduan Warga</p>
                </button>
            </li>
            <li class="floating-item group">
                <button title="Aksesibilitas" class="floating-button">
                    <i class="floating-icon" style="mask-image:url(/icons/acces.svg); background-color:white;"></i>
                    <p class="floating-text group-hover:block">Aksesibilitas</p>
                </button>
            </li>
            <li class="floating-item group">
                <button title="Akses Cepat" class="floating-button">
                    <i class="floating-icon" style="mask-image:url(/icons/quick-access.svg); width:32px; height:32px; background-color:white;"></i>
                    <p class="floating-text group-hover:block">Akses Cepat</p>
                </button>
            </li>
        </ul>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>