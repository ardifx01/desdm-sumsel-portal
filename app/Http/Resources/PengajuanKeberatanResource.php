<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanKeberatanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomor_registrasi_permohonan' => $this->nomor_registrasi_permohonan,
            'jenis_keberatan' => $this->jenis_keberatan,
            'alasan_keberatan' => $this->alasan_keberatan,
            'tanggal_pengajuan' => $this->tanggal_pengajuan->toIso8601String(),
            'status' => $this->status,
            'catatan_admin' => $this->when($this->catatan_admin, $this->catatan_admin), // Tampil jika ada
        ];
    }
}