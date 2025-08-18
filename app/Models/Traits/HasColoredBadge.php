<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasColoredBadge
{
    /**
     * Mendapatkan SELURUH string kelas CSS untuk badge kategori secara dinamis.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function badgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. Definisikan kelas dasar yang sama untuk SEMUA badge
                $baseClasses = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full';

                // 2. Definisikan palet warna yang Anda inginkan
                $colorClasses = [
                    'bg-red-100 text-red-800',
                    'bg-orange-100 text-orange-800',
                    'bg-amber-100 text-amber-800',
                    'bg-lime-100 text-lime-800',
                    'bg-green-100 text-green-800',
                    'bg-teal-100 text-teal-800',
                    'bg-cyan-100 text-cyan-800',
                    'bg-blue-100 text-blue-800',
                    'bg-indigo-100 text-indigo-800',
                    'bg-purple-100 text-purple-800',
                    'bg-fuchsia-100 text-fuchsia-800',
                    'bg-rose-100 text-rose-800',
                ];

                // 3. Dapatkan daftar semua kategori
                $allCategories = \App\Models\Category::pluck('id')->toArray();
                
                // Cari indeks kategori saat ini dalam daftar
                $key = array_search($this->id, $allCategories);
                
                // Pilih kelas warna berdasarkan indeks
                $selectedColor = $colorClasses[$key % count($colorClasses)];

                // 4. Gabungkan kelas dasar dan kelas warna, lalu kembalikan
                return "{$baseClasses} {$selectedColor}";
            },
        );
    }
}