<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * Tentukan apakah pengguna dapat melihat daftar komentar.
     */
    public function viewAny(User $user): bool
    {
        // Izinkan super_admin (sudah ditangani oleh before()) dan editor
        return $user->role === 'editor';
    }

    /**
     * Tentukan apakah pengguna dapat melihat detail komentar.
     * Editor hanya bisa melihat detail komentar di postingannya sendiri.
     */
    public function view(User $user, Comment $comment): bool
    {
        return $user->id === $comment->post->author_id;
    }

    /**
     * Tentukan apakah pengguna dapat menyetujui/menolak (update) komentar.
     * Editor hanya bisa update komentar di postingannya sendiri.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->post->author_id;
    }

    /**
     * Tentukan apakah pengguna dapat menghapus komentar.
     * Editor hanya bisa menghapus komentar di postingannya sendiri.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->post->author_id;
    }

    /**
     * Tentukan apakah pengguna dapat membalas komentar.
     * Editor hanya bisa membalas komentar di postingannya sendiri.
     */
    public function reply(User $user, Comment $comment): bool
    {
        return $user->id === $comment->post->author_id;
    }
}