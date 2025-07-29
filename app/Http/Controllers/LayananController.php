<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanInformasi; // Sudah sesuai dengan nama file Model Anda
use App\Models\PengajuanKeberatan;   // Sudah sesuai dengan nama file Model Anda
use Carbon\Carbon; // Tambahkan ini untuk memformat tanggal di view jika belum ada

class LayananController extends Controller
{
    /**
     * Menampilkan form untuk cek status layanan/pengaduan.
     * @return \Illuminate\View\View
     */
    public function showCekStatusForm()
    {
        // Variabel ini akan dikirim ke view saat pertama kali dimuat (tanpa hasil pencarian)
        return view('public.layanan-pengaduan.cek-status', [
            'nomorRegistrasi' => '', // Kosongkan input saat pertama kali dibuka
            'result' => null,        // Tidak ada hasil untuk ditampilkan
        ]);
    }

    /**
     * Memproses permintaan cek status berdasarkan nomor registrasi.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function processCekStatus(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nomor_registrasi' => 'required|string|max:255',
        ], [
            'nomor_registrasi.required' => 'Nomor Registrasi wajib diisi.',
            'nomor_registrasi.string' => 'Nomor Registrasi harus berupa teks.',
            'nomor_registrasi.max' => 'Nomor Registrasi tidak boleh lebih dari :max karakter.',
        ]);

        $nomorRegistrasi = $request->input('nomor_registrasi');
        $result = null; // Untuk menyimpan hasil pencarian

        // 2. Cari di tabel permohonan_informasi menggunakan kolom 'nomor_registrasi'
        $permohonan = PermohonanInformasi::where('nomor_registrasi', $nomorRegistrasi)->first();

        if ($permohonan) {
            $result = [
                'type' => 'Permohonan Informasi',
                'data' => $permohonan,
            ];
        } else {
            // 3. Jika tidak ditemukan, cari di tabel pengajuan_keberatan menggunakan kolom 'nomor_registrasi_permohonan'
            $keberatan = PengajuanKeberatan::where('nomor_registrasi_permohonan', $nomorRegistrasi)->first();
            if ($keberatan) {
                $result = [
                    'type' => 'Pengajuan Keberatan',
                    'data' => $keberatan,
                ];
            }
        }

        // 4. Kirim hasil ke view
        return view('public.layanan-pengaduan.cek-status', [
            'nomorRegistrasi' => $nomorRegistrasi, // Kirim kembali nomor yang dicari
            'result' => $result,                   // Kirim hasil pencarian
        ]);
    }
}