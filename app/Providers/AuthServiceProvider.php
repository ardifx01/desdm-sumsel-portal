<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post; 
use App\Policies\PostPolicy; 
use App\Models\Dokumen; 
use App\Policies\DokumenPolicy; 
use App\Models\Album; 
use App\Policies\AlbumPolicy; 
use App\Models\Category;
use App\Models\DokumenCategory;
use App\Policies\CategoryPolicy;
use App\Policies\DokumenCategoryPolicy;
use App\Models\Setting; 
use App\Policies\SettingPolicy; 
use App\Models\Comment; 
use App\Policies\CommentPolicy; 
use App\Models\InformasiPublik; 
use App\Policies\InformasiPublikPolicy; 
use App\Models\InformasiPublikCategory; 
use App\Policies\InformasiPublikCategoryPolicy; 
use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use App\Policies\PermohonanInformasiPolicy;
use App\Policies\PengajuanKeberatanPolicy;
use App\Models\StaticPage; 
use App\Policies\StaticPagePolicy; 
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
        Category::class => CategoryPolicy::class, 
        DokumenCategory::class => DokumenCategoryPolicy::class, 
        Setting::class => SettingPolicy::class,
        Comment::class => CommentPolicy::class,
        InformasiPublik::class => InformasiPublikPolicy::class,
        InformasiPublikCategory::class => InformasiPublikCategoryPolicy::class,
        PermohonanInformasi::class => PermohonanInformasiPolicy::class,
        PengajuanKeberatan::class => PengajuanKeberatanPolicy::class,
        StaticPage::class => StaticPagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Aturan ini sudah benar:
        // "Kemampuan 'manage-organisasi' diizinkan jika peran pengguna adalah 'super_admin'"
        Gate::define('manage-organisasi', function ($user) {
            return $user->role === 'super_admin';
        });

        Gate::define('manage-users', function (User $user) {
            return $user->role === 'super_admin';
        });
    }
}
