<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AlbumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $thumbnailExists = $this->thumbnail && Storage::disk('public')->exists($this->thumbnail);

        return [
            'id' => $this->id,
            'nama_album' => $this->nama,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'url_thumbnail' => $thumbnailExists ? asset('storage/' . $this->thumbnail) : null,
            'jumlah_foto' => $this->whenCounted('photos'), // Tampil jika jumlah foto di-load
            
            // 'photos' hanya akan dimuat saat mengakses detail album (endpoint show)
            'foto' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}