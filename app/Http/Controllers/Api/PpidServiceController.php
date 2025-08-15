<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use App\Http\Resources\PermohonanInformasiResource;
use App\Http\Resources\PengajuanKeberatanResource;
use Illuminate\Validation\Rule;

class PpidServiceController extends Controller
{
    /**
     * Menampilkan riwayat permohonan informasi milik pengguna yang terotentikasi.
     */
    public function historyPermohonan(Request $request)
    {
        $permohonan = $request->user()->permohonanInformasi()
                                     ->latest('tanggal_permohonan')
                                     ->paginate(10);

        return PermohonanInformasiResource::collection($permohonan);
    }

    /**
     * Menampilkan riwayat pengajuan keberatan milik pengguna yang terotentikasi.
     */
    public function historyKeberatan(Request $request)
    {
        $keberatan = $request->user()->pengajuanKeberatan()
                                   ->latest('tanggal_pengajuan')
                                   ->paginate(10);

        return PengajuanKeberatanResource::collection($keberatan);
    }

    /**
     * Menyimpan permohonan informasi baru dari pengguna yang terotentikasi.
     */
    public function storePermohonan(Request $request)
    {
        $validated = $request->validate([
            'pekerjaan_pemohon' => 'nullable|string|max:255',
            'jenis_pemohon' => 'required|string|in:Perorangan,Badan Hukum,Kelompok Masyarakat',
            'rincian_informasi' => 'required|string|max:5000',
            'tujuan_penggunaan_informasi' => 'nullable|string|max:5000',
            'cara_mendapatkan_informasi' => 'required|string',
            'cara_mendapatkan_salinan' => 'nullable|string',
        ]);

        $permohonan = $request->user()->permohonanInformasi()->create([
            'jenis_pemohon' => $validated['jenis_pemohon'],
            'pekerjaan_pemohon' => $validated['pekerjaan_pemohon'],
            // 'identitas_pemohon' bisa ditambahkan jika API Anda mendukung file upload
            'rincian_informasi' => $validated['rincian_informasi'],
            'tujuan_penggunaan_informasi' => $validated['tujuan_penggunaan_informasi'],
            'cara_mendapatkan_informasi' => $validated['cara_mendapatkan_informasi'],
            'cara_mendapatkan_salinan' => $validated['cara_mendapatkan_salinan'],
            'status' => 'Menunggu Diproses',
        ]);

        // Catat aktivitas
        activity()
            ->causedBy($request->user())
            ->performedOn($permohonan)
            ->log('Mengajukan permohonan informasi baru melalui API');

        return response()->json([
            'message' => 'Permohonan informasi berhasil diajukan.',
            'data' => new PermohonanInformasiResource($permohonan),
        ], 201); // 201 Created
    }

        /**
     * Menyimpan pengajuan keberatan baru dari pengguna yang terotentikasi.
     */
    public function storeKeberatan(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nomor_registrasi_permohonan' => [
                'required',
                'string',
                'max:255',
                // Validasi canggih: pastikan nomor registrasi ini ada DAN milik pengguna yang sedang login
                Rule::exists('permohonan_informasi', 'nomor_registrasi')->where(function ($query) use ($user) {
                    return $query->where('user_id', $user->id);
                }),
            ],
            'jenis_keberatan' => 'required|string|in:Info Ditolak,Info Tidak Disediakan,Info Tidak Ditanggapi,Info Tidak Sesuai,Biaya Tidak Wajar,Info Terlambat',
            'alasan_keberatan' => 'required|string|max:5000',
            'kasus_posisi' => 'nullable|string|max:5000',
        ], [
            'nomor_registrasi_permohonan.exists' => 'Nomor registrasi permohonan tidak ditemukan atau bukan milik Anda.',
        ]);

        $keberatan = $user->pengajuanKeberatan()->create([
            'nomor_registrasi_permohonan' => $validated['nomor_registrasi_permohonan'],
            'jenis_keberatan' => $validated['jenis_keberatan'],
            'alasan_keberatan' => $validated['alasan_keberatan'],
            'kasus_posisi' => $validated['kasus_posisi'],
            'status' => 'Menunggu Diproses',
        ]);

        // Catat aktivitas
        activity()
            ->causedBy($user)
            ->performedOn($keberatan)
            ->log('Mengajukan keberatan informasi melalui API');

        return response()->json([
            'message' => 'Pengajuan keberatan berhasil diajukan.',
            'data' => new PengajuanKeberatanResource($keberatan),
        ], 201); // 201 Created
    }
}