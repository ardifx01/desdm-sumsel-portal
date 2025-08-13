<?php

namespace App\Policies;

use App\Models\InformasiPublikCategory;
use App\Models\User;

class InformasiPublikCategoryPolicy
{
    private function isAuthorizedAdmin(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'ppid_admin']);
    }

    public function viewAny(User $user): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function view(User $user, InformasiPublikCategory $informasiPublikCategory): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function update(User $user, InformasiPublikCategory $informasiPublikCategory): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function delete(User $user, InformasiPublikCategory $informasiPublikCategory): bool
    {
        return $this->isAuthorizedAdmin($user);
    }
}