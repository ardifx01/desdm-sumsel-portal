<?php

namespace App\Http\Controllers;

use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Untuk manipulasi tanggal

class LaporanStatistikController extends Controller
{
    public function index()
    {
        // --- Statistik Permohonan Informasi ---
        $totalPermohonan = PermohonanInformasi::count();
        $permohonanPerStatus = PermohonanInformasi::select('status', \DB::raw('count(*) as total'))
                                                 ->groupBy('status')
                                                 ->get();

        // Statistik permohonan per bulan/tahun (untuk Chart.js)
        $permohonanBulanan = PermohonanInformasi::select(
                                                    \DB::raw('DATE_FORMAT(tanggal_permohonan, "%Y-%m") as month_year'),
                                                    \DB::raw('count(*) as total')
                                                )
                                                ->whereYear('tanggal_permohonan', date('Y')) // Hanya tahun ini
                                                ->groupBy('month_year')
                                                ->orderBy('month_year')
                                                ->get();

        $permohonanLabels = $permohonanBulanan->pluck('month_year')->toArray();
        $permohonanData = $permohonanBulanan->pluck('total')->toArray();

        // --- Statistik Pengajuan Keberatan ---
        $totalKeberatan = PengajuanKeberatan::count();
        $keberatanPerJenis = PengajuanKeberatan::select('jenis_keberatan', \DB::raw('count(*) as total'))
                                              ->groupBy('jenis_keberatan')
                                              ->get();

        // Statistik keberatan per bulan/tahun (untuk Chart.js)
        $keberatanBulanan = PengajuanKeberatan::select(
                                                \DB::raw('DATE_FORMAT(tanggal_pengajuan, "%Y-%m") as month_year'),
                                                \DB::raw('count(*) as total')
                                            )
                                            ->whereYear('tanggal_pengajuan', date('Y')) // Hanya tahun ini
                                            ->groupBy('month_year')
                                            ->orderBy('month_year')
                                            ->get();

        $keberatanLabels = $keberatanBulanan->pluck('month_year')->toArray();
        $keberatanData = $keberatanBulanan->pluck('total')->toArray();

        // --- Daftar Laporan Tahunan PPID (contoh statis/dari Informasi Publik) ---
        // Asumsi laporan tahunan PPID disimpan sebagai Informasi Berkala
        // Anda bisa filter berdasarkan judul/kategori spesifik
        $laporanTahunanPPID = \App\Models\InformasiPublik::where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('slug', 'informasi-berkala'); // Ambil dari kategori Informasi Berkala
            })
            ->where('judul', 'like', '%Laporan Akses Informasi Publik%') // Filter judul jika perlu
            ->orderBy('tanggal_publikasi', 'desc')
            ->limit(5) // Tampilkan 5 laporan terbaru
            ->get();


        return view('informasi-publik.laporan-statistik', compact(
            'totalPermohonan',
            'permohonanPerStatus',
            'permohonanLabels',
            'permohonanData',
            'totalKeberatan',
            'keberatanPerJenis',
            'keberatanLabels',
            'keberatanData',
            'laporanTahunanPPID'
        ));
    }
}