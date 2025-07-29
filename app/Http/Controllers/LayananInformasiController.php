<?php

namespace App\Http\Controllers;

use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload file

class LayananInformasiController extends Controller
{
    // --- Permohonan Informasi ---

    public function showProsedurPermohonan()
    {
        return view('informasi-publik.prosedur-permohonan');
    }

    public function showFormPermohonan()
    {
        return view('informasi-publik.form-permohonan');
    }

    public function storePermohonan(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'email_pemohon' => 'required|email|max:255',
            'telp_pemohon' => 'nullable|string|max:20',
            'alamat_pemohon' => 'required|string',
            'pekerjaan_pemohon' => 'nullable|string|max:255',
            'identitas_pemohon' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
            'jenis_pemohon' => 'required|string|in:Perorangan,Badan Hukum,Kelompok Masyarakat',
            'tujuan_penggunaan_informasi' => 'nullable|string',
            'rincian_informasi' => 'required|string',
            'cara_mendapatkan_informasi' => 'required|string|in:Melihat,Membaca,Mendengar,Mendapatkan Salinan Softcopy,Mendapatkan Salinan Hardcopy',
            'cara_mendapatkan_salinan' => 'nullable|string|in:Mengambil Langsung,Pos,Email,Fax',
            'g-recaptcha-response' => 'sometimes|recaptcha', // Opsional: jika Anda akan menambahkan reCAPTCHA
        ], [
            'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
            'email_pemohon.required' => 'Email pemohon wajib diisi.',
            'email_pemohon.email' => 'Format email tidak valid.',
            'alamat_pemohon.required' => 'Alamat pemohon wajib diisi.',
            'identitas_pemohon.file' => 'File identitas harus berupa file.',
            'identitas_pemohon.mimes' => 'File identitas harus format JPG, PNG, atau PDF.',
            'identitas_pemohon.max' => 'Ukuran file identitas maksimal 2MB.',
            'jenis_pemohon.required' => 'Jenis pemohon wajib dipilih.',
            'rincian_informasi.required' => 'Rincian informasi wajib diisi.',
            'cara_mendapatkan_informasi.required' => 'Cara mendapatkan informasi wajib dipilih.',
            'g-recaptcha-response.recaptcha' => 'Verifikasi reCAPTCHA gagal, silakan coba lagi.',
        ]);

        $identitasPath = null;
        if ($request->hasFile('identitas_pemohon')) {
            $identitasPath = $request->file('identitas_pemohon')->store('public/identitas_pemohon');
            $identitasPath = str_replace('public/', '', $identitasPath); // Hapus 'public/' dari path
        }

        PermohonanInformasi::create([
            'nama_pemohon' => $request->nama_pemohon,
            'email_pemohon' => $request->email_pemohon,
            'telp_pemohon' => $request->telp_pemohon,
            'alamat_pemohon' => $request->alamat_pemohon,
            'pekerjaan_pemohon' => $request->pekerjaan_pemohon,
            'identitas_pemohon' => $identitasPath,
            'jenis_pemohon' => $request->jenis_pemohon,
            'tujuan_penggunaan_informasi' => $request->tujuan_penggunaan_informasi,
            'rincian_informasi' => $request->rincian_informasi,
            'cara_mendapatkan_informasi' => $request->cara_mendapatkan_informasi,
            'cara_mendapatkan_salinan' => $request->cara_mendapatkan_salinan,
            'tanggal_permohonan' => now(),
            'status' => 'Menunggu Diproses', // Status awal
        ]);

        return redirect()->route('informasi-publik.permohonan.sukses')->with('success', 'Permohonan informasi Anda telah berhasil diajukan. Nomor registrasi Anda: ' . PermohonanInformasi::latest()->first()->nomor_registrasi);
    }

    public function showPermohonanSukses()
    {
        return view('informasi-publik.permohonan-sukses');
    }

    // --- Pengajuan Keberatan ---

    public function showProsedurKeberatan()
    {
        return view('informasi-publik.prosedur-keberatan');
    }

    public function showFormKeberatan()
    {
        return view('informasi-publik.form-keberatan');
    }

    public function storeKeberatan(Request $request)
    {
        $request->validate([
            'nomor_registrasi_permohonan' => 'required|string|max:255',
            'nama_pemohon' => 'required|string|max:255',
            'email_pemohon' => 'required|email|max:255',
            'telp_pemohon' => 'nullable|string|max:20',
            'alamat_pemohon' => 'required|string',
            'alasan_keberatan' => 'required|string',
            'jenis_keberatan' => 'required|string|in:Info Ditolak,Info Tidak Disediakan,Info Tidak Ditanggapi,Info Tidak Sesuai,Biaya Tidak Wajar,Info Terlambat',
            'kasus_posisi' => 'nullable|string',
            'identitas_pemohon' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
            'g-recaptcha-response' => 'sometimes|recaptcha', // Opsional: jika Anda akan menambahkan reCAPTCHA
        ], [
            'nomor_registrasi_permohonan.required' => 'Nomor registrasi permohonan wajib diisi.',
            'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
            'email_pemohon.required' => 'Email pemohon wajib diisi.',
            'email_pemohon.email' => 'Format email tidak valid.',
            'alamat_pemohon.required' => 'Alamat pemohon wajib diisi.',
            'alasan_keberatan.required' => 'Alasan keberatan wajib diisi.',
            'jenis_keberatan.required' => 'Jenis keberatan wajib dipilih.',
            'identitas_pemohon.file' => 'File identitas harus berupa file.',
            'identitas_pemohon.mimes' => 'File identitas harus format JPG, PNG, atau PDF.',
            'identitas_pemohon.max' => 'Ukuran file identitas maksimal 2MB.',
            'g-recaptcha-response.recaptcha' => 'Verifikasi reCAPTCHA gagal, silakan coba lagi.',
        ]);

        $identitasPath = null;
        if ($request->hasFile('identitas_pemohon')) {
            $identitasPath = $request->file('identitas_pemohon')->store('public/identitas_pemohon_keberatan');
            $identitasPath = str_replace('public/', '', $identitasPath); // Hapus 'public/' dari path
        }

        PengajuanKeberatan::create([
            'nomor_registrasi_permohonan' => $request->nomor_registrasi_permohonan,
            'nama_pemohon' => $request->nama_pemohon,
            'email_pemohon' => $request->email_pemohon,
            'telp_pemohon' => $request->telp_pemohon,
            'alamat_pemohon' => $request->alamat_pemohon,
            'alasan_keberatan' => $request->alasan_keberatan,
            'jenis_keberatan' => $request->jenis_keberatan,
            'kasus_posisi' => $request->kasus_posisi,
            'identitas_pemohon' => $identitasPath,
            'tanggal_pengajuan' => now(),
            'status' => 'Menunggu Diproses', // Status awal
        ]);

        return redirect()->route('informasi-publik.keberatan.sukses')->with('success', 'Pengajuan keberatan Anda telah berhasil diajukan.');
    }

    public function showKeberatanSukses()
    {
        return view('informasi-publik.keberatan-sukses');
    }
}