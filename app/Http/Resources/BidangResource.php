<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidangResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_unit' => $this->nama,
            'slug' => $this->slug,
            'tipe' => $this->tipe,
            'tupoksi' => $this->tupoksi,
            'wilayah_kerja' => $this->when($this->tipe === 'cabang_dinas', $this->wilayah_kerja),
            'alamat' => $this->when(in_array($this->tipe, ['UPTD', 'cabang_dinas']), $this->alamat),
            'peta_lokasi' => $this->when(in_array($this->tipe, ['UPTD', 'cabang_dinas']), $this->map),
            'kepala_unit' => new PejabatResource($this->whenLoaded('kepala')),
            'daftar_seksi' => SeksiResource::collection($this->whenLoaded('seksis')),
        ];
    }
}