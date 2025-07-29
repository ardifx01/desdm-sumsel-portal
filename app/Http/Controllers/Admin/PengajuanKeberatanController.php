<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\PengajuanKeberatan; // Import model PengajuanKeberatan Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Facades\Log; // Untuk logging
use Illuminate\Support\Facades\Storage; // Untuk file identitas

class PengajuanKeberatanController extends Controller // Nama kelas adalah PengajuanKeberatanController
{
    // Daftar status yang mungkin untuk keberatan
    private $statuses = ['Menunggu Diproses', 'Diproses', 'Diterima', 'Ditolak', 'Selesai'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = $this->statuses; // Kirim daftar status ke view

        $query = PengajuanKeberatan::orderBy('tanggal_pengajuan', 'desc');

        // Implementasi Filter dan Pencarian
        if ($request->filled('q')) { // Pencarian nama pemohon atau nomor registrasi permohonan
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', '%' . $search . '%')
                  ->orWhere('nomor_registrasi_permohonan', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('status')) { // Filter status keberatan
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_keberatan')) { // Filter jenis keberatan
            $query->where('jenis_keberatan', $request->jenis_keberatan);
        }
        if ($request->filled('start_date')) { // Filter tanggal mulai
            $query->whereDate('tanggal_pengajuan', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) { // Filter tanggal akhir
            $query->whereDate('tanggal_pengajuan', '<=', $request->end_date);
        }

        $keberatan = $query->paginate(10);

        return view('admin.keberatan.index', compact('keberatan', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id) // <-- Menerima $id
    {
        // Ambil data keberatan secara eksplisit menggunakan ID
        $pengajuan_keberatan = PengajuanKeberatan::findOrFail($id); // <-- Menggunakan findOrFail

        $statuses = $this->statuses;
        return view('admin.keberatan.show', compact('pengajuan_keberatan', 'statuses'));
    }

    /**
     * Update the specified resource in storage. (Hanya untuk update status & catatan admin)
     */
    public function update(Request $request, $id) // <-- UBAH PARAMETER INI MENJADI $id
    {
        // Ambil instance model secara eksplisit di sini
        $pengajuan_keberatan = PengajuanKeberatan::findOrFail($id); // <-- Tambahkan ini

        // Hapus dd() setelah debugging
        // dd($request->method(), $pengajuan_keberatan);

        $request->validate([
            'status' => 'required|in:' . implode(',', $this->statuses),
            'catatan_admin' => 'nullable|string',
        ]);

        $pengajuan_keberatan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.keberatan.show', ['keberatan_item' => $pengajuan_keberatan->id])->with('success', 'Status pengajuan keberatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) // <-- UBAH PARAMETER INI MENJADI $id
    {
        // Ambil instance model secara eksplisit di sini
        $pengajuan_keberatan = PengajuanKeberatan::findOrFail($id); // <-- Tambahkan ini

        try {
            // Hapus file identitas jika ada
            if ($pengajuan_keberatan->identitas_pemohon && Storage::disk('public')->exists($pengajuan_keberatan->identitas_pemohon)) {
                Storage::disk('public')->delete($pengajuan_keberatan->identitas_pemohon);
            }

            $deleteResult = $pengajuan_keberatan->delete();

            if ($deleteResult) {
                Log::info('Pengajuan keberatan berhasil dihapus: ' . $pengajuan_keberatan->nomor_registrasi_permohonan);
                return redirect()->route('admin.keberatan.index')->with('success', 'Pengajuan keberatan berhasil dihapus!');
            } else {
                Log::error('Pengajuan keberatan GAGAL dihapus (delete() mengembalikan false): ' . $pengajuan_keberatan->nomor_registrasi_permohonan);
                return redirect()->route('admin.keberatan.index')->with('error', 'Gagal menghapus pengajuan keberatan.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus pengajuan keberatan (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.keberatan.index')->with('error', 'Gagal menghapus pengajuan keberatan: ' . $e->getMessage());
        }
    }
}