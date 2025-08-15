<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kinerja;
use App\Models\SasaranStrategis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class KinerjaController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Kinerja::class);

        $validated = $request->validate(['tahun' => 'nullable|integer|digits:4']);
        $tahun = $validated['tahun'] ?? date('Y');

        $sasaranStrategis = SasaranStrategis::with([
            'indikatorKinerja.kinerja' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            }
        ])->orderBy('urutan')->get();

        $availableYears = Kinerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.kinerja.index', compact('sasaranStrategis', 'tahun', 'availableYears'));
    }

    public function storeOrUpdate(Request $request)
    {
        Gate::authorize('create', Kinerja::class);

        $validated = $request->validate([
            'tahun' => 'required|integer|digits:4',
            'kinerja' => 'required|array',
            'kinerja.*.target_tahunan' => 'nullable|string',
            'kinerja.*.realisasi_q1' => 'nullable|string',
            'kinerja.*.realisasi_q2' => 'nullable|string',
            'kinerja.*.realisasi_q3' => 'nullable|string',
            'kinerja.*.realisasi_q4' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['kinerja'] as $indikatorId => $data) {
                // Fungsi untuk membersihkan format angka
                $cleanNumber = function ($value) {
                    if (empty($value)) return null;
                    // Hapus titik ribuan, ganti koma desimal dengan titik
                    return str_replace(',', '.', str_replace('.', '', $value));
                };

                Kinerja::updateOrCreate(
                    [
                        'indikator_kinerja_id' => $indikatorId,
                        'tahun' => $validated['tahun'],
                    ],
                    [
                        'target_tahunan' => $cleanNumber($data['target_tahunan']),
                        'realisasi_q1' => $cleanNumber($data['realisasi_q1']),
                        'realisasi_q2' => $cleanNumber($data['realisasi_q2']),
                        'realisasi_q3' => $cleanNumber($data['realisasi_q3']),
                        'realisasi_q4' => $cleanNumber($data['realisasi_q4']),
                    ]
                );
            }
        });

        return redirect()->route('admin.kinerja.index', ['tahun' => $validated['tahun']])
                         ->with('success', 'Data kinerja untuk tahun ' . $validated['tahun'] . ' berhasil disimpan.');
    }
}