<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanInformasi; // Import Model PermohonanInformasi
use App\Models\PengajuanKeberatan;   // Import Model PengajuanKeberatan
use Carbon\Carbon; // Untuk memformat tanggal di view

class LayananPengaduanController extends Controller
{
    // --- Metode-metode Anda yang sudah ada ---
    // Contoh:
    public function index()
    {
        return view('layanan-pengaduan.index');
    }

    public function showPengaduan()
    {
        return view('layanan-pengaduan.pengaduan');
    }

    public function showFaqUmum()
    {
        return view('layanan-pengaduan.faq-umum');
    }

    public function showDaftarLayanan()
    {
        return view('layanan-pengaduan.daftar-layanan');
    }
    // --- Akhir metode-metode Anda yang sudah ada ---


    /**
     * Menampilkan form untuk cek status layanan/pengaduan.
     * Metode ini akan menangani tampilan awal (GET) dan juga setelah validasi (jika ada error).
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showCekStatus(Request $request)
    {
        $nomorRegistrasi = '';
        $result = null; // Ini akan tetap null saat pertama kali form diakses

        if ($request->old('nomor_registrasi')) {
            $nomorRegistrasi = $request->old('nomor_registrasi');
        }

        return view('layanan-pengaduan.cek-status', [
            'nomorRegistrasi' => $nomorRegistrasi,
            'permohonan' => null, // Inisialisasi null
            'keberatan' => null,   // Inisialisasi null
            'found' => false,      // Flag untuk menunjukkan apakah ada data ditemukan
        ]);
    }

    public function processCekStatus(Request $request)
    {
        $request->validate([
            'nomor_registrasi' => 'required|string|max:255',
        ], [
            'nomor_registrasi.required' => 'Nomor Registrasi wajib diisi.',
            'nomor_registrasi.string' => 'Nomor Registrasi harus berupa teks.',
            'nomor_registrasi.max' => 'Nomor Registrasi tidak boleh lebih dari :max karakter.',
        ]);

        $nomorRegistrasi = $request->input('nomor_registrasi');

        // Cari Permohonan Informasi
        $permohonan = PermohonanInformasi::where('nomor_registrasi', $nomorRegistrasi)->first();

        // Cari semua Pengajuan Keberatan yang terkait (bisa lebih dari satu)
        $keberatan = PengajuanKeberatan::where('nomor_registrasi_permohonan', $nomorRegistrasi)->get();

        $found = false;
        if ($permohonan || $keberatan->isNotEmpty()) {
            $found = true;
        }

        return view('layanan-pengaduan.cek-status', [
            'nomorRegistrasi' => $nomorRegistrasi,
            'permohonan' => $permohonan, // Kirim objek permohonan (bisa null)
            'keberatan' => $keberatan,   // Kirim koleksi keberatan (bisa kosong)
            'found' => $found,           // Kirim status ditemukan
        ]);
    }
}