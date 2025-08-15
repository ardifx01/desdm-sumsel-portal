<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DokumenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // PERBAIKAN DI SINI: Lakukan pengecekan file terlebih dahulu
        $fileExists = $this->file_path && Storage::disk('public')->exists($this->file_path);

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->category->nama ?? null,
            'tanggal_publikasi' => $this->tanggal_publikasi->toIso8601String(),
            'nama_file' => $this->file_nama,
            // Gunakan hasil pengecekan untuk menentukan nilai
            'ukuran_file_kb' => $fileExists ? round(Storage::disk('public')->size($this->file_path) / 1024, 2) : 0,
            'url_unduh' => $fileExists ? asset('storage/' . $this->file_path) : null,
            'jumlah_diunduh' => $this->hits,
        ];
    }
}