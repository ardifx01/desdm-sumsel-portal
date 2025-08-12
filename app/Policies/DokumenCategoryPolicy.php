<?php

namespace App\Policies;

use App\Models\DokumenCategory;
use App\Models\User;

class DokumenCategoryPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'super_admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool { return false; }
    public function view(User $user, DokumenCategory $dokumenCategory): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, DokumenCategory $dokumenCategory): bool { return false; }
    public function delete(User $user, DokumenCategory $dokumenCategory): bool { return false; }
}