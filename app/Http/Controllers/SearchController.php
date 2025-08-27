<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;
use App\Models\Bidang;
use App\Models\Seksi;
use App\Models\Pejabat;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => 'nullable|string|min:3']);
        $query = $request->input('q');
        
        $results = collect();

        if ($query) {
            // Kita akan melewati Scout dan menggunakan FULLTEXT index secara manual
            // untuk mendapatkan ID hasil pencarian yang relevan.

            $postIds = Post::query()
                ->whereRaw("MATCH(title, excerpt, content_html) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->where('status', 'published')
                ->pluck('id');
            $posts = Post::whereIn('id', $postIds)->with('category')->get();

            $dokumenIds = Dokumen::query()
                ->whereRaw("MATCH(judul, deskripsi) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->where('is_active', true)
                ->pluck('id');
            $dokumen = Dokumen::whereIn('id', $dokumenIds)->with('category')->get();

            $informasiPublikIds = InformasiPublik::query()
                ->whereRaw("MATCH(judul, konten) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->where('is_active', true)
                ->pluck('id');
            $informasiPublik = InformasiPublik::whereIn('id', $informasiPublikIds)->with('category')->get();

            $bidangIds = Bidang::query()
                ->whereRaw("MATCH(nama, tupoksi) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->where('is_active', true)
                ->pluck('id');
            $bidangs = Bidang::whereIn('id', $bidangIds)->get();

            $seksiIds = Seksi::query()
                ->whereRaw("MATCH(nama_seksi, tugas) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->where('is_active', true)
                ->pluck('id');
            $seksis = Seksi::whereIn('id', $seksiIds)->with('bidang')->get();

            $pejabatIds = Pejabat::query()
                ->whereRaw("MATCH(nama, jabatan) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->where('is_active', true)
                ->pluck('id');
            $pejabats = Pejabat::whereIn('id', $pejabatIds)->get();

            // Menggabungkan semua hasil
            $results->push(['label' => 'Berita', 'items' => $posts]);
            $results->push(['label' => 'Publikasi & Dokumen', 'items' => $dokumen]);
            $results->push(['label' => 'Informasi Publik', 'items' => $informasiPublik]);
            $results->push(['label' => 'Bidang Sektoral', 'items' => $bidangs]);
            $results->push(['label' => 'Seksi Bidang', 'items' => $seksis]);
            $results->push(['label' => 'Pejabat Dinas', 'items' => $pejabats]);
        }

        return view('search.index', compact('query', 'results'));
    }
}