<?php

namespace App\Http\Controllers\Admin;

use App\Models\DokumenCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate; // <-- Ditambahkan

class DokumenCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', DokumenCategory::class);
        // Tambahkan withCount untuk menghitung jumlah dokumen secara efisien
        $categories = DokumenCategory::withCount('dokumen')->orderBy('nama')->paginate(10);
        return view('admin.dokumen-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', DokumenCategory::class);
        return view('admin.dokumen-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', DokumenCategory::class);

        $request->validate([
            'nama' => 'required|string|max:100|unique:dokumen_categories,nama',
            'deskripsi' => 'nullable|string',
        ], [
            'nama.unique' => 'Nama kategori dokumen sudah ada.',
        ]);

        DokumenCategory::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.dokumen-categories.index')->with('success', 'Kategori dokumen berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenCategory $category_dokumen)
    {
        Gate::authorize('update', $category_dokumen);
        $category = $category_dokumen;
        return view('admin.dokumen-categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenCategory $category_dokumen)
    {
        Gate::authorize('update', $category_dokumen);

        $request->validate([
            'nama' => 'required|string|max:100|unique:dokumen_categories,nama,' . $category_dokumen->id,
            'deskripsi' => 'nullable|string',
        ], [
            'nama.unique' => 'Nama kategori dokumen sudah ada.',
        ]);

        $category_dokumen->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.dokumen-categories.index')->with('success', 'Kategori dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenCategory $category_dokumen)
    {
        Gate::authorize('delete', $category_dokumen);

        if ($category_dokumen->dokumen()->count() > 0) {
            return redirect()->route('admin.dokumen-categories.index')->with('error', 'Gagal menghapus! Masih ada ' . $category_dokumen->dokumen()->count() . ' dokumen dalam kategori ini.');
        }

        $category_dokumen->delete();
        return redirect()->route('admin.dokumen-categories.index')->with('success', 'Kategori dokumen berhasil dihapus!');
    }
}