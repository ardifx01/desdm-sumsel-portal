<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'embed_code',
        'thumbnail',
        'is_active',
    ];

    /**
     * Accessor untuk mendapatkan URL thumbnail.
     * Akan mencoba mengambil dari YouTube jika thumbnail manual tidak ada.
     */
    public function getThumbnailUrlAttribute(): string
    {
        // 1. Prioritaskan thumbnail manual jika ada.
        if ($this->thumbnail) {
            return $this->thumbnail;
        }

        // 2. Coba ekstrak ID video YouTube dari kode embed.
        $videoId = null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->embed_code, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            // --- PERBAIKAN DI SINI: Menggunakan URL thumbnail YouTube yang lebih modern dan andal ---
            return "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
        }

        // 3. Jika gagal, kembalikan gambar placeholder.
        // Pastikan Anda punya gambar ini di public/storage/images/placeholder-video.png
        return asset('storage/images/placeholder-video.png');
    }
}