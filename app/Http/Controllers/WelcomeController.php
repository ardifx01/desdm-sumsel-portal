<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil 3 berita terbaru yang sudah dipublikasi
        $posts = Post::where('status', 'published')
                     ->orderBy('created_at', 'desc')
                     ->take(3)
                     ->get();

        // Ambil 3 dokumen terbaru yang aktif
        $dokumen = Dokumen::where('is_active', true)
                         ->orderBy('created_at', 'desc')
                         ->take(3)
                         ->get();

        // Kirim data ke view dengan nama variabel yang sesuai
        return view('welcome', compact('posts', 'dokumen'));
    }
}