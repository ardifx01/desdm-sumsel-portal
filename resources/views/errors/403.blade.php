<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak (403)</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    {{-- Memuat CSS dari Vite agar gaya Tailwind berfungsi --}}
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased font-sans bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-md w-full text-center bg-white p-8 sm:p-12 rounded-lg shadow-lg">
            
            {{-- Logo Anda --}}
            <div class="mx-auto h-16 w-auto mb-6">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="w-16 h-16" />
                </a>
            </div>

            <h1 class="text-8xl font-extrabold text-red-500 tracking-wider">403</h1>
            <h2 class="mt-4 text-2xl sm:text-3xl font-bold text-gray-800">Akses Ditolak</h2>
            <p class="mt-4 text-base text-gray-600">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Peran Anda saat ini tidak memiliki hak akses yang diperlukan.
            </p>

            <div class="mt-8">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>