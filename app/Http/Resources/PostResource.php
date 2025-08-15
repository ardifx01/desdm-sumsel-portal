<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'judul' => $this->title,
            'slug' => $this->slug,
            'kutipan' => $this->excerpt,
            'konten_html' => $this->when($this->relationLoaded('author'), $this->content_html), // Hanya tampilkan konten jika di halaman detail
            'gambar_unggulan' => $this->getFirstMediaUrl('featured_image'),
            'kategori' => $this->category->name ?? null,
            'penulis' => $this->author->name ?? null,
            'tanggal_publikasi' => $this->created_at->toIso8601String(),
            'jumlah_dilihat' => $this->hits,
        ];
    }
}