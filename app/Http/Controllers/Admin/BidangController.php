<?php

namespace App\Http\Controllers\Admin; // Namespace diubah menjadi Admin

use App\Http\Controllers\Controller; // Pastikan ini meng-extend Controller dasar
use App\Models\Bidang;
use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BidangController extends Controller // Nama kelas diubah menjadi BidangController
{
    /**
     * Tampilkan daftar semua Bidang (Bidang, UPTD, Cabang Dinas).
     */
    public function index()
    {
        $bidangs = Bidang::with('kepala')->latest()->paginate(10);
        return view('admin.bidang.index', compact('bidangs'));
    }

    /**
     * Tampilkan form untuk membuat Bidang baru.
     */
    public function create()
    {
        $pejabats = Pejabat::all();
        return view('admin.bidang.create', compact('pejabats'));
    }

    /**
     * Simpan Bidang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:bidangs,nama',
            'tipe' => 'required|in:bidang,UPTD,cabang_dinas',
            'tupoksi' => 'nullable|string',
            'pejabat_kepala_id' => 'nullable|exists:pejabat,id',
            'wilayah_kerja' => 'nullable|string',
            'alamat' => 'nullable|string',
            'map' => 'nullable|string',
            'grafik_kinerja' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Untuk kolom yang hanya relevan dengan tipe tertentu, set null jika tidak relevan
        if (!in_array($request->tipe, ['cabang_dinas'])) {
            $request->offsetUnset('wilayah_kerja'); // Hapus dari request agar tidak disimpan
        }
        if (!in_array($request->tipe, ['UPTD', 'cabang_dinas'])) {
            $request->offsetUnset('alamat');
            $request->offsetUnset('map');
        }


        $bidang = Bidang::create($request->all());

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang ' . $bidang->nama . ' berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit Bidang yang sudah ada.
     */
    public function edit(Bidang $bidang)
    {
        $pejabats = Pejabat::all();
        return view('admin.bidang.edit', compact('bidang', 'pejabats'));
    }

    /**
     * Perbarui Bidang yang sudah ada di database.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:bidangs,nama,' . $bidang->id,
            'tipe' => 'required|in:bidang,UPTD,cabang_dinas',
            'tupoksi' => 'nullable|string',
            'pejabat_kepala_id' => 'nullable|exists:pejabat,id',
            'wilayah_kerja' => 'nullable|string',
            'alamat' => 'nullable|string',
            'map' => 'nullable|string',
            'grafik_kinerja' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Untuk kolom yang hanya relevan dengan tipe tertentu, set null jika tidak relevan
        if (!in_array($request->tipe, ['cabang_dinas'])) {
            $request->merge(['wilayah_kerja' => null]);
        }
        if (!in_array($request->tipe, ['UPTD', 'cabang_dinas'])) {
            $request->merge(['alamat' => null]);
            $request->merge(['map' => null]);
        }

        $bidang->update($request->all());

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang ' . $bidang->nama . ' berhasil diperbarui.');
    }

    /**
     * Hapus Bidang dari database.
     */
    public function destroy(Bidang $bidang)
    {
        $namaBidang = $bidang->nama;
        $bidang->delete();

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang ' . $namaBidang . ' berhasil dihapus.');
    }
}