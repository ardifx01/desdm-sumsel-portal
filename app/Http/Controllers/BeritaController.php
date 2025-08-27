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
        $categories = Cache::remember('berita_categories_list', 60*60, function () {
            return Category::orderBy('name')->get();
        });

        $search = $request->q;
        $title = 'Berita Terbaru';

        if ($search) {
            // --- PERBAIKAN LOGIKA PENCARIAN SCOUT ---
            $query = Post::search($search)->where('status', 'published');
            $title = 'Hasil Pencarian: "' . $search . '"';

            if ($request->filled('kategori') && $request->kategori != 'all') {
                // Catatan: filter kategori pada Scout bisa jadi lebih kompleks
                // Untuk sekarang kita biarkan seperti ini, tapi idealnya ini menggunakan where clause di Scout
            }
            
            $posts = $query->paginate(9)->withQueryString();
            // Setelah mendapatkan hasil, baru kita EAGER LOAD relasinya
            $posts->load(['category', 'author', 'media']);

        } else {
            // --- LOGIKA ELOQUENT BIASA (TETAP SAMA) ---
            $query = Post::query()->published()->with(['category', 'author', 'media']);

            if ($request->filled('kategori') && $request->kategori != 'all') {
                $slug = $request->kategori;
                $query->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
                $currentCategory = $categories->firstWhere('slug', $slug);
                if ($currentCategory) {
                    $title = 'Berita Kategori: ' . $currentCategory->name;
                }
            }
            $posts = $query->latest()->paginate(9)->withQueryString();
        }

        if ($request->ajax()) {
            $html = '';
            foreach ($posts as $post) {
                $html .= view('berita.partials.post-card', ['post' => $post])->render();
            }
            return response()->json(['html' => $html, 'next_page_url' => $posts->nextPageUrl()]);
        }

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