<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublik;
use App\Models\InformasiPublikCategory;
use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use App\Models\DokumenCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class InformasiPublikController extends Controller
{
public function index(Request $request)
{
    // Mengambil kategori tetap diperlukan untuk dropdown filter di view.
    // Ini bisa di-cache untuk performa lebih baik jika kategori jarang berubah.
    $categories = Cache::remember('informasi_publik_categories', 60*60, function () {
        return InformasiPublikCategory::orderBy('nama')->get();
    });

    $search = $request->q;

    // Mulai query. Kita akan gunakan Scout jika ada input pencarian.
    if ($search) {
        // PENCARIAN MENGGUNAKAN LARAVEL SCOUT
        $query = InformasiPublik::search($search)
                                ->where('is_active', true); // Scope untuk data yang aktif saja
    } else {
        // QUERY ELOQUENT STANDAR (JIKA TIDAK ADA PENCARIAN)
        $query = InformasiPublik::query()
                                ->where('is_active', true)
                                ->orderBy('tanggal_publikasi', 'desc');
    }

    // Terapkan filter kategori. Bekerja untuk Scout dan Eloquent biasa.
    // OPTIMASI: Menggunakan whereHas untuk menghindari query tambahan.
    if ($request->filled('kategori') && $request->kategori != 'all') {
        $slug = $request->kategori;
        $query->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    // Eager load relasi hanya jika ini adalah query Eloquent.
    // Scout menangani relasi secara berbeda, biasanya relasi sudah dimuat jika di-index.
    // Namun untuk konsistensi, kita muat setelah paginasi nanti.
    if (!$search) {
        $query->with('category');
    }

    // Eksekusi query dengan paginasi
    $informasiPublik = $query->paginate(10)->withQueryString();

    return view('informasi-publik.index', compact('informasiPublik', 'categories'));
}

    public function show($slug)
    {
        // Tampilkan detail informasi publik berdasarkan slug
        $informasi = InformasiPublik::where('slug', $slug)
                                    ->where('is_active', true)
                                    ->firstOrFail(); // Temukan, jika tidak 404

        // Tambahkan hit count (opsional)
        $informasi->increment('hits');

        return view('informasi-publik.show', compact('informasi'));
    }

    // Metode untuk menampilkan informasi berdasarkan kategori langsung (opsional, bisa dihandle di index)
    public function showByCategory($categorySlug)
    {
        $category = InformasiPublikCategory::where('slug', $categorySlug)->firstOrFail();

        $informasiPublik = InformasiPublik::where('category_id', $category->id)
                                        ->where('is_active', true)
                                        ->orderBy('tanggal_publikasi', 'desc')
                                        ->paginate(10);

        return view('informasi-publik.index', compact('informasiPublik', 'category')); // Bisa juga buat view terpisah
    }

    // --- Metode Laporan Statistik yang Diperbarui ---
    public function laporanStatistik()
    {
        // Data metrik utama
        $totalPermohonan = PermohonanInformasi::count();
        $permohonanStatus = PermohonanInformasi::selectRaw('status, count(*) as count')
                                             ->groupBy('status')
                                             ->pluck('count', 'status');

        $totalKeberatan = PengajuanKeberatan::count();
        $keberatanStatus = PengajuanKeberatan::selectRaw('status, count(*) as count')
                                           ->groupBy('status')
                                           ->pluck('count', 'status');
        
        $totalInformasiPublik = InformasiPublik::count();
        $informasiPublikPerKategori = InformasiPublikCategory::withCount('informasiPublik')->get();

        // Ambil 10 permohonan dan keberatan terakhir
        $recentPermohonan = PermohonanInformasi::latest()->take(10)->get();
        $recentKeberatan = PengajuanKeberatan::latest()->take(10)->get();

        // Data untuk Chart.js
        $currentYear = now()->year;
        $permohonanPerBulan = PermohonanInformasi::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        $keberatanPerBulan = PengajuanKeberatan::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');
        
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create(null, $month, 1)->translatedFormat('F');
        });

        $permohonanLabels = $months->values();
        $permohonanData = $permohonanLabels->map(function ($label, $key) use ($permohonanPerBulan) {
            return $permohonanPerBulan[$key + 1] ?? 0;
        });

        $keberatanLabels = $months->values();
        $keberatanData = $keberatanLabels->map(function ($label, $key) use ($keberatanPerBulan) {
            return $keberatanPerBulan[$key + 1] ?? 0;
        });
        
        // --- Logika untuk Laporan Tahunan yang Diperbarui ---
        $laporanTahunanPPID = DokumenCategory::where('nama', 'Laporan Tahunan')
                                           ->first()
                                           ->dokumen ?? collect();
        
        return view('informasi-publik.laporan-statistik', compact(
            'totalPermohonan', 'permohonanStatus', 'totalKeberatan', 'keberatanStatus',
            'totalInformasiPublik', 'informasiPublikPerKategori',
            'recentPermohonan', 'recentKeberatan',
            'permohonanLabels', 'permohonanData', 'keberatanLabels', 'keberatanData',
            'laporanTahunanPPID'
        ));
    }
}