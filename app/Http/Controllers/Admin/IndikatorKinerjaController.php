<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndikatorKinerja;
use App\Models\SasaranStrategis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IndikatorKinerjaController extends Controller
{
    // Kita tidak lagi menggunakan __construct() untuk otorisasi

    public function index()
    {
        Gate::authorize('viewAny', IndikatorKinerja::class);
        $sasaranStrategis = SasaranStrategis::with('indikatorKinerja')->orderBy('urutan')->get();
        return view('admin.indikator-kinerja.index', compact('sasaranStrategis'));
    }

    public function create()
    {
        Gate::authorize('create', IndikatorKinerja::class);
        $sasaranStrategis = SasaranStrategis::orderBy('urutan')->get();
        return view('admin.indikator-kinerja.create', compact('sasaranStrategis'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', IndikatorKinerja::class);
        $validated = $request->validate([
            'sasaran_strategis_id' => 'required|exists:sasaran_strategis,id',
            'nama_indikator' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'urutan' => 'required|integer',
        ]);

        IndikatorKinerja::create($validated);
        return redirect()->route('admin.indikator-kinerja.index')->with('success', 'Indikator kinerja berhasil ditambahkan.');
    }

    public function edit(IndikatorKinerja $indikatorKinerja)
    {
        Gate::authorize('update', $indikatorKinerja);
        $sasaranStrategis = SasaranStrategis::orderBy('urutan')->get();
        return view('admin.indikator-kinerja.edit', compact('indikatorKinerja', 'sasaranStrategis'));
    }

    public function update(Request $request, IndikatorKinerja $indikatorKinerja)
    {
        Gate::authorize('update', $indikatorKinerja);
        $validated = $request->validate([
            'sasaran_strategis_id' => 'required|exists:sasaran_strategis,id',
            'nama_indikator' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'urutan' => 'required|integer',
        ]);

        $indikatorKinerja->update($validated);
        return redirect()->route('admin.indikator-kinerja.index')->with('success', 'Indikator kinerja berhasil diperbarui.');
    }

    public function destroy(IndikatorKinerja $indikatorKinerja)
    {
        Gate::authorize('delete', $indikatorKinerja);
        $indikatorKinerja->delete();
        return redirect()->route('admin.indikator-kinerja.index')->with('success', 'Indikator kinerja berhasil dihapus.');
    }
}