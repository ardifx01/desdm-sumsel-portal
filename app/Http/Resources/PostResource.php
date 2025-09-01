<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // --- LOGIKA BARU YANG SUDAH DIPERBAIKI ---
        $imageUrl = null;
        $thumbnailUrl = null;

        // Prioritas 1: Cek Spatie Media Library dengan pengecekan file fisik
        if ($this->hasMedia('featured_image')) {
            $media = $this->getFirstMedia('featured_image');
            // Cek apakah objek media ada DAN file fisiknya ada
            if ($media && file_exists($media->getPath())) {
                $imageUrl = $media->getUrl();
                // Cek juga apakah file thumbnail ada
                if (file_exists($media->getPath('thumb'))) {
                    $thumbnailUrl = $media->getUrl('thumb');
                } else {
                    $thumbnailUrl = $imageUrl; // Fallback ke gambar asli jika thumb tidak ada
                }
            }
        } 
        
        // Prioritas 2: Cek kolom featured_image_url lama jika Spatie gagal
        if (is_null($imageUrl) && $this->featured_image_url && Storage::disk('public')->exists($this->featured_image_url)) {
            $imageUrl = asset('storage/' . $this->featured_image_url);
            $thumbnailUrl = $imageUrl; // Untuk fallback, thumbnail sama dengan gambar asli
        }
        // --------------------------------

        return [
            'id' => $this->id,
            'judul' => $this->title,
            'slug' => $this->slug,
            'kutipan' => $this->excerpt,
            'konten_html' => $this->when($this->relationLoaded('author'), $this->content_html), // Hanya tampilkan konten jika di halaman detail
            
            'gambar_unggulan' => $imageUrl,
            'gambar_unggulan_thumbnail' => $thumbnailUrl,

            'kategori' => $this->category->name ?? null,
            'penulis' => $this->author->name ?? null,
            'tanggal_publikasi' => $this->created_at->toIso8601String(),
            'jumlah_dilihat' => $this->hits,
        ];
    }
}