<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\DokumenCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DokumenController extends Controller
{
public function index(Request $request)
{
    // OPTIMASI 1: Cache daftar kategori untuk dropdown
    $categories = Cache::remember('dokumen_categories_list', 60*60, function () {
        return DokumenCategory::orderBy('nama')->get();
    });

    $search = $request->q;

    // OPTIMASI 2: Gunakan LARAVEL SCOUT untuk pencarian
    if ($search) {
        $query = Dokumen::search($search)
                        ->where('is_active', true);
    } else {
        // Query Eloquent biasa jika tidak ada pencarian
        $query = Dokumen::query()
                        ->where('is_active', true)
                        ->orderBy('tanggal_publikasi', 'desc');
    }

    // OPTIMASI 3: Gunakan whereHas untuk filter kategori yang efisien
    if ($request->filled('kategori') && $request->kategori != 'all') {
        $slug = $request->kategori;
        $query->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }
    
    // Eager loading tetap penting untuk query non-pencarian
    if (!$search) {
        $query->with('category');
    }

    // Paginate hasil dan pastikan filter tetap ada di URL pagination
    $dokumen = $query->paginate(10)->withQueryString();

    return view('publikasi.index', compact('dokumen', 'categories'));
}

    public function show($slug)
    {
        // Tampilkan detail dokumen berdasarkan slug
        $dokumen = Dokumen::where('slug', $slug)
                            ->where('is_active', true)
                            ->firstOrFail(); // Temukan, jika tidak 404

        // Tambahkan hit count (opsional)
        $dokumen->increment('hits');

        return view('publikasi.show', compact('dokumen'));
    }
}