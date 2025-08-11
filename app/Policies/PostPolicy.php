<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     * Izinkan super_admin untuk melakukan segalanya.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        return null;
    }

    /**
     * Tentukan apakah pengguna dapat melihat daftar berita.
     * (Semua peran admin bisa melihat halaman daftar)
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'editor']);
    }

    /**
     * Tentukan apakah pengguna dapat melihat detail berita.
     * (Editor hanya bisa melihat detail miliknya sendiri)
     */
    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }

    /**
     * Tentukan apakah pengguna dapat membuat berita baru.
     * (Semua peran admin bisa membuat)
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'editor']);
    }

    /**
     * Tentukan apakah pengguna dapat mengedit berita.
     * (Editor hanya bisa mengedit miliknya sendiri)
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }

    /**
     * Tentukan apakah pengguna dapat menghapus berita.
     * (Editor hanya bisa menghapus miliknya sendiri)
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }
}