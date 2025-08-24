<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category; // Untuk kategori berita
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::get();
        $query = Post::with(['category', 'author'])->published();
        $title = 'Berita Terbaru';

        // Filter berdasarkan kategori (logika asli Anda)
        if ($request->has('kategori') && $request->kategori != 'all') {
            $category = Category::where('slug', $request->kategori)->first();
            if ($category) {
                $query->where('category_id', $category->id);
                $title = 'Berita Kategori: ' . $category->name;
            }
        }

        // Pencarian (logika asli Anda)
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('content_html', 'like', '%' . $search . '%');
            });
            $title = 'Hasil Pencarian: "' . $search . '"';
        }

        // Ambil data dengan paginasi
        $posts = $query->latest()->paginate(9)->withQueryString(); // <-- PERBAIKAN DI SINI

        // Logika untuk menangani AJAX "Load More"
        if ($request->ajax()) {
            $html = '';
            foreach ($posts as $post) {
                $html .= view('berita.partials.post-card', ['post' => $post])->render();
            }

            return response()->json([
                'html' => $html,
                'next_page_url' => $posts->nextPageUrl(),
            ]);
        }

        // Untuk permintaan biasa, tampilkan view seperti biasa
        return view('berita.index', compact('posts', 'categories', 'title'));
    }

    public function show($slug)
    {
        $cacheKey = 'post:' . $slug;

        // Ambil data post dari cache
        $post = Cache::remember($cacheKey, now()->addHours(24), function () use ($slug) {
            // --- PERBAIKAN: Eager load SEMUA relasi yang dibutuhkan di sini ---
            return Post::with([
                'author', 
                'category', 
                'comments' => function ($query) {
                    // Hanya muat komentar yang sudah disetujui
                    $query->where('status', 'approved')
                        ->where(function ($q) {
                            $q->whereNotNull('email_verified_at')->orWhereNotNull('user_id');
                        })
                        ->whereNull('parent_id') // Hanya komentar utama
                        ->with('user', 'replies.user') // Eager load user dari komentar & balasan
                        ->latest();
                }
            ])->where('slug', $slug)->firstOrFail();
        });

        // Naikkan counter hits
        $post->increment('hits');
        
        // Ambil komentar dari relasi yang sudah di-eager load
        $approvedComments = $post->comments;

        return view('berita.show', compact('post', 'approvedComments'));
    }
        
    public function incrementShareCount(Post $post)
    {
        $post->increment('share_count');
        return response()->json(['success' => true, 'share_count' => $post->share_count]);
    }

}