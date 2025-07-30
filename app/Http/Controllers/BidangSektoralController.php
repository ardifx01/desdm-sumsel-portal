<?php

namespace App\Http\Controllers;

use App\Models\Bidang; // Import Model Bidang yang baru kita buat
use App\Models\Seksi;  // Import Model Seksi (jika diperlukan untuk relasi, tapi sudah di-load via Bidang)
use App\Models\Pejabat; // Import Model Pejabat (jika diperlukan untuk relasi)
use Illuminate\Http\Request;

class BidangSektoralController extends Controller
{
    /**
     * Tampilkan daftar Bidang, UPTD, dan Cabang Dinas yang aktif.
     */
    public function index()
    {
        // Ambil semua bidang yang aktif, diurutkan berdasarkan nama
        $bidangs = Bidang::where('is_active', true)
                         ->orderBy('id')
                         ->get();
        
        // Render view daftar bidang (akan kita modifikasi selanjutnya)
        return view('bidang-sektoral.index', compact('bidangs'));
    }

    /**
     * Tampilkan halaman detail untuk Bidang, UPTD, atau Cabang Dinas tertentu.
     * Menggunakan route model binding dengan slug.
     */
    public function show($slug) // Parameter diubah menjadi $slug
    {
        // Cari bidang berdasarkan slug. Jika tidak ditemukan, akan otomatis 404.
        $bidang = Bidang::where('slug', $slug)
                        ->where('is_active', true) // Hanya tampilkan yang aktif
                        ->with(['seksis' => function($query) {
                            $query->where('is_active', true)->orderBy('urutan')->orderBy('nama_seksi');
                        }, 'seksis.kepala', 'kepala']) // Load relasi seksi dan pejabat terkait
                        ->firstOrFail(); // Akan melempar 404 jika tidak ditemukan

        // Kita akan menggunakan satu view dinamis untuk menampilkan semua tipe (bidang, UPTD, cabang dinas)
        // View ini akan mengambil alih fungsi dari sekretariat.blade.php dan sejenisnya
        return view('bidang-sektoral.show', compact('bidang'));
    }

    /**
     * Tampilkan halaman data statistik (jika ada, biarkan saja jika tidak ada perubahan).
     * Anda bisa mengadaptasi ini jika data statistik juga akan dinamis.
     */
    public function showDataStatistik()
    {
        // Logika untuk menampilkan data statistik
        return view('bidang-sektoral.data-statistik'); // Sesuaikan nama view jika berbeda
    }
}