<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category; // Untuk kategori berita
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::ofTypePost()->get(); // Ambil hanya kategori bertipe 'post'

        $query = Post::with(['category', 'author'])->published(); // Hanya post yang published
        $title = 'Berita Terbaru';

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != 'all') {
            $category = Category::ofTypePost()->where('slug', $request->kategori)->first();
            if ($category) {
                $query->where('category_id', $category->id);
                $title = 'Berita Kategori: ' . $category->name;
            }
        }

        // Pencarian
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('content_html', 'like', '%' . $search . '%');
            });
            $title = 'Hasil Pencarian: "' . $search . '"';
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('berita.index', compact('posts', 'categories', 'title'));
    }

    public function show($slug)
        {
            // Ambil post beserta relasi kategori dan author
            $post = Post::with(['author', 'category'])->where('slug', $slug)->firstOrFail();
            // Naikkan counter hits
            $post->increment('hits');
            // Ambil HANYA komentar utama yang sudah disetujui
            // Gunakan with('replies.user') untuk mengambil balasan secara rekursif
            $approvedComments = $post->comments()
                ->where('status', 'approved')
                ->where(function ($query) {
                    $query->whereNotNull('email_verified_at')
                        ->orWhereNotNull('user_id');
                })
                ->whereNull('parent_id') // Hanya ambil komentar utama
                ->with('replies.user') // Eager load balasan
                ->latest()
                ->get();

            return view('berita.show', compact('post', 'approvedComments'));
        }
        
    public function incrementShareCount(Post $post)
    {
        $post->increment('share_count');
        return response()->json(['success' => true, 'share_count' => $post->share_count]);
    }

}