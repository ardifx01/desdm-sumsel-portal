<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post; // <-- Tambahkan ini
use App\Policies\PostPolicy; // <-- Tambahkan ini
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
        Post::class => PostPolicy::class, // <-- Tambahkan baris ini
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
