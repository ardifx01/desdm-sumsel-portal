<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SasaranStrategis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SasaranStrategisController extends Controller
{
    // Kita tidak lagi menggunakan __construct() untuk otorisasi

    public function index()
    {
        Gate::authorize('viewAny', SasaranStrategis::class);
        $sasaranStrategis = SasaranStrategis::orderBy('urutan')->get();
        return view('admin.sasaran-strategis.index', compact('sasaranStrategis'));
    }

    public function create()
    {
        Gate::authorize('create', SasaranStrategis::class);
        return view('admin.sasaran-strategis.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', SasaranStrategis::class);
        $validated = $request->validate([
            'sasaran' => 'required|string|unique:sasaran_strategis,sasaran',
            'urutan' => 'required|integer',
        ]);

        SasaranStrategis::create($validated);
        return redirect()->route('admin.sasaran-strategis.index')->with('success', 'Sasaran strategis berhasil ditambahkan.');
    }

    public function edit(SasaranStrategis $sasaranStrategi)
    {
        Gate::authorize('update', $sasaranStrategi);
        return view('admin.sasaran-strategis.edit', compact('sasaranStrategi'));
    }

    public function update(Request $request, SasaranStrategis $sasaranStrategi)
    {
        Gate::authorize('update', $sasaranStrategi);
        $validated = $request->validate([
            'sasaran' => 'required|string|unique:sasaran_strategis,sasaran,' . $sasaranStrategi->id,
            'urutan' => 'required|integer',
        ]);

        $sasaranStrategi->update($validated);
        return redirect()->route('admin.sasaran-strategis.index')->with('success', 'Sasaran strategis berhasil diperbarui.');
    }

    public function destroy(SasaranStrategis $sasaranStrategi)
    {
        Gate::authorize('delete', $sasaranStrategi);
        $sasaranStrategi->delete();
        return redirect()->route('admin.sasaran-strategis.index')->with('success', 'Sasaran strategis berhasil dihapus.');
    }
}