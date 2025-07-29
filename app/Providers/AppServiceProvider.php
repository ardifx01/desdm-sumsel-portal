<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

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
// --- Memaksa HTTPS untuk Lingkungan Produksi ---
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // --- Akhir Memaksa HTTPS ---
// --- Memaksa Timezone Aplikasi (Mengatasi masalah date.timezone di php.ini) ---
        Carbon::setLocale('id'); // Opsional, untuk format tanggal Bahasa Indonesia
        config(['app.timezone' => 'Asia/Jakarta']); // <-- PENTING: Paksa timezone di sini
        date_default_timezone_set('Asia/Jakarta'); // <-- PENTING: Paksa timezone PHP runtime

    }
}
