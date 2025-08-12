<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post; // <-- Tambahkan ini
use App\Policies\PostPolicy; // <-- Tambahkan ini
use App\Models\Dokumen; // <-- Tambahkan ini
use App\Policies\DokumenPolicy; // <-- Tambahkan ini
use App\Models\Album; // <-- Tambahkan ini
use App\Policies\AlbumPolicy; // <-- Tambahkan ini
use App\Models\Category;
use App\Models\DokumenCategory;
use App\Policies\CategoryPolicy;
use App\Policies\DokumenCategoryPolicy;
use App\Models\Setting; // <-- Tambahkan ini
use App\Policies\SettingPolicy; // <-- Tambahkan ini
use App\Models\Comment; // <-- Tambahkan ini
use App\Policies\CommentPolicy; // <-- Tambahkan ini

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Dokumen::class => DokumenPolicy::class,
        Album::class => AlbumPolicy::class,
        Category::class => CategoryPolicy::class, // <-- Tambahkan ini
        DokumenCategory::class => DokumenCategoryPolicy::class, // <-- Tambahkan ini
        Setting::class => SettingPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage-users', function (User $user) {
        return $user->role === 'super_admin';
    });
    }
}
