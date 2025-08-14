<?php

namespace App\Http\Controllers;

use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// Tidak perlu 'use' untuk helper 'activity()', ia tersedia secara global.

class LayananInformasiController extends Controller
{
    // --- Permohonan Informasi ---

    public function showProsedurPermohonan()
    {
        return view('informasi-publik.prosedur-permohonan');
    }

    public function showFormPermohonan()
    {
        return view('informasi-publik.form-permohonan');
    }

    public function storePermohonan(Request $request)
    {
        $request->validate([
            'pekerjaan_pemohon' => 'nullable|string|max:255',
            'identitas_pemohon' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jenis_pemohon' => 'required|string|in:Perorangan,Badan Hukum,Kelompok Masyarakat',
            'tujuan_penggunaan_informasi' => 'nullable|string',
            'rincian_informasi' => 'required|string',
            'cara_mendapatkan_informasi' => 'required|string|in:Melihat,Membaca,Mendengar,Mendapatkan Salinan Softcopy,Mendapatkan Salinan Hardcopy',
            'cara_mendapatkan_salinan' => 'nullable|string|in:Mengambil Langsung,Pos,Email,Fax',
        ]);

        $identitasPath = null;
        if ($request->hasFile('identitas_pemohon')) {
            $identitasPath = $request->file('identitas_pemohon')->store('identitas_pemohon', 'public');
        }

        $permohonan = PermohonanInformasi::create([
            'user_id' => Auth::id(), // Selalu dari pengguna yang login
            'jenis_pemohon' => $request->jenis_pemohon,
            'pekerjaan_pemohon' => $request->pekerjaan_pemohon,
            'identitas_pemohon' => $identitasPath,
            'rincian_informasi' => $request->rincian_informasi,
            'tujuan_penggunaan_informasi' => $request->tujuan_penggunaan_informasi,
            'cara_mendapatkan_informasi' => $request->cara_mendapatkan_informasi,
            'cara_mendapatkan_salinan' => $request->cara_mendapatkan_salinan,
            'tanggal_permohonan' => now(),
            'status' => 'Menunggu Diproses',
        ]);

        // --- LOG KUSTOM DI SINI ---
        activity()
            ->causedBy(Auth::user())
            ->performedOn($permohonan)
            ->log('Mengajukan permohonan informasi baru');

        return redirect()->route('informasi-publik.permohonan.sukses')->with('nomor_registrasi', $permohonan->nomor_registrasi);
    }

    public function showPermohonanSukses()
    {
        return view('informasi-publik.permohonan-sukses');
    }

    // --- Pengajuan Keberatan ---

    public function showProsedurKeberatan()
    {
        return view('informasi-publik.prosedur-keberatan');
    }

    public function showFormKeberatan()
    {
        return view('informasi-publik.form-keberatan');
    }

    public function storeKeberatan(Request $request)
    {
        $request->validate([
            'nomor_registrasi_permohonan' => 'required|string|max:255|exists:permohonan_informasi,nomor_registrasi',
            'alasan_keberatan' => 'required|string',
            'jenis_keberatan' => 'required|string|in:Info Ditolak,Info Tidak Disediakan,Info Tidak Ditanggapi,Info Tidak Sesuai,Biaya Tidak Wajar,Info Terlambat',
            'kasus_posisi' => 'nullable|string',
        ]);

        $keberatan = PengajuanKeberatan::create([
            'user_id' => Auth::id(), // Selalu dari pengguna yang login
            'nomor_registrasi_permohonan' => $request->nomor_registrasi_permohonan,
            'alasan_keberatan' => $request->alasan_keberatan,
            'jenis_keberatan' => $request->jenis_keberatan,
            'kasus_posisi' => $request->kasus_posisi,
            'tanggal_pengajuan' => now(),
            'status' => 'Menunggu Diproses',
        ]);

        // --- LOG KUSTOM DI SINI ---
        activity()
            ->causedBy(Auth::user())
            ->performedOn($keberatan)
            ->log('Mengajukan keberatan informasi'); // Deskripsi diubah sedikit agar lebih spesifik

        return redirect()->route('informasi-publik.keberatan.sukses');
    }

    public function showKeberatanSukses()
    {
        return view('informasi-publik.keberatan-sukses');
    }
}