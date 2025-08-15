<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource; // <-- Kita akan buat ini
use App\Http\Resources\PostCollection; // <-- Kita akan buat ini

class PostController extends Controller
{
    /**
     * Menampilkan daftar berita.
     */
    public function index()
    {
        $posts = Post::with(['category', 'author'])
                     ->where('status', 'published')
                     ->latest()
                     ->paginate(10);

        return new PostCollection($posts);
    }

    /**
     * Menampilkan satu berita spesifik.
     */
    public function show(Post $post)
    {
        // Pastikan hanya berita yang sudah 'published' yang bisa diakses
        if ($post->status !== 'published') {
            return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
        }

        // Tambahkan logika increment hits
        $post->increment('hits');

        return new PostResource($post->load(['category', 'author']));
    }
}