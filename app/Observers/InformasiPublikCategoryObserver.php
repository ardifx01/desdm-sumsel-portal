<?php

namespace App\Observers;

use App\Models\InformasiPublikCategory;
use Illuminate\Support\Facades\Cache; // <-- IMPORT CACHE

class InformasiPublikCategoryObserver
{
    /**
     * Handle the InformasiPublikCategory "created" event.
     */
    public function created(InformasiPublikCategory $informasiPublikCategory): void
    {
        // Hapus cache saat kategori baru dibuat
        Cache::forget('sorted_category_ids');
    }

    /**
     * Handle the InformasiPublikCategory "updated" event.
     */
    public function updated(InformasiPublikCategory $informasiPublikCategory): void
    {
        // Tidak perlu melakukan apa-apa saat update, karena urutan ID tidak berubah
    }

    /**
     * Handle the InformasiPublikCategory "deleted" event.
     */
    public function deleted(InformasiPublikCategory $informasiPublikCategory): void
    {
        // Hapus cache saat kategori dihapus
        Cache::forget('sorted_category_ids');
    }
}