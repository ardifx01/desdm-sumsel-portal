<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublik;
use App\Models\InformasiPublikCategory;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    public function index(Request $request)
    {
        $categories = InformasiPublikCategory::all(); // Ambil semua kategori

        $query = InformasiPublik::with('category')
                                ->where('is_active', true)
                                ->orderBy('tanggal_publikasi', 'desc');

        // Filter berdasarkan kategori (jika ada parameter 'kategori' di URL)
        if ($request->has('kategori') && $request->kategori != 'all') {
            $category = InformasiPublikCategory::where('slug', $request->kategori)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Pencarian berdasarkan judul atau konten
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%');
            });
        }

        $informasiPublik = $query->paginate(10); // Paginate 10 item per halaman

        return view('informasi-publik.index', compact('informasiPublik', 'categories'));
    }

    public function show($slug)
    {
        // Tampilkan detail informasi publik berdasarkan slug
        $informasi = InformasiPublik::where('slug', $slug)
                                    ->where('is_active', true)
                                    ->firstOrFail(); // Temukan, jika tidak 404

        // Tambahkan hit count (opsional)
        $informasi->increment('hits');

        return view('informasi-publik.show', compact('informasi'));
    }

    // Metode untuk menampilkan informasi berdasarkan kategori langsung (opsional, bisa dihandle di index)
    public function showByCategory($categorySlug)
    {
        $category = InformasiPublikCategory::where('slug', $categorySlug)->firstOrFail();

        $informasiPublik = InformasiPublik::where('category_id', $category->id)
                                        ->where('is_active', true)
                                        ->orderBy('tanggal_publikasi', 'desc')
                                        ->paginate(10);

        return view('informasi-publik.index', compact('informasiPublik', 'category')); // Bisa juga buat view terpisah
    }
}