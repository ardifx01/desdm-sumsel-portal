<?php

namespace App\Http\Controllers\Admin; // Namespace diubah menjadi Admin

use App\Http\Controllers\Controller; // Pastikan ini meng-extend Controller dasar
use App\Models\Seksi;
use App\Models\Bidang;
use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SeksiController extends Controller // Nama kelas diubah menjadi SeksiController
{
    /**
     * Tampilkan daftar Seksi untuk Bidang tertentu.
     */
    public function index(Bidang $bidang)
    {
        Gate::authorize('manage-organisasi');
        $seksis = $bidang->seksis()->with('kepala')->latest()->paginate(10);
        return view('admin.bidang.seksi.index', compact('bidang', 'seksis'));
    }

    /**
     * Tampilkan form untuk membuat Seksi baru untuk Bidang tertentu.
     */
    public function create(Bidang $bidang)
    {
        Gate::authorize('manage-organisasi');
        $pejabats = Pejabat::all();
        return view('admin.bidang.seksi.create', compact('bidang', 'pejabats'));
    }

    /**
     * Simpan Seksi baru ke database.
     */
    public function store(Request $request, Bidang $bidang)
    {
        Gate::authorize('manage-organisasi');
        $request->validate([
            'nama_seksi' => 'required|string|max:255',
            'tugas' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'pejabat_kepala_id' => 'nullable|exists:pejabat,id',
            'is_active' => 'boolean',
        ]);

        $seksi = $bidang->seksis()->create($request->all());

        return redirect()->route('admin.bidang.seksi.index', $bidang->id)->with('success', 'Seksi ' . $seksi->nama_seksi . ' berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit Seksi yang sudah ada.
     */
    public function edit(Bidang $bidang, Seksi $seksi)
    {
        Gate::authorize('manage-organisasi');
        $pejabats = Pejabat::all();
        return view('admin.bidang.seksi.edit', compact('bidang', 'seksi', 'pejabats'));
    }

    /**
     * Perbarui Seksi yang sudah ada di database.
     */
    public function update(Request $request, Bidang $bidang, Seksi $seksi)
    {
        Gate::authorize('manage-organisasi');
        $request->validate([
            'nama_seksi' => 'required|string|max:255',
            'tugas' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'pejabat_kepala_id' => 'nullable|exists:pejabat,id',
            'is_active' => 'boolean',
        ]);

        $seksi->update($request->all());

        return redirect()->route('admin.bidang.seksi.index', $bidang->id)->with('success', 'Seksi ' . $seksi->nama_seksi . ' berhasil diperbarui.');
    }

    /**
     * Hapus Seksi dari database.
     */
    public function destroy(Bidang $bidang, Seksi $seksi)
    {
        Gate::authorize('manage-organisasi');
        $namaSeksi = $seksi->nama_seksi;
        $seksi->delete();

        return redirect()->route('admin.bidang.seksi.index', $bidang->id)->with('success', 'Seksi ' . $namaSeksi . ' berhasil dihapus.');
    }
}