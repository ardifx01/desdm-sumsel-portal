<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cache;

// --- Impor semua model kategori yang akan kita 'dengarkan' ---
use App\Models\Category;
use App\Models\DokumenCategory;
use App\Models\InformasiPublikCategory;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     */
    protected $subscribe = [
        \App\Listeners\UserEventSubscriber::class,
    ];
    
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Callback untuk membersihkan cache nama kategori
        $clearCategoryCache = function () {
            Cache::forget('all_unique_category_names');
        };

        // Daftarkan event listener untuk setiap model kategori
        Event::listen('eloquent.saved: ' . Category::class, $clearCategoryCache);
        Event::listen('eloquent.deleted: ' . Category::class, $clearCategoryCache);

        Event::listen('eloquent.saved: ' . DokumenCategory::class, $clearCategoryCache);
        Event::listen('eloquent.deleted: ' . DokumenCategory::class, $clearCategoryCache);

        Event::listen('eloquent.saved: ' . InformasiPublikCategory::class, $clearCategoryCache);
        Event::listen('eloquent.deleted: ' . InformasiPublikCategory::class, $clearCategoryCache);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}