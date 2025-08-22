<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // <-- Tambahkan fasad Gate
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Otorisasi menggunakan fasad Gate
        Gate::authorize('viewAny', Post::class);

        $categories = Category::ofTypePost()->orderBy('name')->get();
        
        $query = Post::with(['category', 'author', 'media', 'comments']);

        if (Auth::user()->role === 'editor') {
            $query->where('author_id', Auth::id());
        }

        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where('title', 'like', '%' . $search . '%');
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(10);

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        // Otorisasi menggunakan fasad Gate
        Gate::authorize('create', Post::class);

        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Otorisasi menggunakan fasad Gate
        Gate::authorize('create', Post::class);

        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'category_id' => 'required|exists:categories,id',
            'content_html' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'meta_title' => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description ?: Str::limit(strip_tags($request->content_html), 160),
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'category_id' => $request->category_id,
            'author_id' => auth()->id(),
            'status' => $request->status,
        ]);
        
        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.posts.index')->with('success', 'Berita "' . Str::limit($post->title, 50) . '" berhasil ditambahkan!');
    }

    public function edit(Post $post)
    {
        // Otorisasi menggunakan fasad Gate
        Gate::authorize('update', $post);

        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        // Otorisasi menggunakan fasad Gate
        Gate::authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'content_html' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        $post->update([
            'title' => $request->title,
            'meta_title' => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description ?: Str::limit(strip_tags($request->content_html), 160),
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);
        
        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured_image');
            $post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        }

        Cache::forget('post:' . $post->slug);
        return redirect()->route('admin.posts.index')->with('success', 'Berita "' . Str::limit($post->title, 50) . '" berhasil diperbarui!');
    }
    
    public function destroy(Post $post)
    {
        // Otorisasi menggunakan fasad Gate
        Gate::authorize('delete', $post);

        $post->clearMediaCollection('featured_image');
        Cache::forget('post:' . $post->slug);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita "' . Str::limit($post->title, 50) . '" berhasil dihapus!');
    }
}