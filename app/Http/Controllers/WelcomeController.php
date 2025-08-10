<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil berita, urutkan berdasarkan hits tertinggi, lalu tanggal terbaru
        $posts = Post::published()
            ->orderByDesc('hits')
            ->orderByDesc('created_at')
            ->take(4) // Ambil 4 post untuk menampilkan 1 populer dan 3 lainnya
            ->get();
        
        // Ambil dokumen, urutkan berdasarkan hits tertinggi, lalu tanggal terbaru
        $dokumen = Dokumen::orderByDesc('hits')
            ->orderByDesc('created_at')
            ->take(4) // Ambil 4 dokumen
            ->get();

        $informasiPublik = InformasiPublik::latest()->take(3)->get();

        return view('welcome', compact('posts', 'dokumen', 'informasiPublik'));
    }
}