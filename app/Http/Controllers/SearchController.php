<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Dokumen;
use App\Models\InformasiPublik;
use App\Models\Bidang;
use App\Models\Seksi;
use App\Models\Pejabat;

class SearchController extends Controller
{
    /**
     * Menangani permintaan pencarian global.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $results = collect();

        if ($query) {
            $normalizedQuery = strtolower($query);

            // Pencarian di Post (Berita)
            $posts = Post::where('status', 'published')
                         ->where(function ($q) use ($normalizedQuery) {
                             $q->where('title', 'like', "%{$normalizedQuery}%")
                               ->orWhere('content_html', 'like', "%{$normalizedQuery}%");
                         })
                         ->with('category')
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
            $dokumen = Dokumen::where('is_active', true)
                             ->where(function ($q) use ($normalizedQuery) {
                                 $q->where('judul', 'like', "%{$normalizedQuery}%")
                                   ->orWhere('deskripsi', 'like', "%{$normalizedQuery}%");
                             })
                             ->with('category')
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
            $informasiPublik = InformasiPublik::where('is_active', true)
                                           ->where(function ($q) use ($normalizedQuery) {
                                               $q->where('judul', 'like', "%{$normalizedQuery}%")
                                                 ->orWhere('konten', 'like', "%{$normalizedQuery}%");
                                           })
                                           ->with('category')
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
            $bidangs = Bidang::where('is_active', true)
                            ->where(function ($q) use ($normalizedQuery) {
                                $q->where('nama', 'like', "%{$normalizedQuery}%")
                                  ->orWhere('tupoksi', 'like', "%{$normalizedQuery}%");
                            })
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
            $seksis = Seksi::where('is_active', true)
                          ->where(function ($q) use ($normalizedQuery) {
                              $q->where('nama_seksi', 'like', "%{$normalizedQuery}%")
                                ->orWhere('tugas', 'like', "%{$normalizedQuery}%");
                          })
                          ->with('bidang')
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
            $pejabats = Pejabat::where('is_active', true)
                              ->where(function ($q) use ($normalizedQuery) {
                                  $q->where('nama', 'like', "%{$normalizedQuery}%")
                                    ->orWhere('nip', 'like', "%{$normalizedQuery}%")
                                    ->orWhere('jabatan', 'like', "%{$normalizedQuery}%")
                                    ->orWhere('deskripsi_singkat', 'like', "%{$normalizedQuery}%");
                              })
                              ->get()
                              ->map(function ($item) {
                                  return [
                                      'type' => 'pejabat',
                                      'title' => $item->nama,
                                      'content' => $item->jabatan,
                                      'id' => $item->id,
                                  ];
                              });

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