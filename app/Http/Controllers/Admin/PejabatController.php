<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PejabatController extends Controller
{
    public function index()
    {
        $pejabat = Pejabat::orderBy('urutan', 'asc')->orderBy('nama', 'asc')->paginate(10);
        return view('admin.pejabat.index', compact('pejabat'));
    }

    public function create()
    {
        return view('admin.pejabat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:pejabat,nip',
            'deskripsi_singkat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'urutan' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ], [
            'nip.unique' => 'NIP ini sudah terdaftar.',
        ]);

        $pejabat = Pejabat::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('foto')) {
            $pejabat->addMediaFromRequest('foto')
                    ->preservingOriginal()
                    ->toMediaCollection('foto_pejabat');
        }

        return redirect()->route('admin.pejabat.index')->with('success', 'Pejabat "' . $pejabat->nama . '" berhasil ditambahkan!');
    }

    public function edit(Pejabat $pejabat)
    {
        return view('admin.pejabat.edit', compact('pejabat'));
    }

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

        $pejabat->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('foto')) {
            $pejabat->clearMediaCollection('foto_pejabat');
            
            $pejabat->addMediaFromRequest('foto')
                    ->toMediaCollection('foto_pejabat');
        }

        return redirect()->route('admin.pejabat.index')->with('success', 'Pejabat "' . $pejabat->nama . '" berhasil diperbarui!');
    }

    public function destroy(Pejabat $pejabat)
    {
        try {
            $pejabat->clearMediaCollection('foto_pejabat');
            $deleteResult = $pejabat->delete();

            if ($deleteResult) {
                return redirect()->route('admin.pejabat.index')->with('success', 'Pejabat "' . $pejabat->nama . '" berhasil dihapus!');
            } else {
                Log::error('Pejabat GAGAL dihapus dari database (delete() mengembalikan false): ' . $pejabat->nama);
                return redirect()->route('admin.pejabat.index')->with('error', 'Gagal menghapus pejabat.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus pejabat (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.pejabat.index')->with('error', 'Gagal menghapus pejabat: ' . $e->getMessage());
        }
    }

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