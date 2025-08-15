<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPublik;
use App\Http\Resources\InformasiPublikResource; // <-- Kita akan buat ini
use App\Http\Resources\InformasiPublikCollection; // <-- Kita akan buat ini

class InformasiPublikController extends Controller
{
    /**
     * Menampilkan daftar item informasi publik.
     */
    public function index()
    {
        $informasiPublik = InformasiPublik::with('category')
                                          ->where('is_active', true)
                                          ->latest('tanggal_publikasi')
                                          ->paginate(10);

        return new InformasiPublikCollection($informasiPublik);
    }

    /**
     * Menampilkan satu item informasi publik spesifik.
     */
    public function show(InformasiPublik $informasi_publik_item) // 'informasi_publik_item' sesuai parameter rute
    {
        // Pastikan hanya item yang aktif yang bisa diakses
        if (!$informasi_publik_item->is_active) {
            return response()->json(['message' => 'Informasi tidak ditemukan.'], 404);
        }

        // Tambahkan logika increment hits
        $informasi_publik_item->increment('hits');

        return new InformasiPublikResource($informasi_publik_item->load('category'));
    }
}