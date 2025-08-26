<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ $settings['app_name'] ?? 'DESDM SUMSEL' }}</title>

    {{-- Favicon --}}
    @if(isset($settings['app_favicon']) && Storage::disk('public')->exists($settings['app_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings['app_favicon']) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.ico') }}"> {{-- Default fallback --}}
    @endif

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Pustaka Ikon --}}
    <!-- 1. Bootstrap Icons (untuk ikon 'bi bi-...') -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    
    <!-- 2. Font Awesome (untuk ikon 'fas fa-...' dan 'fab fa-...') - INI YANG HILANG -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Vite Assets --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Slot untuk script atau style per halaman --}}
    {{ $head ?? '' }}
</head>
<body data-pejabat-modal-url="{{ route('pejabat.showModal', ['pejabat' => 'PEJABAT_ID_PLACEHOLDER']) }}">

    <div id="app">
        @include('partials.header')

        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    {{-- Tombol "Kembali ke atas" --}}
    <button id="scroll-to-top" class="btn btn-light rounded-pill shadow" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i> Kembali ke atas
    </button>

    {{-- Widget Mengambang --}}
    <div class="floating-widget xl:visible">
        {{-- ... (kode widget tidak berubah) ... --}}
    </div>

    {{-- Bootstrap JS (opsional jika sudah di-bundle oleh Vite di app.js) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    @stack('scripts')
</body>
</html>