<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Http\Resources\BidangResource;

class BidangController extends Controller
{
    /**
     * Menampilkan daftar semua bidang/unit.
     */
    public function index()
    {
        $bidang = Bidang::with('kepala')
                        ->where('is_active', true)
                        ->latest()
                        ->get();

        return BidangResource::collection($bidang);
    }

    /**
     * Menampilkan satu bidang/unit spesifik beserta seksinya.
     */
    public function show(Bidang $bidang)
    {
        if (!$bidang->is_active) {
            return response()->json(['message' => 'Unit tidak ditemukan.'], 404);
        }

        // Eager load relasi kepala dan seksi (beserta kepala seksi)
        $bidang->load([
            'kepala', 
            'seksis' => function ($query) {
                $query->where('is_active', true)->orderBy('urutan', 'asc');
            }, 
            'seksis.kepala'
        ]);

        return new BidangResource($bidang);
    }
}