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
    public function index(Request $request)
    {
        //Log::info('Halaman manajemen berita diakses.');
        //Log::warning('Testing warning log entry.');

        $categories = Category::ofTypePost()->orderBy('name')->get();
        $query = Post::with('category', 'author');

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

    public function create()
    {
        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
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

        $metaTitle = $request->meta_title ?: $request->title;
        $metaDescription = $request->meta_description ?: Str::limit(strip_tags($request->excerpt ?: $request->content_html), 160);

        $post = Post::create([
            'title' => $request->title,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'category_id' => $request->category_id,
            'author_id' => auth()->id(),
            'status' => $request->status,
        ]);
        
        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image'); // Ini yang benar
        }

        return redirect()->route('admin.posts.index')->with('success', 'Berita "' . $post->title . '" berhasil ditambahkan!');
    }

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

        $metaTitle = $request->meta_title ?: $request->title;
        $metaDescription = $request->meta_description ?: Str::limit(strip_tags($request->excerpt ?: $request->content_html), 160);

        $post->update([
            'title' => $request->title,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);
        
        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured_image');

            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image'); // Ini yang benar
        }

        return redirect()->route('admin.posts.index')->with('success', 'Berita "' . $post->title . '" berhasil diperbarui!');
    }
    
    public function destroy(Post $post)
    {
        $post->clearMediaCollection('featured_image');

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita "' . $post->title . '" berhasil dihapus!');
    }
}