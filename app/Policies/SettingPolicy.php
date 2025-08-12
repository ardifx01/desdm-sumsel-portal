<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan semua aksi HANYA untuk super_admin.
     * Kita tidak perlu method before() di sini karena aturannya sederhana.
     */
    private function isSuperAdmin(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    // Method 'view' akan kita gunakan untuk mengontrol akses ke halaman edit
    public function view(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    // Method 'update' akan kita gunakan untuk mengontrol proses penyimpanan
    public function update(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }
}