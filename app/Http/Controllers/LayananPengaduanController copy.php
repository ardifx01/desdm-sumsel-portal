<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananPengaduanController extends Controller
{
    public function index()
    {
        // Halaman utama Layanan & Pengaduan (overview)
        return view('layanan-pengaduan.index');
    }

    public function showPengaduan()
    {
        // Halaman Pengaduan Masyarakat (dengan tautan ke SP4N-LAPOR!)
        return view('layanan-pengaduan.pengaduan');
    }

    public function showFaqUmum()
    {
        // Halaman FAQ Umum (di luar PPID)
        return view('layanan-pengaduan.faq-umum');
    }

    public function showDaftarLayanan()
    {
        // Halaman daftar layanan umum (non-perizinan/informasi publik)
        return view('layanan-pengaduan.daftar-layanan');
    }

    public function showCekStatus()
    {
        // Halaman untuk cek status layanan (opsional, placeholder)
        return view('layanan-pengaduan.cek-status');
    }
}