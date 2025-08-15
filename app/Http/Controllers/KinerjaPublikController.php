<?php

namespace App\Http\Controllers;

use App\Models\Kinerja;
use App\Models\SasaranStrategis;
use Illuminate\Http\Request;

class KinerjaPublikController extends Controller
{
    public function index(Request $request)
    {
        $latestYear = Kinerja::max('tahun');
        $validated = $request->validate(['tahun' => 'nullable|integer|digits:4']);
        $tahun = $validated['tahun'] ?? $latestYear ?? date('Y');
        $availableYears = Kinerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        // Ambil semua data kinerja untuk tahun yang dipilih
        $sasaranStrategis = SasaranStrategis::with([
            'indikatorKinerja.kinerja' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            }
        ])->orderBy('urutan')->get();

        return view('kinerja.index', compact('tahun', 'availableYears', 'sasaranStrategis'));
    }
}