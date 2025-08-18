<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasFrontendBadge
{
    /**
     * Mendapatkan kelas CSS badge Bootstrap untuk frontend secara dinamis.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function frontendBadgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Palet warna Bootstrap yang lebih beragam
                $colors = [
                    'badge-primary',
                    'badge-secondary',
                    'badge-success',
                    'badge-danger',
                    'badge-warning',
                    'badge-info',
                    'badge-dark',
                ];

                // Dapatkan daftar semua kategori DARI MODEL SAAT INI, diurutkan berdasarkan ID
                $sortedCategoryIds = self::query()
                                        ->orderBy('id')
                                        ->pluck('id')
                                        ->all();

                // Cari posisi kategori saat ini dalam daftar yang sudah diurutkan
                $key = array_search($this->id, $sortedCategoryIds);

                // Pilih kelas warna berdasarkan posisi
                $selectedColor = $colors[$key % count($colors)];

                return "badge {$selectedColor}";
            },
        );
    }
}