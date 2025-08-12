<?php

namespace App\Policies;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DokumenPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan semua aksi HANYA untuk super_admin.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        return null;
    }

    // Kita biarkan method di bawah ini kosong (return false secara default)
    // karena `before()` sudah menangani semuanya.

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Dokumen $dokumen): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Dokumen $dokumen): bool
    {
        return false;
    }

    public function delete(User $user, Dokumen $dokumen): bool
    {
        return false;
    }
}