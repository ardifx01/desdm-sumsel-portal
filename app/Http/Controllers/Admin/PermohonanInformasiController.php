<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\PermohonanInformasi; // Import model PermohonanInformasi Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Facades\Log; // Untuk logging
use Illuminate\Support\Facades\Storage; // Untuk file identitas

class PermohonanInformasiController extends Controller // Nama kelas adalah PermohonanInformasiController
{
    // Daftar status yang mungkin untuk permohonan
    private $statuses = ['Menunggu Diproses', 'Diproses', 'Diterima', 'Ditolak', 'Selesai'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = $this->statuses; // Kirim daftar status ke view

        $query = PermohonanInformasi::orderBy('tanggal_permohonan', 'desc');

        // Implementasi Filter dan Pencarian
        if ($request->filled('q')) { // Pencarian nama pemohon atau nomor registrasi
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', '%' . $search . '%')
                  ->orWhere('nomor_registrasi', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('status')) { // Filter status permohonan
            $query->where('status', $request->status);
        }
        if ($request->filled('start_date')) { // Filter tanggal mulai
            $query->whereDate('tanggal_permohonan', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) { // Filter tanggal akhir
            $query->whereDate('tanggal_permohonan', '<=', $request->end_date);
        }

        $permohonan = $query->paginate(10);

        return view('admin.permohonan.index', compact('permohonan', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id) // <-- Menerima $id
    {
        // Ambil data permohonan secara eksplisit menggunakan ID
        $permohonan_informasi = PermohonanInformasi::findOrFail($id); // <-- Menggunakan findOrFail

        $statuses = $this->statuses; // Kirim daftar status ke view
        return view('admin.permohonan.show', compact('permohonan_informasi', 'statuses'));
    }

    /**
     * Update the specified resource in storage. (Hanya untuk update status & catatan admin)
     */
    public function update(Request $request, $id) // <-- UBAH PARAMETER INI MENJADI $id
    {
        // Ambil instance model secara eksplisit di sini
        $permohonan_informasi = PermohonanInformasi::findOrFail($id); // <-- Tambahkan ini

        // Hapus dd() setelah debugging
        // dd($request->method(), $permohonan_informasi);

        $request->validate([
            'status' => 'required|in:' . implode(',', $this->statuses),
            'catatan_admin' => 'nullable|string',
        ]);

        $permohonan_informasi->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.permohonan.show', ['permohonan_item' => $permohonan_informasi->id])->with('success', 'Status permohonan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) // <-- UBAH PARAMETER INI MENJADI $id
    {
        // Ambil instance model secara eksplisit di sini
        $permohonan_informasi = PermohonanInformasi::findOrFail($id); // <-- Tambahkan ini

        Log::info('Memulai proses hapus permohonan informasi: ' . $permohonan_informasi->nomor_registrasi . ' (ID: ' . $permohonan_informasi->id . ')');

        try {
            // Hapus file identitas jika ada
            if ($permohonan_informasi->identitas_pemohon && Storage::disk('public')->exists($permohonan_informasi->identitas_pemohon)) {
                Storage::disk('public')->delete($permohonan_informasi->identitas_pemohon);
            }

            $deleteResult = $permohonan_informasi->delete();

            if ($deleteResult) {
                Log::info('Permohonan informasi berhasil dihapus: ' . $permohonan_informasi->nomor_registrasi);
                return redirect()->route('admin.permohonan.index')->with('success', 'Permohonan berhasil dihapus!');
            } else {
                Log::error('Permohonan informasi GAGAL dihapus (delete() mengembalikan false): ' . $permohonan_informasi->nomor_registrasi);
                return redirect()->route('admin.permohonan.index')->with('error', 'Gagal menghapus permohonan.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus permohonan (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.permohonan.index')->with('error', 'Gagal menghapus permohonan: ' . $e->getMessage());
        }
    }
}