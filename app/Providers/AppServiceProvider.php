<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Sudah ada di kode Anda
use Illuminate\Support\Carbon;      // Sudah ada di kode Anda
use Illuminate\Support\Facades\Schema; // Pastikan ini juga ada

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default string length untuk MySQL <= 5.7
        Schema::defaultStringLength(191);

        // --- Memaksa HTTPS untuk Lingkungan Produksi ---
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // --- Akhir Memaksa HTTPS ---

        // --- Memaksa Timezone Aplikasi (Mengatasi masalah date.timezone di php.ini) ---
        Carbon::setLocale('id'); // Opsional, untuk format tanggal Bahasa Indonesia
        config(['app.timezone' => 'Asia/Jakarta']); // <-- PENTING: Paksa timezone di sini
        date_default_timezone_set('Asia/Jakarta'); // <-- PENTING: Paksa timezone PHP runtime
        // --- Akhir Memaksa Timezone ---

        // Pastikan TIDAK ADA KODE UNTUK SETTING ATAU VIEW::SHARE DI SINI
    }
}