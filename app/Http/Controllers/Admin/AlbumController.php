<?php

namespace App\Http\Controllers\Admin;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class AlbumController extends Controller
{
    // ... (method index, create, edit, destroy tidak berubah) ...
    public function index()
    {
        Gate::authorize('viewAny', Album::class);
        $albums = Album::withCount('photos')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        Gate::authorize('create', Album::class);
        return view('admin.albums.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Album::class);

        $request->validate([
            'nama' => 'required|string|max:255|unique:albums,nama',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $folderRelativePath = 'thumbnails/albums/' . date('Y') . '/' . date('m');
            $thumbnailPath = $request->file('thumbnail')->store($folderRelativePath, 'public');

            // --- PERBAIKAN UNTUK MENGHILANGKAN ERROR IDE ---
            $absolutePath = storage_path('app/public/' . $thumbnailPath);
            OptimizerChainFactory::create()->optimize($absolutePath);
            // -------------------------------------------
        }

        Album::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $thumbnailPath,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.albums.index')->with('success', 'Album foto berhasil ditambahkan!');
    }

    public function edit(Album $album)
    {
        Gate::authorize('update', $album);
        return view('admin.albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        Gate::authorize('update', $album);

        $request->validate([
            'nama' => 'required|string|max:255|unique:albums,nama,' . $album->id,
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $thumbnailPath = $album->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($album->thumbnail && Storage::disk('public')->exists($album->thumbnail)) {
                Storage::disk('public')->delete($album->thumbnail);
            }
            $folderRelativePath = 'thumbnails/albums/' . date('Y') . '/' . date('m');
            $thumbnailPath = $request->file('thumbnail')->store($folderRelativePath, 'public');

            // --- PERBAIKAN UNTUK MENGHILANGKAN ERROR IDE ---
            $absolutePath = storage_path('app/public/' . $thumbnailPath);
            OptimizerChainFactory::create()->optimize($absolutePath);
            // -------------------------------------------
        }

        $album->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $thumbnailPath,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.albums.index')->with('success', 'Album foto berhasil diperbarui!');
    }

    public function destroy(Album $album)
    {
        Gate::authorize('delete', $album);

        if ($album->thumbnail && Storage::disk('public')->exists($album->thumbnail)) {
            Storage::disk('public')->delete($album->thumbnail);
        }
        
        foreach ($album->photos as $photo) {
            if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
            $photo->delete();
        }

        $album->delete();

        return redirect()->route('admin.albums.index')->with('success', 'Album foto dan semua isinya berhasil dihapus!');
    }
}