<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SasaranStrategis;
use Illuminate\Http\Request;

class KinerjaApiController extends Controller
{
    /**
     * Menyediakan data capaian kinerja dalam format JSON untuk tahun tertentu.
     */
    public function getData(Request $request)
    {
        // Validasi bahwa parameter 'tahun' wajib ada dan berupa 4 digit angka
        $validated = $request->validate([
            'tahun' => 'required|integer|digits:4',
        ], [
            'tahun.required' => 'Parameter "tahun" wajib diisi.',
            'tahun.integer' => 'Parameter "tahun" harus berupa angka.',
            'tahun.digits' => 'Parameter "tahun" harus berupa 4 digit angka.',
        ]);

        $tahun = $validated['tahun'];

        // Ambil data dari database
        $data = SasaranStrategis::with([
            'indikatorKinerja' => function ($query) {
                $query->orderBy('urutan');
            },
            'indikatorKinerja.kinerja' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            }
        ])->orderBy('urutan')->get();

        // Transformasi data menjadi format JSON yang bersih dan mudah digunakan
        $transformedData = $data->map(function ($sasaran) {
            return [
                'sasaran_strategis' => $sasaran->sasaran,
                'indikator' => $sasaran->indikatorKinerja->map(function ($indikator) {
                    $kinerja = $indikator->kinerja->first();
                    return [
                        'nama_indikator' => $indikator->nama_indikator,
                        'satuan' => $indikator->satuan,
                        'target_tahunan' => (float) ($kinerja->target_tahunan ?? 0),
                        'realisasi_q1' => (float) ($kinerja->realisasi_q1 ?? 0),
                        'realisasi_q2' => (float) ($kinerja->realisasi_q2 ?? 0),
                        'realisasi_q3' => (float) ($kinerja->realisasi_q3 ?? 0),
                        'realisasi_q4' => (float) ($kinerja->realisasi_q4 ?? 0),
                        'total_realisasi' => (float) ($kinerja->total_realisasi ?? 0),
                        'persentase_capaian' => (float) number_format($kinerja->persentase_capaian ?? 0, 2, '.', ''),
                    ];
                })
            ];
        });

        return response()->json($transformedData);
    }
}