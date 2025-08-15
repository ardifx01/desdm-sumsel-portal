<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanInformasiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomor_registrasi' => $this->nomor_registrasi,
            'rincian_informasi' => $this->rincian_informasi,
            'tujuan_penggunaan' => $this->tujuan_penggunaan_informasi,
            'jenis_pemohon' => $this->jenis_pemohon,
            'tanggal_permohonan' => $this->tanggal_permohonan->toIso8601String(),
            'status' => $this->status,
            'catatan_admin' => $this->when($this->catatan_admin, $this->catatan_admin), // Tampil jika ada
        ];
    }
}