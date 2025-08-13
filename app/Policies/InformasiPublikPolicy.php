<?php

namespace App\Policies;

use App\Models\InformasiPublik;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InformasiPublikPolicy
{
    use HandlesAuthorization;

    /**
     * Periksa apakah pengguna adalah admin yang berwenang (Super Admin atau PPID Admin).
     */
    private function isAuthorizedAdmin(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'ppid_admin']);
    }

    public function viewAny(User $user): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function view(User $user, InformasiPublik $informasiPublik): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function update(User $user, InformasiPublik $informasiPublik): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function delete(User $user, InformasiPublik $informasiPublik): bool
    {
        return $this->isAuthorizedAdmin($user);
    }
}