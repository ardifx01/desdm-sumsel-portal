<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'kode_embed' => $this->embed_code,
            'url_thumbnail' => $this->thumbnail_url, // Menggunakan accessor yang sudah ada
            'tanggal_publikasi' => $this->created_at->toIso8601String(),
        ];
    }
}