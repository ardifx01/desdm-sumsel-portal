<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\Pejabat; // Import model Pejabat Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Log; // Untuk logging

class PejabatController extends Controller // Nama kelas adalah PejabatController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pejabat = Pejabat::orderBy('urutan', 'asc')->orderBy('nama', 'asc')->paginate(10);
        return view('admin.pejabat.index', compact('pejabat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pejabat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:pejabat,nip',
            'deskripsi_singkat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB, hanya gambar
            'urutan' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ], [
            'nip.unique' => 'NIP ini sudah terdaftar.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $folderRelativePath = 'pejabat'; // Path: storage/app/public/pejabat
            $fotoPath = $request->file('foto')->store($folderRelativePath, 'public');
        }

        Pejabat::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'foto' => $fotoPath,
            'urutan' => $request->urutan ?: 0, // Default 0 jika kosong
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.pejabat.index')->with('success', 'Pejabat berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pejabat $pejabat) // Menggunakan Route Model Binding
    {
        return view('admin.pejabat.edit', compact('pejabat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pejabat $pejabat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:pejabat,nip,' . $pejabat->id,
            'deskripsi_singkat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'urutan' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ], [
            'nip.unique' => 'NIP ini sudah terdaftar.',
        ]);

        $fotoPath = $pejabat->foto; // Default ke foto lama
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pejabat->foto && Storage::disk('public')->exists($pejabat->foto)) {
                Storage::disk('public')->delete($pejabat->foto);
            }
            $folderRelativePath = 'pejabat';
            $fotoPath = $request->file('foto')->store($folderRelativePath, 'public');
        }

        $pejabat->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'foto' => $fotoPath,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.pejabat.index')->with('success', 'Pejabat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pejabat $pejabat)
    {
        try {
            // Hapus foto fisik jika ada
            if ($pejabat->foto && Storage::disk('public')->exists($pejabat->foto)) {
                Storage::disk('public')->delete($pejabat->foto);
                Log::info('Foto pejabat fisik dihapus: ' . $pejabat->foto);
            }

            $deleteResult = $pejabat->delete(); // Hapus dari database

            if ($deleteResult) {
                Log::info('Pejabat berhasil dihapus dari database: ' . $pejabat->nama);
                return redirect()->route('admin.pejabat.index')->with('success', 'Pejabat berhasil dihapus!');
            } else {
                Log::error('Pejabat GAGAL dihapus dari database (delete() mengembalikan false): ' . $pejabat->nama);
                return redirect()->route('admin.pejabat.index')->with('error', 'Gagal menghapus pejabat.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus pejabat (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.pejabat.index')->with('error', 'Gagal menghapus pejabat: ' . $e->getMessage());
        }
    }

    // Helper function for PHP upload error messages (can be removed if no specific need)
    private function getPhpUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE: return "Ukuran file melebihi batas upload_max_filesize di php.ini.";
            case UPLOAD_ERR_FORM_SIZE: return "Ukuran file melebihi batas MAX_FILE_SIZE di formulir HTML.";
            case UPLOAD_ERR_PARTIAL: return "File hanya terupload sebagian.";
            case UPLOAD_ERR_NO_FILE: return "Tidak ada file yang terupload.";
            case UPLOAD_ERR_NO_TMP_DIR: return "Folder sementara tidak ditemukan.";
            case UPLOAD_ERR_CANT_WRITE: return "Gagal menulis file ke disk.";
            case UPLOAD_ERR_EXTENSION: return "Upload dihentikan oleh ekstensi PHP.";
            default: return "Kesalahan upload tidak diketahui.";
        }
    }
}