<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait HasFrontendBadge
{
    protected static ?array $sortedCategoryIdsCache = null;

    /**
     * Membuat kunci cache yang unik berdasarkan nama model.
     * Contoh: DokumenCategory -> 'sorted_dokumen_category_ids'
     *
     * @return string
     */
    protected function getCacheKeyForSorting(): string
    {
        // Membuat nama yang unik dari nama class model ini
        $baseName = Str::snake(class_basename(static::class)); 
        return "sorted_{$baseName}_ids";
    }

    public function frontendBadgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                $colors = [
                                'bg-primary',
                                'bg-secondary',
                                'bg-success',
                                'bg-danger text-white', // Tambahkan text-white agar terbaca
                                'bg-warning text-dark', // Tambahkan text-dark agar terbaca
                                'bg-info text-dark',   // Tambahkan text-dark agar terbaca
                                'bg-dark text-white',  // Tambahkan text-white agar terbaca
                            ];

                // Dapatkan kunci cache yang unik untuk model ini
                $cacheKey = $this->getCacheKeyForSorting();

                // Cek static cache per-request dulu
                if (is_null(self::$sortedCategoryIdsCache)) {
                    // Jika kosong, baru cek cache utama (per aplikasi)
                    self::$sortedCategoryIdsCache = Cache::rememberForever($cacheKey, function () {
                        return self::query()->orderBy('id')->pluck('id')->all();
                    });
                }

                $key = array_search($this->id, self::$sortedCategoryIdsCache);

                if ($key === false) {
                    return 'badge badge-light';
                }

                $selectedColor = $colors[$key % count($colors)];

                return "badge {$selectedColor}";
            },
        );
    }
}