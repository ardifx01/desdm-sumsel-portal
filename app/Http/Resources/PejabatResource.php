<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PejabatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'jabatan' => $this->jabatan,
            'nip' => $this->nip,
            'deskripsi' => $this->deskripsi_singkat,
            'url_foto' => $this->getFirstMediaUrl('foto_pejabat'),
            'url_foto_thumbnail' => $this->getFirstMediaUrl('foto_pejabat', 'thumb'),
        ];
    }
}