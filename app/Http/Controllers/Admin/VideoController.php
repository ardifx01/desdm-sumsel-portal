<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Models\Album; // Untuk Policy
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class VideoController extends Controller
{
    // ... (method index, create, edit, destroy tidak berubah) ...
    public function index()
    {
        Gate::authorize('viewAny', Album::class);
        $videos = Video::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        Gate::authorize('create', Album::class);
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Album::class);

        $request->validate([
            'judul' => 'required|string|max:255|unique:videos,judul',
            'video_url' => 'required|url',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $embedCode = $this->generateEmbedCode($request->video_url);
        if (!$embedCode) {
            return back()->withInput()->withErrors(['video_url' => 'URL video tidak didukung atau tidak valid. Gunakan URL dari YouTube.']);
        }

        // --- LOGIKA BARU: Simpan thumbnail saat membuat ---
        $thumbnailUrl = $this->getYouTubeThumbnail($request->video_url);

        Video::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'embed_code' => $embedCode,
            'thumbnail' => $thumbnailUrl, // <-- Simpan URL thumbnail
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan!');
    }

    public function edit(Video $video)
    {
        Gate::authorize('update', Album::class);
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        Gate::authorize('update', Album::class);

        $request->validate([
            'judul' => 'required|string|max:255|unique:videos,judul,' . $video->id,
            'video_url' => 'required|url',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $embedCode = $this->generateEmbedCode($request->video_url);
        if (!$embedCode) {
            return back()->withInput()->withErrors(['video_url' => 'URL video tidak didukung atau tidak valid. Gunakan URL dari YouTube.']);
        }

        // --- LOGIKA BARU: Simpan thumbnail saat update ---
        $thumbnailUrl = $this->getYouTubeThumbnail($request->video_url);

        $video->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'embed_code' => $embedCode,
            'thumbnail' => $thumbnailUrl, // <-- Simpan URL thumbnail
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui!');
    }

    public function destroy(Video $video)
    {
        Gate::authorize('delete', Album::class);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus!');
    }

    private function generateEmbedCode(string $url): ?string
    {
        $videoId = $this->getYouTubeVideoId($url);
        if ($videoId) {
            return '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
        return null;
    }

    private function getYouTubeVideoId(string $url): ?string
    {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function getYouTubeThumbnail(string $url): ?string
    {
        $videoId = $this->getYouTubeVideoId($url);
        if ($videoId) {
            return "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
        }
        return null;
    }
}