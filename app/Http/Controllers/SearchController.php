<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;
use App\Models\Bidang;
use App\Models\Seksi;
use App\Models\Pejabat;
use Illuminate\Database\Eloquent\Collection;

class SearchController extends Controller
{
    /**
     * Menangani permintaan pencarian global menggunakan Laravel Scout.
     */
    public function index(Request $request)
    {
        // Validasi input pencarian
        $request->validate(['q' => 'nullable|string|min:3']);
        $query = $request->input('q');
        
        $results = collect();

        // Lakukan pencarian hanya jika query valid
        if ($query) {

            // Pencarian di Post (Berita)
            $posts = Post::search($query)
                         ->where('status', 'published') // Filter tambahan setelah pencarian
                         ->get()
                         ->map(function ($item) {
                             return [
                                 'type' => 'post',
                                 'title' => $item->title,
                                 'content' => $item->content_html,
                                 'category_name' => $item->category->name ?? 'Tanpa Kategori',
                                 'slug' => $item->slug,
                             ];
                         });

            // Pencarian di Dokumen
            $dokumen = Dokumen::search($query)
                             ->where('is_active', true)
                             ->get()
                             ->map(function ($item) {
                                 return [
                                     'type' => 'dokumen',
                                     'title' => $item->judul,
                                     'content' => $item->deskripsi,
                                     'category_name' => $item->category->name ?? 'Tanpa Kategori',
                                     'slug' => $item->slug,
                                 ];
                             });

            // Pencarian di Informasi Publik
            $informasiPublik = InformasiPublik::search($query)
                                           ->where('is_active', true)
                                           ->get()
                                           ->map(function ($item) {
                                               return [
                                                   'type' => 'informasi_publik',
                                                   'title' => $item->judul,
                                                   'content' => $item->konten,
                                                   'category_name' => $item->category->name ?? 'Tanpa Kategori',
                                                   'slug' => $item->slug,
                                               ];
                                           });

            // Pencarian di Bidang
            $bidangs = Bidang::search($query)
                            ->where('is_active', true)
                            ->get()
                            ->map(function ($item) {
                                return [
                                    'type' => 'bidang',
                                    'title' => $item->nama,
                                    'content' => $item->tupoksi,
                                    'slug' => $item->slug,
                                ];
                            });

            // Pencarian di Seksi
            $seksis = Seksi::search($query)
                          ->where('is_active', true)
                          ->get()
                          ->map(function ($item) {
                              return [
                                  'type' => 'seksi',
                                  'title' => $item->nama_seksi,
                                  'content' => $item->tugas,
                                  'parent_slug' => $item->bidang->slug ?? '#',
                              ];
                          });

            // Pencarian di Pejabat
            $pejabats = Pejabat::search($query)
                              ->where('is_active', true)
                              ->get()
                              ->map(function ($item) {
                                  return [
                                      'type' => 'pejabat',
                                      'title' => $item->nama,
                                      'content' => $item->jabatan,
                                      'id' => $item->id,
                                  ];
                              });

            // Menggabungkan semua hasil ke dalam satu koleksi untuk di-pass ke view
            $results->push(['label' => 'Berita', 'items' => $posts, 'route_name' => 'berita.show', 'has_category' => true]);
            $results->push(['label' => 'Publikasi & Dokumen', 'items' => $dokumen, 'route_name' => 'publikasi.show', 'has_category' => true]);
            $results->push(['label' => 'Informasi Publik', 'items' => $informasiPublik, 'route_name' => 'informasi-publik.show', 'has_category' => true]);
            $results->push(['label' => 'Bidang Sektoral', 'items' => $bidangs, 'route_name' => 'bidang-sektoral.show']);
            $results->push(['label' => 'Seksi Bidang', 'items' => $seksis, 'route_name' => 'bidang-sektoral.show', 'param_is_parent' => true]);
            $results->push(['label' => 'Pejabat Dinas', 'items' => $pejabats, 'route_name' => 'tentang-kami.detail-pimpinan']);
        }

        return view('search.index', compact('query', 'results'));
    }
}