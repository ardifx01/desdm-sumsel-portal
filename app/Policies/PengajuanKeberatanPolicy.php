<?php

namespace App\Policies;

use App\Models\PengajuanKeberatan;
use App\Models\User;

class PengajuanKeberatanPolicy
{
    private function isAuthorizedAdmin(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'ppid_admin']);
    }

    public function viewAny(User $user): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function view(User $user, PengajuanKeberatan $pengajuanKeberatan): bool
    {
        // Izinkan jika dia admin ATAU jika dia adalah pemilik keberatan
        return $this->isAuthorizedAdmin($user) || $user->id === $pengajuanKeberatan->user_id;
    }

    public function create(User $user): bool
    {
        // Aksi ini dilakukan oleh publik, jadi kita izinkan
        return true;
    }

    public function update(User $user, PengajuanKeberatan $pengajuanKeberatan): bool
    {
        return $this->isAuthorizedAdmin($user);
    }

    public function delete(User $user, PengajuanKeberatan $pengajuanKeberatan): bool
    {
        return $this->isAuthorizedAdmin($user);
    }
}