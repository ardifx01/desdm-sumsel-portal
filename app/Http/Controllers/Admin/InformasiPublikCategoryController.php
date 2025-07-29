<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\InformasiPublikCategory; // Import model InformasiPublikCategory Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk Str::slug

class InformasiPublikCategoryController extends Controller // Nama kelas adalah InformasiPublikCategoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua kategori informasi publik
        $categories = InformasiPublikCategory::orderBy('nama')->paginate(10);
        return view('admin.informasi-publik-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.informasi-publik-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:informasi_publik_categories,nama',
            'deskripsi' => 'nullable|string', // Tambahkan validasi untuk deskripsi
        ], [
            'nama.unique' => 'Nama kategori informasi publik sudah ada.',
        ]);

        InformasiPublikCategory::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama), // Otomatis membuat slug dari nama
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.informasi-publik-categories.index')->with('success', 'Kategori informasi publik berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiPublikCategory $informasi_publik_category) // Menggunakan Route Model Binding
    {
        return view('admin.informasi-publik-categories.edit', compact('informasi_publik_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiPublikCategory $informasi_publik_category)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:informasi_publik_categories,nama,' . $informasi_publik_category->id,
            'deskripsi' => 'nullable|string', // Tambahkan validasi untuk deskripsi
        ], [
            'nama.unique' => 'Nama kategori informasi publik sudah ada.',
        ]);

        $informasi_publik_category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.informasi-publik-categories.index')->with('success', 'Kategori informasi publik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiPublikCategory $informasi_publik_category)
    {
        try {
            // Hapus semua item informasi publik yang terkait dengan kategori ini
            $informasi_publik_category->informasiPublik()->delete(); // Relasi 'informasiPublik()' di model InformasiPublikCategory

            $deleteResult = $informasi_publik_category->delete(); // Hapus kategori

            if ($deleteResult) {
                Log::info('Kategori informasi publik berhasil dihapus dari database: ' . $informasi_publik_category->nama);
                return redirect()->route('admin.informasi-publik-categories.index')->with('success', 'Kategori informasi publik berhasil dihapus!');
            } else {
                Log::error('Kategori informasi publik GAGAL dihapus dari database (delete() mengembalikan false): ' . $informasi_publik_category->nama);
                return redirect()->route('admin.informasi-publik-categories.index')->with('error', 'Gagal menghapus kategori informasi publik.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kategori informasi publik (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.informasi-publik-categories.index')->with('error', 'Gagal menghapus kategori informasi publik: ' . $e->getMessage());
        }
    }
}