<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\InformasiPublik; // Import model InformasiPublik Anda
use App\Models\InformasiPublikCategory; // Import model InformasiPublikCategory Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Log; // Untuk logging

class InformasiPublikController extends Controller // Nama kelas adalah InformasiPublikController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = InformasiPublikCategory::orderBy('nama')->get();

        $query = InformasiPublik::with('category')->orderBy('tanggal_publikasi', 'desc');

        // Implementasi Filter dan Pencarian (sesuai modul Dokumen)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', (int)$request->category_id);
        }
        if ($request->filled('is_active')) { // '1' untuk aktif, '0' untuk non-aktif, kosong untuk semua
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $informasiPublik = $query->paginate(10);

        return view('admin.informasi-publik.index', compact('informasiPublik', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = InformasiPublikCategory::orderBy('nama')->get();
        return view('admin.informasi-publik.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'required|exists:informasi_publik_categories,id',
            'konten' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:25120', // Dokumen, Max 5MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar, Max 2MB
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ], [
            'file_dokumen.mimes' => 'Format file dokumen tidak diizinkan.',
            'thumbnail.mimes' => 'Format thumbnail tidak diizinkan.',
        ]);

        $filePath = null;
        $fileNama = null;
        $fileTipe = null;
        $thumbnailPath = null;

        // Upload File Dokumen (jika ada)
        if ($request->hasFile('file_dokumen')) {
            $uploadedFile = $request->file('file_dokumen');
            // Path relatif dari storage/app/public/
            $folderRelativePath = 'informasi_publik/dokumen'; // Simpan di storage/app/public/informasi_publik/dokumen
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        // Upload Thumbnail (jika ada)
        if ($request->hasFile('thumbnail')) {
            $uploadedThumbnail = $request->file('thumbnail');
            $folderRelativePath = 'informasi_publik/thumbnails'; // Simpan di storage/app/public/informasi_publik/thumbnails
            $thumbnailPath = $uploadedThumbnail->store($folderRelativePath, 'public');
        }

        InformasiPublik::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.informasi-publik.index')->with('success', 'Item informasi publik berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiPublik $informasi_publik_item) // Menggunakan Route Model Binding
    {
        $categories = InformasiPublikCategory::orderBy('nama')->get();
        return view('admin.informasi-publik.edit', compact('informasi_publik_item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiPublik $informasi_publik_item)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'required|exists:informasi_publik_categories,id',
            'konten' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:25120',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ], [
            'file_dokumen.mimes' => 'Format file dokumen tidak diizinkan.',
            'thumbnail.mimes' => 'Format thumbnail tidak diizinkan.',
        ]);

        $filePath = $informasi_publik_item->file_path;
        $fileNama = $informasi_publik_item->file_nama;
        $fileTipe = $informasi_publik_item->file_tipe;
        $thumbnailPath = $informasi_publik_item->thumbnail;

        // Update File Dokumen (jika ada)
        if ($request->hasFile('file_dokumen')) {
            if ($informasi_publik_item->file_path && Storage::disk('public')->exists($informasi_publik_item->file_path)) {
                Storage::disk('public')->delete($informasi_publik_item->file_path);
            }
            $uploadedFile = $request->file('file_dokumen');
            $folderRelativePath = 'informasi_publik/dokumen';
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        // Update Thumbnail (jika ada)
        if ($request->hasFile('thumbnail')) {
            if ($informasi_publik_item->thumbnail && Storage::disk('public')->exists($informasi_publik_item->thumbnail)) {
                Storage::disk('public')->delete($informasi_publik_item->thumbnail);
            }
            $uploadedThumbnail = $request->file('thumbnail');
            $folderRelativePath = 'informasi_publik/thumbnails';
            $thumbnailPath = $uploadedThumbnail->store($folderRelativePath, 'public');
        }

        $informasi_publik_item->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.informasi-publik.index')->with('success', 'Item informasi publik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiPublik $informasi_publik_item) // Parameter rute
    {
        try {
            // Hapus file dokumen terkait jika ada
            if ($informasi_publik_item->file_path && Storage::disk('public')->exists($informasi_publik_item->file_path)) {
                Storage::disk('public')->delete($informasi_publik_item->file_path);
                Log::info('File dokumen informasi publik fisik dihapus: ' . $informasi_publik_item->file_path);
            }
            // Hapus thumbnail terkait jika ada
            if ($informasi_publik_item->thumbnail && Storage::disk('public')->exists($informasi_publik_item->thumbnail)) {
                Storage::disk('public')->delete($informasi_publik_item->thumbnail);
                Log::info('Thumbnail informasi publik fisik dihapus: ' . $informasi_publik_item->thumbnail);
            }

            $deleteResult = $informasi_publik_item->delete(); // Hapus dari database

            if ($deleteResult) {
                Log::info('Item informasi publik berhasil dihapus dari database: ' . $informasi_publik_item->judul);
                return redirect()->route('admin.informasi-publik.index')->with('success', 'Item informasi publik berhasil dihapus!');
            } else {
                Log::error('Item informasi publik GAGAL dihapus dari database (delete() mengembalikan false): ' . $informasi_publik_item->judul);
                return redirect()->route('admin.informasi-publik.index')->with('error', 'Gagal menghapus item informasi publik.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus item informasi publik (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.informasi-publik.index')->with('error', 'Gagal menghapus item informasi publik: ' . $e->getMessage());
        }
    }

    // Helper function for PHP upload error messages (can be removed if no specific need)
    private function getPhpUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "Ukuran file melebihi batas upload_max_filesize di php.ini.";
            case UPLOAD_ERR_FORM_SIZE:
                return "Ukuran file melebihi batas MAX_FILE_SIZE di formulir HTML.";
            case UPLOAD_ERR_PARTIAL:
                return "File hanya terupload sebagian.";
            case UPLOAD_ERR_NO_FILE:
                return "Tidak ada file yang terupload.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Folder sementara tidak ditemukan.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Gagal menulis file ke disk.";
            case UPLOAD_ERR_EXTENSION:
                return "Upload dihentikan oleh ekstensi PHP.";
            default:
                return "Kesalahan upload tidak diketahui.";
        }
    }
}