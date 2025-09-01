<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;

class WelcomeController extends Controller
{
    public function index()
    {
        // ==========================================================
        //                       LOGIKA BERITA
        // ==========================================================

        // 1. Ambil SATU post paling populer (hits tertinggi).
        // Kita tambahkan eager loading di sini untuk efisiensi.
        $popularPost = Post::published()
                           ->with(['category', 'author', 'media']) // Eager Loading
                           ->orderByDesc('hits')
                           ->first();

        // 2. Ambil 3 post terbaru, KECUALI post populer jika ia termasuk di dalamnya.
        $latestPosts = Post::published()
                           ->with(['category', 'author', 'media']) // Eager Loading
                           ->latest() // Mengurutkan berdasarkan created_at (terbaru dulu)
                           ->when($popularPost, function ($query) use ($popularPost) {
                               // Jika ada post populer, pastikan ID-nya dikecualikan
                               return $query->where('id', '!=', $popularPost->id);
                           })
                           ->take(3)
                           ->get();
        
        // 3. Gabungkan hasilnya: post populer selalu di urutan pertama.
        if ($popularPost) {
            $latestPosts->prepend($popularPost);
        }
        $posts = $latestPosts;


        // ==========================================================
        //                       LOGIKA DOKUMEN
        // ==========================================================
        
        // 1. Ambil SATU dokumen paling populer (hits tertinggi).
        $popularDokumen = Dokumen::where('is_active', true)
                                ->with('category') // Eager Loading
                                ->orderByDesc('hits')
                                ->first();

        // 2. Ambil 3 dokumen terbaru, KECUALI dokumen populer.
        $latestDokumen = Dokumen::where('is_active', true)
                               ->with('category') // Eager Loading
                               ->latest()
                               ->when($popularDokumen, function ($query) use ($popularDokumen) {
                                   return $query->where('id', '!=', $popularDokumen->id);
                               })
                               ->take(3)
                               ->get();

        // 3. Gabungkan hasilnya: dokumen populer selalu di urutan pertama.
        if ($popularDokumen) {
            $latestDokumen->prepend($popularDokumen);
        }
        $dokumen = $latestDokumen;


        // ==========================================================
        //                   LOGIKA INFORMASI PUBLIK
        // ==========================================================
        
        // Untuk informasi publik, kita tetap ambil 3 yang terbaru saja (sesuai kode asli).
        $informasiPublik = InformasiPublik::where('is_active', true)
                                         ->with('category') // Eager Loading
                                         ->latest()
                                         ->take(3)
                                         ->get();

        return view('welcome', compact('posts', 'dokumen', 'informasiPublik'));
    }
}