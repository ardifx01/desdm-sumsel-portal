<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanStatisController extends Controller
{
    public function showPetaSitus()
    {
        // Halaman Peta Situs
        return view('static-pages.peta-situs');
    }

    public function showKebijakanPrivasi()
    {
        // Halaman Kebijakan Privasi
        return view('static-pages.kebijakan-privasi');
    }

    public function showDisclaimer()
    {
        // Halaman Disclaimer
        return view('static-pages.disclaimer');
    }

    public function showAksesibilitas()
    {
        // Halaman Aksesibilitas
        return view('static-pages.aksesibilitas');
    }
}