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
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = [];

        // Data yang dibutuhkan oleh Super Admin dan PPID Admin
        if (in_array($role, ['super_admin', 'ppid_admin'])) {
            $data['totalPermohonan'] = PermohonanInformasi::count();
            $data['totalKeberatan'] = PengajuanKeberatan::count();
            
            // --- STATISTIK STATUS BARU ---
            $data['permohonanStatus'] = PermohonanInformasi::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $data['keberatanStatus'] = PengajuanKeberatan::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');
            
            $data['recentPermohonan'] = PermohonanInformasi::with('user')->latest()->take(5)->get();
            $data['recentKeberatan'] = PengajuanKeberatan::with('user')->latest()->take(5)->get();
        }

        if ($role === 'super_admin') {
            // Data spesifik untuk Super Admin
            $data['totalUsers'] = User::count();
            $data['totalPosts'] = Post::count();
            $data['totalDokumen'] = Dokumen::count();
            $data['totalCommentsPending'] = Comment::where('status', 'pending')->count();
            
            $data['recentComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            $data['popularDokumen'] = Dokumen::orderByDesc('hits')->take(5)->get();

        } elseif ($role === 'ppid_admin') {
            // Data spesifik untuk PPID Admin
            $data['totalInformasiPublik'] = InformasiPublik::count();

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