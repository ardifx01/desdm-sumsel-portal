<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Untuk mengirim email
use App\Mail\KontakDinasMail; // Import Mailable class Anda

class KontakUmumController extends Controller
{
    public function index()
    {
        // Halaman utama Kontak Umum
        return view('kontak-umum.index');
    }

    public function sendMail(Request $request)
    {
        // Validasi input formulir
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'email_pengirim' => 'required|email|max:255',
            'telp_pengirim' => 'nullable|string|max:20',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
            'g-recaptcha-response' => 'sometimes|recaptcha', // Opsional: jika Anda akan menambahkan reCAPTCHA
        ], [
            'nama_pengirim.required' => 'Nama wajib diisi.',
            'email_pengirim.required' => 'Email wajib diisi.',
            'email_pengirim.email' => 'Format email tidak valid.',
            'subjek.required' => 'Subjek wajib diisi.',
            'pesan.required' => 'Pesan wajib diisi.',
            'g-recaptcha-response.recaptcha' => 'Verifikasi reCAPTCHA gagal, silakan coba lagi.',
        ]);

        // Data yang akan dikirim ke email
        $data = [
            'nama_pengirim' => $request->nama_pengirim,
            'email_pengirim' => $request->email_pengirim,
            'telp_pengirim' => $request->telp_pengirim,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
        ];

        // Alamat email tujuan (email admin dinas)
        $adminEmail = 'desdm.sumselprov@gmail.com'; // <-- GANTI DENGAN ALAMAT EMAIL TUJUAN SEBENARNYA

        try {
            // Kirim email
            Mail::to($adminEmail)->send(new KontakDinasMail($data));

            return redirect()->route('kontak.sukses')->with('success', 'Pesan Anda telah berhasil terkirim. Terima kasih!');
        } catch (\Exception $e) {
            // Tangani jika ada error saat pengiriman email
            return back()->withInput()->withErrors(['email_gagal' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.']);
        }
    }

    public function showSukses()
    {
        return view('kontak-umum.sukses');
    }
}