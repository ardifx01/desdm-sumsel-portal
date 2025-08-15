<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Http\Resources\DokumenResource; // <-- Kita akan buat ini
use App\Http\Resources\DokumenCollection; // <-- Kita akan buat ini

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar dokumen.
     */
    public function index()
    {
        $dokumen = Dokumen::with('category')
                          ->where('is_active', true)
                          ->latest('tanggal_publikasi')
                          ->paginate(10);

        return new DokumenCollection($dokumen);
    }

    /**
     * Menampilkan satu dokumen spesifik.
     */
    public function show(Dokumen $dokuman) // Laravel akan menggunakan 'dokuman' dari nama parameter rute
    {
        // Pastikan hanya dokumen yang aktif yang bisa diakses
        if (!$dokuman->is_active) {
            return response()->json(['message' => 'Dokumen tidak ditemukan.'], 404);
        }

        // Tambahkan logika increment hits
        $dokuman->increment('hits');

        return new DokumenResource($dokuman->load('category'));
    }
}