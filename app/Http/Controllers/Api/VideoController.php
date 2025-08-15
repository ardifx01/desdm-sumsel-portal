<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Http\Resources\VideoResource; // <-- Kita akan buat ini
use App\Http\Resources\VideoCollection; // <-- Kita akan buat ini

class VideoController extends Controller
{
    /**
     * Menampilkan daftar video.
     */
    public function index()
    {
        $videos = Video::where('is_active', true)
                       ->latest()
                       ->paginate(12);

        return new VideoCollection($videos);
    }

    /**
     * Menampilkan satu video spesifik.
     */
    public function show(Video $video)
    {
        // Pastikan hanya video yang aktif yang bisa diakses
        if (!$video->is_active) {
            return response()->json(['message' => 'Video tidak ditemukan.'], 404);
        }

        return new VideoResource($video);
    }
}