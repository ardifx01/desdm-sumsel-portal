<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pejabat;
use App\Http\Resources\PejabatResource;

class PejabatController extends Controller
{
    /**
     * Menampilkan daftar semua pejabat.
     */
    public function index()
    {
        $pejabat = Pejabat::where('is_active', true)
                          ->orderBy('urutan', 'asc')
                          ->get();

        return PejabatResource::collection($pejabat);
    }

    /**
     * Menampilkan satu pejabat spesifik.
     */
    public function show(Pejabat $pejabat)
    {
        if (!$pejabat->is_active) {
            return response()->json(['message' => 'Pejabat tidak ditemukan.'], 404);
        }

        return new PejabatResource($pejabat);
    }
}