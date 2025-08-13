<?php

namespace App\Http\Controllers\Admin;

use App\Models\InformasiPublikCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class InformasiPublikCategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', InformasiPublikCategory::class);
        $categories = InformasiPublikCategory::withCount('informasiPublik')->orderBy('nama')->paginate(10);
        return view('admin.informasi-publik-categories.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('create', InformasiPublikCategory::class);
        return view('admin.informasi-publik-categories.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', InformasiPublikCategory::class);

        $request->validate([
            'nama' => 'required|string|max:100|unique:informasi_publik_categories,nama',
            'deskripsi' => 'nullable|string',
        ]);

        $category = InformasiPublikCategory::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        // PERUBAHAN DI SINI
        return redirect()->route('admin.informasi-publik-categories.index')->with('success', 'Kategori "' . $category->nama . '" berhasil ditambahkan!');
    }

    public function edit(InformasiPublikCategory $informasi_publik_category)
    {
        Gate::authorize('update', $informasi_publik_category);
        return view('admin.informasi-publik-categories.edit', compact('informasi_publik_category'));
    }

    public function update(Request $request, InformasiPublikCategory $informasi_publik_category)
    {
        Gate::authorize('update', $informasi_publik_category);

        $request->validate([
            'nama' => 'required|string|max:100|unique:informasi_publik_categories,nama,' . $informasi_publik_category->id,
            'deskripsi' => 'nullable|string',
        ]);

        $informasi_publik_category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        // PERUBAHAN DI SINI
        return redirect()->route('admin.informasi-publik-categories.index')->with('success', 'Kategori "' . $informasi_publik_category->nama . '" berhasil diperbarui!');
    }

    public function destroy(InformasiPublikCategory $informasi_publik_category)
    {
        Gate::authorize('delete', $informasi_publik_category);

        if ($informasi_publik_category->informasiPublik()->count() > 0) {
            return redirect()->route('admin.informasi-publik-categories.index')->with('error', 'Gagal menghapus! Masih ada ' . $informasi_publik_category->informasiPublik()->count() . ' item dalam kategori ini.');
        }

        $categoryName = $informasi_publik_category->nama; // Simpan nama sebelum dihapus
        $informasi_publik_category->delete();

        // PERUBAHAN DI SINI
        return redirect()->route('admin.informasi-publik-categories.index')->with('success', 'Kategori "' . $categoryName . '" berhasil dihapus!');
    }
}