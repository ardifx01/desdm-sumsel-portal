<?php

namespace App\Policies;

use App\Models\StaticPage;
use App\Models\User;

class StaticPagePolicy
{
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

    public function viewAny(User $user): bool { return false; }
    public function view(User $user, StaticPage $staticPage): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, StaticPage $staticPage): bool { return false; }
    public function delete(User $user, StaticPage $staticPage): bool { return false; }
}