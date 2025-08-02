<?php

namespace App\Support;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class ModulePathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $module = Str::plural(Str::lower(class_basename($media->model)));
        
        // Cek jika modul adalah 'pejabats', maka tidak ada folder tanggal
        if ($module === 'pejabats') {
            return "images/{$module}/" . $media->id . '/';
        }
        
        // Untuk modul lain (misal: 'posts'), gunakan path dengan tanggal
        return "images/{$module}/" . date('Y') . '/' . date('m') . '/' . $media->id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}