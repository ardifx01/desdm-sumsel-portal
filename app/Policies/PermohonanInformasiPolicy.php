<?php

namespace App\Policies;

use App\Models\PermohonanInformasi;
use App\Models\User;

class PermohonanInformasiPolicy
{
    private function isAuthorizedAdmin(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'ppid_admin']);
    }

    public function viewAny(User $user): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function view(User $user, PermohonanInformasi $permohonanInformasi): bool
    {
        // Izinkan jika dia admin ATAU jika dia adalah pemilik permohonan
        return $this->isAuthorizedAdmin($user) || $user->id === $permohonanInformasi->user_id;
    }

    public function update(User $user, PermohonanInformasi $permohonanInformasi): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function delete(User $user, PermohonanInformasi $permohonanInformasi): bool
    {
        return $this->isAuthorizedAdmin($user);
    }
}