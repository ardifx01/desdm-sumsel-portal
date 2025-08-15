<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kinerja;
use App\Models\SasaranStrategis;
use App\Models\IndikatorKinerja;

class KinerjaPolicy
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

    // --- Method untuk Model Kinerja ---
    public function viewAny(User $user): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, Kinerja $kinerja): bool
    {
        return false;
    }
    public function delete(User $user, Kinerja $kinerja): bool
    {
        return false;
    }

    // --- Method untuk Model SasaranStrategis ---
    public function viewAnySasaranStrategis(User $user): bool
    {
        return false;
    }
    public function createSasaranStrategis(User $user): bool
    {
        return false;
    }
    public function updateSasaranStrategis(User $user, SasaranStrategis $sasaranStrategi): bool
    {
        return false;
    }
    public function deleteSasaranStrategis(User $user, SasaranStrategis $sasaranStrategi): bool
    {
        return false;
    }

    // --- Method untuk Model IndikatorKinerja ---
    public function viewAnyIndikatorKinerja(User $user): bool
    {
        return false;
    }
    public function createIndikatorKinerja(User $user): bool
    {
        return false;
    }
    public function updateIndikatorKinerja(User $user, IndikatorKinerja $indikatorKinerja): bool
    {
        return false;
    }
    public function deleteIndikatorKinerja(User $user, IndikatorKinerja $indikatorKinerja): bool
    {
        return false;
    }
}