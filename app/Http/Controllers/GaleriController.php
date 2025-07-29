<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        // Tampilkan daftar album dan video (bisa dipisah di view)
        $albums = Album::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $videos = Video::where('is_active', true)->orderBy('created_at', 'desc')->get();

        return view('galeri.index', compact('albums', 'videos'));
    }

    public function showAlbum($slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('galeri.album', compact('album'));
    }

    public function showVideo($slug)
    {
        $video = Video::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('galeri.video', compact('video'));
    }
}