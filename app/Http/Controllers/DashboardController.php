<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;
use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use App\Models\Comment;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = [];

        if ($role === 'super_admin') {
            // Data untuk Super Admin
            $data['totalUsers'] = User::count();
            $data['totalPosts'] = Post::count();
            $data['totalDokumen'] = Dokumen::count();
            $data['totalCommentsPending'] = Comment::where('status', 'pending')->count();
            $data['totalPermohonan'] = PermohonanInformasi::count();
            $data['totalKeberatan'] = PengajuanKeberatan::count();
            
            $data['recentComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
            $data['recentPermohonan'] = PermohonanInformasi::latest()->take(5)->get();
            $data['recentKeberatan'] = PengajuanKeberatan::latest()->take(5)->get();

            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            $data['popularDokumen'] = Dokumen::orderByDesc('hits')->take(5)->get();

        } elseif ($role === 'ppid_admin') {
            // Data untuk PPID Admin
            $data['totalPermohonan'] = PermohonanInformasi::count();
            $data['permohonanStatus'] = PermohonanInformasi::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');
            $data['totalKeberatan'] = PengajuanKeberatan::count();
            $data['keberatanStatus'] = PengajuanKeberatan::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');
            $data['totalInformasiPublik'] = InformasiPublik::count();

            $data['recentPermohonan'] = PermohonanInformasi::latest()->take(5)->get();
            $data['recentKeberatan'] = PengajuanKeberatan::latest()->take(5)->get();

        } elseif ($role === 'editor') {
            // Data untuk Editor
            $data['totalPosts'] = Post::count();
            $data['totalDokumen'] = Dokumen::count();
            $data['totalAlbums'] = Album::count();

            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            $data['popularDokumen'] = Dokumen::orderByDesc('hits')->take(5)->get();
            $data['pendingComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
        }

        return view('dashboard', $data);
    }
}