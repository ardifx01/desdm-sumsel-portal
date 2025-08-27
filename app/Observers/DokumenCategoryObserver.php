<?php

namespace App\Observers;

use App\Models\DokumenCategory;
use Illuminate\Support\Str; // <-- Tambahkan import Str
use Illuminate\Support\Facades\Cache;

class DokumenCategoryObserver
{
    /**
     * Mendapatkan kunci cache yang sesuai dengan Trait.
     */
    private function getCacheKey(): string
    {
        $baseName = Str::snake(class_basename(DokumenCategory::class));
        return "sorted_{$baseName}_ids";
    }

    public function created(DokumenCategory $dokumenCategory): void
    {
        Cache::forget($this->getCacheKey());
    }

    public function deleted(DokumenCategory $dokumenCategory): void
    {
        Cache::forget($this->getCacheKey());
    }
}