<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\Photo; // Import model Photo Anda
use App\Models\Album; // Import model Album Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk nama file acak
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Log; // Untuk logging

class PhotoController extends Controller // Nama kelas adalah PhotoController
{
    /**
     * Display a listing of the resource (photos within a specific album).
     */
    public function index(Album $album) // Menggunakan Route Model Binding untuk Album
    {
        $photos = $album->photos()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.photos.index', compact('photos', 'album'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Album $album)
    {
        return view('admin.photos.create', compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Album $album)
    {
        $request->validate([
            'file_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB, hanya gambar
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $filePath = null;
        $fileNameOriginal = null;
        if ($request->hasFile('file_photo')) {
            $uploadedFile = $request->file('file_photo');
            $folderRelativePath = 'photos/' . date('Y') . '/' . date('m'); // Path: storage/app/public/photos/YYYY/MM
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNameOriginal = $uploadedFile->getClientOriginalName();
        }

        $album->photos()->create([ // Membuat foto terkait langsung dengan album
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_name' => $fileNameOriginal,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.albums.photos.index', $album)->with('success', 'Foto berhasil ditambahkan ke album!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album, Photo $photo) // Nested Route Model Binding
    {
        // Pastikan foto ini milik album yang benar
        if ($photo->album_id !== $album->id) {
            abort(404);
        }
        return view('admin.photos.edit', compact('album', 'photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album, Photo $photo)
    {
        // Pastikan foto ini milik album yang benar
        if ($photo->album_id !== $album->id) {
            abort(404);
        }

        $request->validate([
            'file_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $filePath = $photo->file_path; // Default ke file lama
        $fileNameOriginal = $photo->file_name;
        if ($request->hasFile('file_photo')) {
            // Hapus file lama jika ada
            if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
            $uploadedFile = $request->file('file_photo');
            $folderRelativePath = 'photos/' . date('Y') . '/' . date('m');
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNameOriginal = $uploadedFile->getClientOriginalName();
        }

        $photo->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_name' => $fileNameOriginal,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.albums.photos.index', $album)->with('success', 'Foto berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album, Photo $photo) // Nested Route Model Binding
    {
        // Pastikan foto ini milik album yang benar
        if ($photo->album_id !== $album->id) {
            abort(404);
        }

        try {
            // Hapus file fisik jika ada
            if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $deleteResult = $photo->delete(); // Hapus record dari database

            if ($deleteResult) {
                Log::info('Foto berhasil dihapus: ' . ($photo->judul ?: $photo->file_name));
                return redirect()->route('admin.albums.photos.index', $album)->with('success', 'Foto berhasil dihapus!');
            } else {
                Log::error('Foto GAGAL dihapus dari database (delete() mengembalikan false): ' . ($photo->judul ?: $photo->file_name));
                return redirect()->route('admin.albums.photos.index', $album)->with('error', 'Gagal menghapus foto.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus foto (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.albums.photos.index', $album)->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }
}