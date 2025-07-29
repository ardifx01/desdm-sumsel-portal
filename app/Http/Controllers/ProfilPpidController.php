<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilPpidController extends Controller
{
    public function index()
    {
        // Halaman utama Profil PPID
        return view('informasi-publik.profil-ppid.index');
    }

    public function visiMisiMaklumat()
    {
        // Halaman Visi, Misi & Maklumat Pelayanan PPID
        return view('informasi-publik.profil-ppid.visi-misi-maklumat');
    }

    public function strukturOrganisasiPpid()
    {
        // Halaman Struktur Organisasi PPID
        return view('informasi-publik.profil-ppid.struktur-organisasi');
    }

    public function dasarHukumPpid()
    {
        // Halaman Dasar Hukum PPID
        return view('informasi-publik.profil-ppid.dasar-hukum');
    }

    public function tugasFungsiPpid()
    {
        // Halaman Tugas & Fungsi PPID
        return view('informasi-publik.profil-ppid.tugas-fungsi');
    }

        // --- Tambahkan metode baru ini untuk Kontak PPID ---
    public function kontakPpid()
    {
        // Halaman Kontak PPID
        return view('informasi-publik.kontak-ppid');
    }
}