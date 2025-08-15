<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeksiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_seksi' => $this->nama_seksi,
            'tugas' => $this->tugas,
            'urutan' => $this->urutan,
            'kepala_seksi' => new PejabatResource($this->whenLoaded('kepala')),
        ];
    }
}