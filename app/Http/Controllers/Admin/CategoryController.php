<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar untuk controller ini

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller; // <-- TAMBAHKAN BARIS INI

class CategoryController extends Controller // <-- Sekarang Controller ini dikenali
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::ofTypePost()->orderBy('name')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'type' => 'required|in:post,document',
        ], [
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => 'post',
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if ($category->type !== 'post') {
            abort(404, 'Kategori tidak ditemukan atau bukan tipe berita.');
        }
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'type' => 'required|in:post,document',
        ], [
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->type !== 'post') {
            abort(404, 'Kategori tidak ditemukan atau bukan tipe berita.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berita berhasil dihapus!');
    }
}