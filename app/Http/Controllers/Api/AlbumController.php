<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Resources\AlbumResource; // <-- Kita akan buat ini
use App\Http\Resources\AlbumCollection; // <-- Kita akan buat ini

class AlbumController extends Controller
{
    /**
     * Menampilkan daftar album.
     */
    public function index()
    {
        $albums = Album::withCount('photos') // Eager load jumlah foto
                       ->where('is_active', true)
                       ->latest()
                       ->paginate(10);

        return new AlbumCollection($albums);
    }

    /**
     * Menampilkan satu album spesifik beserta foto-fotonya.
     */
    public function show(Album $album)
    {
        // Pastikan hanya album yang aktif yang bisa diakses
        if (!$album->is_active) {
            return response()->json(['message' => 'Album tidak ditemukan.'], 404);
        }

        // Eager load relasi foto yang aktif
        $album->load(['photos' => function ($query) {
            $query->where('is_active', true)->orderBy('created_at', 'desc');
        }]);

        return new AlbumResource($album);
    }
}