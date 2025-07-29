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

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('berita.index', compact('posts', 'categories', 'title'));
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'author'])->published()->where('slug', $slug)->firstOrFail();
        return view('berita.show', compact('post'));
    }
}