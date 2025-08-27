<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    private function getCacheKey(): string
    {
        $baseName = Str::snake(class_basename(Category::class));
        return "sorted_{$baseName}_ids";
    }

    public function created(Category $category): void
    {
        Cache::forget($this->getCacheKey());
    }

    public function deleted(Category $category): void
    {
        Cache::forget($this->getCacheKey());
    }
}