<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\InformasiPublikCategory;
use App\Observers\InformasiPublikCategoryObserver;
use App\Models\DokumenCategory;
use App\Observers\DokumenCategoryObserver;
use App\Models\Category;
use App\Observers\CategoryObserver;

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

        // --- KODE UNTUK MEMBAGI PENGATURAN UMUM WEB ---
        try {
            $settings = Setting::pluck('value', 'key');
            View::share('settings', $settings);
        } catch (\Exception $e) {
            // Ini akan mencegah error saat menjalankan migration
            // karena tabel 'settings' mungkin belum ada
            View::share('settings', collect());
        }
        // --- Akhir Kode Pengaturan ---

        InformasiPublikCategory::observe(InformasiPublikCategoryObserver::class);
        DokumenCategory::observe(DokumenCategoryObserver::class);
        Category::observe(CategoryObserver::class);
    }
}