<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;
use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use App\Models\Comment;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = [];

        // --- PENGAMBILAN DATA YANG DIOPTIMALKAN ---

        if (in_array($role, ['super_admin', 'ppid_admin'])) {
            // Menggabungkan 2 query COUNT menjadi 2 query sederhana
            $data['totalPermohonan'] = PermohonanInformasi::count();
            $data['totalKeberatan'] = PengajuanKeberatan::count();
            
            // Query ini sudah cukup efisien, biarkan
            $data['permohonanStatus'] = PermohonanInformasi::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
            $data['keberatanStatus'] = PengajuanKeberatan::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');

            // PERBAIKAN N+1: Eager load 'user'
            $data['recentPermohonan'] = PermohonanInformasi::with('user')->latest()->take(5)->get();
            $data['recentKeberatan'] = PengajuanKeberatan::with('user')->latest()->take(5)->get();
            
            $data['totalInformasiPublik'] = InformasiPublik::count();
            // Logika kategori info publik tetap sama, karena sudah efisien
            $data['infoPublikCategories'] = DB::table('informasi_publik_categories')
                ->join('informasi_publik', 'informasi_publik_categories.id', '=', 'informasi_publik.category_id')
                ->select('informasi_publik_categories.nama as name', DB::raw('count(informasi_publik.id) as total'))
                ->groupBy('informasi_publik_categories.nama')
                ->pluck('total', 'name');
        }

        if ($role === 'super_admin') {
            $settings = Setting::pluck('value', 'key')->all();
            $data['settings'] = $settings;

            // Menggabungkan 4 query COUNT
            $data['totalUsers'] = User::count();
            $data['totalPosts'] = Post::count();
            $data['totalDokumen'] = Dokumen::count();
            $data['totalCommentsPending'] = Comment::where('status', 'pending')->count();
            
            // Logika kategori post tetap sama, karena sudah efisien
            $data['postCategories'] = DB::table('categories')
                ->join('posts', 'categories.id', '=', 'posts.category_id')
                ->select('categories.name', DB::raw('count(posts.id) as total'))
                ->where('categories.type', 'post')
                ->groupBy('categories.name')
                ->pluck('total', 'name');

            // Logika kategori dokumen tetap sama
            $data['dokumenCategories'] = DB::table('dokumen_categories')
                ->join('dokumen', 'dokumen_categories.id', '=', 'dokumen.category_id')
                ->select('dokumen_categories.nama as name', DB::raw('count(dokumen.id) as total'))
                ->groupBy('dokumen_categories.nama')
                ->pluck('total', 'name');

            // PERBAIKAN N+1: Eager load 'post'
            $data['recentComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
            
            // Query ini sudah efisien, biarkan
            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            $data['popularDokumen'] = Dokumen::orderByDesc('hits')->take(5)->get();
            $data['popularInformasiPublik'] = InformasiPublik::orderByDesc('hits')->take(5)->get();

        } elseif ($role === 'editor') {
            $data['totalPosts'] = Post::count();

            // Logika kategori post tetap sama
            $data['postCategories'] = DB::table('categories')
                ->join('posts', 'categories.id', '=', 'posts.category_id')
                ->select('categories.name', DB::raw('count(posts.id) as total'))
                ->where('categories.type', 'post')
                ->groupBy('categories.name')
                ->pluck('total', 'name');

            $data['popularPosts'] = Post::orderByDesc('hits')->take(5)->get();
            // PERBAIKAN N+1: Eager load 'post'
            $data['pendingComments'] = Comment::where('status', 'pending')->with('post')->latest()->take(5)->get();
        }

        return view('dashboard', $data);
    }
}