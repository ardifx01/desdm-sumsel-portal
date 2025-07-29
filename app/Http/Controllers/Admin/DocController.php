<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\Dokumen; // Import model Dokumen Anda
use App\Models\DokumenCategory; // Import model DokumenCategory Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Log; // Untuk logging

class DocController extends Controller // Nama kelas adalah DocController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = DokumenCategory::orderBy('nama')->get();

        // Mulai query tanpa filter is_active default yang mengganggu
        $query = Dokumen::with('category')->orderBy('tanggal_publikasi', 'desc');

        // --- Log Parameter Request (Untuk Debugging) ---
        Log::info('DocController@index: Parameter request diterima: ' . json_encode($request->all()));
        Log::info('DocController@index: q=' . $request->get('q') . ', category_id=' . $request->get('category_id') . ', status_aktif=' . $request->get('status_aktif'));

        // Implementasi Filter dan Pencarian
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
            Log::info('DocController@index: Filter "q" diterapkan: ' . $search);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', (int)$request->category_id);
            Log::info('DocController@index: Filter "category_id" diterapkan: ' . (int)$request->category_id);
        }
        // Filter status_aktif: HANYA terapkan jika isiannya '1' atau '0' (menggunakan filled() untuk string '0'/'1')
        // Opsi <option value="">Semua Status</option> tidak akan memicu filter ini.
        if ($request->filled('status_aktif')) { // <-- UBAH KONDISI INI MENJADI FILLED()
            // Konversi string '1'/'0' ke boolean
            $isActive = filter_var($request->status_aktif, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
            Log::info('DocController@index: Filter "status_aktif" diterapkan: ' . ($isActive ? 'Aktif' : 'Non-Aktif'));
        } else {
            // Jika status_aktif kosong atau tidak ada, TIDAK ADA filter is_active yang diterapkan.
            // Ini akan menampilkan semua dokumen (aktif/non-aktif) secara default jika tidak ada filter status yang spesifik.
            Log::info('DocController@index: Filter "status_aktif" tidak diterapkan (Semua Status).');
        }


        $dokumen = $query->paginate(10);

        // --- Log Hasil Query (Untuk Debugging) ---
        Log::info('DocController@index: Jumlah dokumen ditemukan setelah filter: ' . $dokumen->total());


        return view('admin.dokumen.index', compact('dokumen', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DokumenCategory::orderBy('nama')->get();
        return view('admin.dokumen.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'required|exists:dokumen_categories,id',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120', // Max 5MB, hanya dokumen
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ], [
            'file_dokumen.required' => 'File dokumen wajib diunggah.',
            'file_dokumen.mimes' => 'Format file dokumen tidak diizinkan (hanya PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX).',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 5MB.',
        ]);

        $filePath = null;
        $fileNama = null;
        $fileTipe = null;

        if ($request->hasFile('file_dokumen')) {
            $uploadedFile = $request->file('file_dokumen');
            // Menggunakan Storage Facade Laravel
            // Path relatif dari storage/app/public/
            $folderRelativePath = 'dokumen'; // Akan disimpan di storage/app/public/dokumen/
            $filePath = $uploadedFile->store($folderRelativePath, 'public'); // Simpan ke public disk
            // $filePath sekarang akan berisi "dokumen/namafileunik.ext"
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        Dokumen::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokuman) // Menggunakan Route Model Binding
    {
        $categories = DokumenCategory::orderBy('nama')->get();
        return view('admin.dokumen.edit', compact('dokuman', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokumen $dokuman)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'required|exists:dokumen_categories,id',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ], [
            'file_dokumen.mimes' => 'Format file dokumen tidak diizinkan (hanya PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX).',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 5MB.',
        ]);

        $filePath = $dokuman->file_path;
        $fileNama = $dokuman->file_nama;
        $fileTipe = $dokuman->file_tipe;

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($dokuman->file_path && Storage::disk('public')->exists($dokuman->file_path)) {
                Storage::disk('public')->delete($dokuman->file_path);
            }
            $uploadedFile = $request->file('file_dokumen');
            $folderRelativePath = 'dokumen'; // Path: public/dokumen/
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        $dokuman->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokuman)
    {
        // Hapus file fisik terkait jika ada
        if ($dokuman->file_path && Storage::disk('public')->exists($dokuman->file_path)) {
            Storage::disk('public')->delete($dokuman->file_path);
        }
        $dokuman->delete();
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus!');
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