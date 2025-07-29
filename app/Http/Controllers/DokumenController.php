<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\DokumenCategory;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $categories = DokumenCategory::all(); // Ambil semua kategori dokumen

        $query = Dokumen::with('category')
                        ->where('is_active', true)
                        ->orderBy('tanggal_publikasi', 'desc');

        // Filter berdasarkan kategori (jika ada parameter 'kategori' di URL)
        if ($request->has('kategori') && $request->kategori != 'all') {
            $category = DokumenCategory::where('slug', $request->kategori)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Pencarian berdasarkan judul atau deskripsi
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $dokumen = $query->paginate(10); // Paginate 10 item per halaman

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