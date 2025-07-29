<?php

namespace App\Http\Controllers;

use App\Models\Pejabat; // Import model Pejabat
use Illuminate\Http\Request;

class TentangKamiController extends Controller
{
    public function index()
    {
        // Halaman utama Tentang Kami (overview)
        return view('tentang-kami.index');
    }

    public function visiMisi()
    {
        // Halaman Visi, Misi & Tujuan
        return view('tentang-kami.visi-misi');
    }

    public function strukturOrganisasi()
    {
        // Halaman Struktur Organisasi
        return view('tentang-kami.struktur-organisasi');
    }

    public function tugasFungsi()
    {
        // Halaman Tugas & Fungsi
        return view('tentang-kami.tugas-fungsi');
    }

    public function profilPimpinan()
    {
        // Halaman daftar profil pimpinan
        $pejabat = Pejabat::where('is_active', true)
                            ->orderBy('urutan', 'asc')
                            ->orderBy('jabatan', 'asc')
                            ->get(); // Ambil semua pejabat yang aktif, diurutkan

        return view('tentang-kami.profil-pimpinan.index', compact('pejabat'));
    }

    public function detailPimpinan($id)
    {
        // Halaman detail profil pimpinan berdasarkan ID
        $pejabat = Pejabat::where('is_active', true)->findOrFail($id); // Temukan pejabat berdasarkan ID, atau tampilkan 404 jika tidak ditemukan
        return view('tentang-kami.profil-pimpinan.show', compact('pejabat'));
    }
}