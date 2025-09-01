<?php

namespace App\Support;

// app/Support/ModulePathGenerator.php

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Illuminate\Support\Str;

class ModulePathGenerator implements PathGenerator
{
    /**
     * Mendapatkan path dasar untuk file media, TIDAK TERMASUK nama file.
     * Logika ini sekarang menangani path yang berbeda untuk model yang berbeda.
     */
    public function getPath(Media $media): string
    {
        // Ambil nama model dari 'App\Models\Post' menjadi 'posts'
        $modelType = Str::plural(Str::kebab(class_basename($media->model_type)));

        // ===============================================
        //           LOGIKA KONDISIONAL KUNCI
        // ===============================================

        // Jika model adalah Post, gunakan struktur folder Y/m
        if ($media->model_type === \App\Models\Post::class) {
            $year = $media->created_at->format('Y');
            $month = $media->created_at->format('m');
            $mediaId = $media->id;

            return "images/{$modelType}/{$year}/{$month}/{$mediaId}/";
        }

        // Untuk semua model lain (Pejabat, dll.), gunakan struktur ID saja.
        $mediaId = $media->id;
        return "images/{$modelType}/{$mediaId}/";
    }

    /**
     * Mendapatkan path untuk konversi. (Tidak perlu diubah)
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    /**
     * Mendapatkan path untuk gambar responsif. (Tidak perlu diubah)
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}