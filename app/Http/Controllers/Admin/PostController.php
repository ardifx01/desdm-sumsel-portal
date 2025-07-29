<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Log ini bisa dihapus setelah debugging selesai
        Log::info('Halaman manajemen berita diakses.');
        Log::warning('Testing warning log entry.');

        $categories = Category::ofTypePost()->orderBy('name')->get();

        $query = Post::with('category', 'author');

        // Implementasi Filter dan Pencarian
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('content_html', 'like', '%' . $search . '%');
            });
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content_html' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB, hanya gambar
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            // Path relatif dari storage/app/public/
            // Hapus 'public/' di awal path untuk menghindari duplikasi folder
            $folderRelativePath = 'images/posts/' . date('Y') . '/' . date('m');
            $imagePath = $request->file('featured_image')->store($folderRelativePath, 'public');
            // $imagePath sekarang akan berisi "images/posts/YYYY/MM/namafileunik.ext"
        }

        // Logika otomatisasi meta_title dan meta_description
        $metaTitle = $request->meta_title ?: $request->title;
        $metaDescription = $request->meta_description ?: Str::limit(strip_tags($request->excerpt ?: $request->content_html), 160);

        Post::create([
            'title' => $request->title,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'featured_image_url' => $imagePath, // Path gambar
            'category_id' => $request->category_id,
            'author_id' => auth()->id(),
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content_html' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $imagePath = $post->featured_image_url; // Default ke gambar lama
        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($post->featured_image_url && Storage::disk('public')->exists($post->featured_image_url)) {
                Storage::disk('public')->delete($post->featured_image_url);
            }
            // Path relatif dari storage/app/public/
            // Hapus 'public/' di awal path untuk menghindari duplikasi folder
            $folderRelativePath = 'images/posts/' . date('Y') . '/' . date('m');
            $imagePath = $request->file('featured_image')->store($folderRelativePath, 'public');
        }

        // Logika otomatisasi meta_title
        $metaTitle = $request->meta_title ?: $request->title;
        $metaDescription = $request->meta_description ?: Str::limit(strip_tags($request->excerpt ?: $request->content_html), 160);

        $post->update([
            'title' => $request->title,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'featured_image_url' => $imagePath,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar terkait jika ada
        if ($post->featured_image_url && Storage::disk('public')->exists($post->featured_image_url)) {
            Storage::disk('public')->delete($post->featured_image_url);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus!');
    }

    // Helper function for PHP upload error messages (can be removed if no specific need)
    // private function getPhpUploadErrorMessage($errorCode) {
    //     switch ($errorCode) {
    //         case UPLOAD_ERR_INI_SIZE: return "Ukuran file melebihi batas upload_max_filesize di php.ini.";
    //         case UPLOAD_ERR_FORM_SIZE: return "Ukuran file melebihi batas MAX_FILE_SIZE di formulir HTML.";
    //         case UPLOAD_ERR_PARTIAL: return "File hanya terupload sebagian.";
    //         case UPLOAD_ERR_NO_FILE: return "Tidak ada file yang terupload.";
    //         case UPLOAD_ERR_NO_TMP_DIR: return "Folder sementara tidak ditemukan.";
    //         case UPLOAD_ERR_CANT_WRITE: return "Gagal menulis file ke disk.";
    //         case UPLOAD_ERR_EXTENSION: return "Upload dihentikan oleh ekstensi PHP.";
    //         default: return "Kesalahan upload tidak diketahui.";
    //     }
    // }
}