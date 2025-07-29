<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\DokumenCategory; // Import model DokumenCategory Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk Str::slug
use Illuminate\Support\Facades\Log; // Untuk logging

class DokumenCategoryController extends Controller // Nama kelas adalah DokumenCategoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua kategori dokumen
        $categories = DokumenCategory::orderBy('nama')->paginate(10);
        return view('admin.dokumen-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dokumen-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:dokumen_categories,nama',
            // Slug akan dibuat otomatis
        ], [
            'nama.unique' => 'Nama kategori dokumen sudah ada.',
        ]);

        DokumenCategory::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama), // Otomatis membuat slug dari nama
            'deskripsi' => $request->deskripsi, // Ambil deskripsi
        ]);

        return redirect()->route('admin.dokumen-categories.index')->with('success', 'Kategori dokumen berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenCategory $category_dokumen) // <-- UBAH PARAMETER INI
    {
        // Sesuaikan nama variabel di dalam metode jika perlu, atau gunakan $category_dokumen langsung
        $category = $category_dokumen; // Opsional: untuk menjaga konsistensi nama variabel di view
        return view('admin.dokumen-categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenCategory $category_dokumen) // Parameter rute sudah diubah ke $category_dokumen
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:dokumen_categories,nama,' . $category_dokumen->id, // <-- PERBAIKI BARIS VALIDASI INI
            'deskripsi' => 'nullable|string', // Pastikan ini ada jika Anda menambahkannya ke form
        ], [
            'nama.unique' => 'Nama kategori dokumen sudah ada.',
        ]);

        $category_dokumen->update([ // <-- Lakukan update pada $category_dokumen
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.dokumen-categories.index')->with('success', 'Kategori dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenCategory $category_dokumen) // Parameter rute sudah diubah ke $category_dokumen
    {
        Log::info('Memulai proses hapus kategori dokumen: ' . $category_dokumen->nama . ' (ID: ' . $category_dokumen->id . ')');

        try {
            // PENTING: Hapus semua dokumen yang terkait dengan kategori ini terlebih dahulu.
            // Ini akan memastikan tidak ada constraint violation jika onDelete('cascade') tidak efektif.
            $category_dokumen->dokumen()->delete(); // Relasi 'dokumen()' di model DokumenCategory

            $deleteResult = $category_dokumen->delete(); // Lakukan penghapusan kategori

            if ($deleteResult) {
                Log::info('Kategori dokumen berhasil dihapus dari database: ' . $category_dokumen->nama);
                return redirect()->route('admin.dokumen-categories.index')->with('success', 'Kategori dokumen berhasil dihapus!');
            } else {
                // Ini akan terjadi jika delete() mengembalikan false tanpa exception
                Log::error('Kategori dokumen GAGAL dihapus dari database (delete() mengembalikan false): ' . $category_dokumen->nama);
                return redirect()->route('admin.dokumen-categories.index')->with('error', 'Gagal menghapus kategori dokumen.');
            }
        } catch (\Exception $e) {
            // Tangkap exception jika ada masalah database/constraint
            Log::error('Gagal menghapus kategori dokumen (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.dokumen-categories.index')->with('error', 'Gagal menghapus kategori dokumen: ' . $e->getMessage());
        }
    }
}