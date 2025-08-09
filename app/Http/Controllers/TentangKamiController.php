<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
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

/*     public function strukturOrganisasi()
    {
        // Halaman Struktur Organisasi
        return view('tentang-kami.struktur-organisasi');
    } */

    public function strukturOrganisasi()
    {
        $kepalaDinas = Pejabat::where('jabatan', 'Kepala Dinas')->first();

        $allUnits = Bidang::with(['kepala', 'seksis.kepala'])
                          ->where('is_active', true)
                          ->orderBy('id')
                          ->get();

        // Pisahkan menjadi grup berdasarkan tipe, lakukan perbandingan case-insensitive
        $bidangs = $allUnits->filter(function ($unit) {
            return Str::lower($unit->tipe) === 'bidang';
        })->take(5);

        $uptds = $allUnits->filter(function ($unit) {
            return Str::lower($unit->tipe) === 'uptd';
        });

        $cabangDinas = $allUnits->filter(function ($unit) {
            return Str::lower($unit->tipe) === 'cabang_dinas';
        });

        return view('tentang-kami.struktur-organisasi', compact('kepalaDinas', 'bidangs', 'uptds', 'cabangDinas'));
    }
    public function tugasFungsi()
    {
        // Halaman Tugas & Fungsi
        return view('tentang-kami.tugas-fungsi');
    }

    public function profilPimpinan()
    {
        $pejabat = Pejabat::where(function (Builder $query) {
            $query->where('jabatan', 'like', 'Kepala Dinas%')
                  ->orWhere('jabatan', 'like', 'Sekretaris%')
                  ->orWhere('jabatan', 'like', 'Kepala Bidang%')
                  ->orWhere('jabatan', 'like', 'Kepala UPTD%')
                  ->orWhere('jabatan', 'like', 'Kepala Cabang Dinas%');
        })
        ->get();

        return view('tentang-kami.profil-pimpinan.index', compact('pejabat'));
    }

    public function detailPimpinan($id)
    {
        // Halaman detail profil pimpinan berdasarkan ID
        $pejabat = Pejabat::where('is_active', true)->findOrFail($id); // Temukan pejabat berdasarkan ID, atau tampilkan 404 jika tidak ditemukan
        return view('tentang-kami.profil-pimpinan.show', compact('pejabat'));
    }

public function showModal(Pejabat $pejabat)
    {
        // Mengembalikan hanya view parsial, bukan seluruh halaman
        return view('tentang-kami.partials.pejabat-modal-content', compact('pejabat'));
    }


}