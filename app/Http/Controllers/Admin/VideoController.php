<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\Video; // Import model Video Anda
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Log; // Untuk logging

class VideoController extends Controller // Nama kelas adalah VideoController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255|unique:videos,judul',
            'deskripsi' => 'nullable|string',
            'embed_code' => 'required|string', // Kode embed video
            'thumbnail' => 'nullable|url|max:255', // URL thumbnail eksternal
            'is_active' => 'required|boolean',
        ]);

        Video::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'embed_code' => $request->embed_code,
            'thumbnail' => $request->thumbnail,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video) // Menggunakan Route Model Binding
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'judul' => 'required|string|max:255|unique:videos,judul,' . $video->id,
            'deskripsi' => 'nullable|string',
            'embed_code' => 'required|string',
            'thumbnail' => 'nullable|url|max:255',
            'is_active' => 'required|boolean',
        ]);

        $video->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'embed_code' => $request->embed_code,
            'thumbnail' => $request->thumbnail,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        try {
            $deleteResult = $video->delete(); // Hapus record dari database

            if ($deleteResult) {
                Log::info('Video berhasil dihapus: ' . $video->judul);
                return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus!');
            } else {
                Log::error('Video GAGAL dihapus dari database (delete() mengembalikan false): ' . $video->judul);
                return redirect()->route('admin.videos.index')->with('error', 'Gagal menghapus video.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus video (Exception): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.videos.index')->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }
}