<?php

namespace App\Http\Controllers;

use App\Models\StaticPage; // Import model
use Illuminate\Http\Request;

class HalamanStatisController extends Controller
{
    public function show($slug)
    {
        $page = StaticPage::where('slug', $slug)->firstOrFail();
        return view('static-pages.show', compact('page'));
    }

    public function showPetaSitus()
    {
        // Halaman Peta Situs
        return view('static-pages.peta-situs');
    }
}