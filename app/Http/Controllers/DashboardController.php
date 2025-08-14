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
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = [];

        if (in_array($role, ['super_admin', 'ppid_admin'])) {
            $data['totalPermohonan'] = PermohonanInformasi::count();
            $data['totalKeberatan'] = PengajuanKeberatan::count();
            $data['permohonanStatus'] = PermohonanInformasi::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
            $data['keberatanStatus'] = PengajuanKeberatan::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
            $data['recentPermohonan'] = PermohonanInformasi::with('user')->latest()->take(5)->get();
            $data['recentKeberatan'] = PengajuanKeberatan::with('user')->latest()->take(5)->get();
            
            // --- PERUBAHAN DI SINI: Data ini sekarang dibutuhkan oleh kedua peran ---
            $data['totalInformasiPublik'] = InformasiPublik::count();
            $data['infoPublikCategories'] = DB::table('informasi_publik_categories')
                ->join('informasi_publik', 'informasi_publik_categories.id', '=', 'informasi_publik.category_id')
                ->select('informasi_publik_categories.nama as name', DB::raw('count(informasi_publik.id) as total'))
                ->groupBy('informasi_publik_categories.nama')
                ->pluck('total', 'name');
        }

        if ($role === 'super_admin') {
            $settings = Setting::pluck('value', 'key')->all();
            $data['settings'] = $settings;

            $data['totalUsers'] = User::count();
            $data['totalPosts'] = Post::count();
            $data['totalDokumen'] = Dokumen::count();
            $data['totalCommentsPending'] = Comment::where('status', 'pending')->count();
            
            $data['postCategories'] = DB::table('categories')
                ->join('posts', 'categories.id', '=', 'posts.category_id')
                ->select('categories.name', DB::raw('count(posts.id) as total'))
                ->where('categories.type', 'post')
                ->groupBy('categories.name')
                ->pluck('total', 'name');

            $data['dokumenCategories'] = DB::table('dokumen_categories')
                ->join('dokumen', 'dokumen_categories.id', '=', 'dokumen.category_id')
                ->select('dokumen_categories.nama as name', DB::raw('count(dokumen.id) as total'))
                ->groupBy('dokumen_categories.nama')
                ->pluck('total', 'name');

            $data['recentComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            $data['popularDokumen'] = Dokumen::orderByDesc('hits')->take(5)->get();
            $data['popularInformasiPublik'] = InformasiPublik::orderByDesc('hits')->take(5)->get();

        } elseif ($role === 'ppid_admin') {
            // Data spesifik untuk PPID Admin
            $data['totalInformasiPublik'] = InformasiPublik::count();

        } elseif ($role === 'editor') {
            // Data untuk Editor
            $data['totalPosts'] = Post::count();

            // --- PERUBAHAN DI SINI: Tambahkan statistik kategori untuk editor ---
            $data['postCategories'] = DB::table('categories')
                ->join('posts', 'categories.id', '=', 'posts.category_id')
                ->select('categories.name', DB::raw('count(posts.id) as total'))
                ->where('categories.type', 'post')
                ->groupBy('categories.name')
                ->pluck('total', 'name');
            // -----------------------------------------------------------------

            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            $data['pendingComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
        }

        return view('dashboard', $data);
    }
}