<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidangSektoralController extends Controller
{
    public function index()
    {
        // Halaman daftar semua Bidang, UPTD, Cabang Dinas
        // Konten halaman ini akan dibuat secara statis di view
        $bidangUnits = [
            ['nama' => 'Sekretariat', 'slug' => 'sekretariat', 'deskripsi' => 'Unit yang menangani administrasi dan pelayanan internal dinas.'],
            ['nama' => 'Bidang Energi', 'slug' => 'bidang-energi', 'deskripsi' => 'Fokus pada pengembangan dan pengelolaan sumber daya energi.'],
            ['nama' => 'Bidang Ketenagalistrikan', 'slug' => 'bidang-ketenagalistrikan', 'deskripsi' => 'Mengawasi dan mengembangkan infrastruktur ketenagalistrikan.'],
            ['nama' => 'Bidang Pengusahaan Minerba', 'slug' => 'bidang-pengusahaan-minerba', 'deskripsi' => 'Mengelola perizinan dan pengawasan usaha mineral dan batubara.'],
            ['nama' => 'Bidang Teknik dan Penerimaan Minerba', 'slug' => 'bidang-teknik-dan-penerimaan-minerba', 'deskripsi' => 'Mengatur aspek teknis pertambangan dan penerimaan negara.'],
            ['nama' => 'UPTD Geolab', 'slug' => 'uptd-geolab', 'deskripsi' => 'Unit pelaksana teknis yang fokus pada analisis laboratorium geologi.'],
            ['nama' => 'Cabang Dinas Regional I', 'slug' => 'cabang-dinas-regional-i', 'deskripsi' => 'Melayani wilayah kerja Kota Palembang dan Kab. Banyuasin.'],
            ['nama' => 'Cabang Dinas Regional II', 'slug' => 'cabang-dinas-regional-ii', 'deskripsi' => 'Melayani wilayah kerja Kab. Musi Banyuasin.'],
            ['nama' => 'Cabang Dinas Regional III', 'slug' => 'cabang-dinas-regional-iii', 'deskripsi' => 'Melayani wilayah kerja Kota Lubuk Linggau, Kab. Musi Rawas dan Kab. Musi Rawas Utara'],
            ['nama' => 'Cabang Dinas Regional IV', 'slug' => 'cabang-dinas-regional-iv', 'deskripsi' => 'Melayani wilayah kerja Kab. Lahat, Kab. Empat Lawang dan Kota Pagaralam.'],
            ['nama' => 'Cabang Dinas Regional V', 'slug' => 'cabang-dinas-regional-v', 'deskripsi' => 'Melayani wilayah kerja Kab. Muara Enim, Kota Prabumulih dan Kab. Penukal Abab Lematang Ilir.'],
            ['nama' => 'Cabang Dinas Regional VI', 'slug' => 'cabang-dinas-regional-vi', 'deskripsi' => 'Melayani wilayah kerja Kab. Ogan Komering Ulu, Kab. Ogan Komering Ulu Timur dan Kab. Ogan Komering Ulu Selatan.'],
            ['nama' => 'Cabang Dinas Regional VII', 'slug' => 'cabang-dinas-regional-vii', 'deskripsi' => 'Melayani wilayah kerja Kab. Ogan Ilir dan Kab. Ogan Komering Ilir.'],

            // ... tambahkan daftar bidang/unit lainnya sesuai kebutuhan sitemap ...
        ];
        return view('bidang-sektoral.index', compact('bidangUnits'));
    }

    public function show($slug)
    {
        // Konten untuk setiap bidang/unit akan dibuat statis per view.
        // Metode ini hanya untuk mengarahkan ke view yang benar berdasarkan slug.
        // Anda bisa menggunakan switch case atau array mapping di sini.
        // Untuk kesederhanaan, kita akan mengarahkan ke view sesuai slug
        // Contoh: 'bidang-energi' akan mengarah ke 'bidang-sektoral.pages.bidang-energi'

        $viewName = 'bidang-sektoral.pages.' . $slug;

        if (view()->exists($viewName)) {
            return view($viewName);
        }

        // Jika view tidak ditemukan untuk slug tersebut, arahkan ke 404
        abort(404, 'Halaman bidang/unit tidak ditemukan.');
    }

    public function showDataStatistik()
    {
        // Halaman khusus untuk data dan statistik sektoral (statis)
        return view('bidang-sektoral.data-statistik');
    }
}