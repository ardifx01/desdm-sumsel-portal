<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\Album; // Import model Album Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Log; // Untuk logging

class AlbumController extends Controller // Nama kelas adalah AlbumController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.albums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:albums,nama',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB, hanya gambar
            'is_active' => 'required|boolean',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $folderRelativePath = 'thumbnails/albums/' . date('Y') . '/' . date('m'); // Path: storage/app/public/thumbnails/albums/YYYY/MM
            $thumbnailPath = $request->file('thumbnail')->store($folderRelativePath, 'public');
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album) // Menggunakan Route Model Binding
    {
        return view('admin.albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:albums,nama,' . $album->id,
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $thumbnailPath = $album->thumbnail; // Default ke thumbnail lama
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($album->thumbnail && Storage::disk('public')->exists($album->thumbnail)) {
                Storage::disk('public')->delete($album->thumbnail);
            }
            $folderRelativePath = 'thumbnails/albums/' . date('Y') . '/' . date('m');
            $thumbnailPath = $request->file('thumbnail')->store($folderRelativePath, 'public');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        try {
            // Hapus thumbnail album jika ada
            if ($album->thumbnail && Storage::disk('public')->exists($album->thumbnail)) {
                Storage::disk('public')->delete($album->thumbnail);
            }
            // Hapus semua foto dalam album ini
            if ($album->photos->count() > 0) {
                foreach ($album->photos as $photo) {
                    if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                        Storage::disk('public')->delete($photo->file_path);
                    }
                    $photo->delete(); // Hapus record foto dari database
                }
            }

            $deleteResult = $album->delete(); // Hapus album dari database

            if ($deleteResult) {
                Log::info('Album foto berhasil dihapus: ' . $album->nama);
                return redirect()->route('admin.albums.index')->with('success', 'Album foto berhasil dihapus!');
            } else {
                Log::error('Album foto GAGAL dihapus dari database (delete() mengembalikan false): ' . $album->nama);
                return redirect()->route('admin.albums.index')->with('error', 'Gagal menghapus album foto.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus album foto (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.albums.index')->with('error', 'Gagal menghapus album foto: ' . $e->getMessage());
        }
    }
}