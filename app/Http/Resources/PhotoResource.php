<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PhotoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $fileExists = $this->file_path && Storage::disk('public')->exists($this->file_path);

        return [
            'id' => $this->id,
            'judul' => $this->judul ?: $this->file_name,
            'deskripsi' => $this->deskripsi,
            'url_gambar' => $fileExists ? asset('storage/' . $this->file_path) : null,
        ];
    }
}