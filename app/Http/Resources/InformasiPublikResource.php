<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class InformasiPublikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fileExists = $this->file_path && Storage::disk('public')->exists($this->file_path);
        $thumbnailExists = $this->thumbnail && Storage::disk('public')->exists($this->thumbnail);

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'konten_html' => $this->konten,
            'kategori' => $this->category->nama ?? null,
            'tanggal_publikasi' => $this->tanggal_publikasi->toIso8601String(),
            'url_thumbnail' => $thumbnailExists ? asset('storage/' . $this->thumbnail) : null,
            'lampiran' => [
                'nama_file' => $this->file_nama,
                'url_unduh' => $fileExists ? asset('storage/' . $this->file_path) : null,
            ],
            'jumlah_dilihat' => $this->hits,
        ];
    }
}