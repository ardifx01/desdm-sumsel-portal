<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermohonanInformasi;
use App\Models\PengajuanKeberatan;
use Illuminate\Support\Facades\Gate; // <-- Tambahkan ini

class UserDashboardController extends Controller
{
    /**
     * Menampilkan dasbor untuk pengguna publik (role 'user').
     */
    public function index()
    {
        $user = Auth::user();

        $permohonan = PermohonanInformasi::where('user_id', $user->id)
            ->orderBy('tanggal_permohonan', 'desc')
            ->paginate(5, ['*'], 'permohonan_page');

        $keberatan = PengajuanKeberatan::where('user_id', $user->id)
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(5, ['*'], 'keberatan_page');

        return view('user-dashboard.index', compact('user', 'permohonan', 'keberatan'));
    }

    /**
     * Menampilkan detail lengkap dari satu permohonan informasi.
     */
    public function showPermohonan(PermohonanInformasi $permohonan)
    {
        // Pastikan pengguna hanya bisa melihat permohonannya sendiri
        if (Gate::denies('view', $permohonan)) {
            abort(403);
        }

        return view('user-dashboard.permohonan-show', compact('permohonan'));
    }

    /**
     * Menampilkan detail lengkap dari satu pengajuan keberatan.
     */
    public function showKeberatan(PengajuanKeberatan $keberatan)
    {
        // Pastikan pengguna hanya bisa melihat keberatannya sendiri
        if (Gate::denies('view', $keberatan)) {
            abort(403);
        }

        return view('user-dashboard.keberatan-show', compact('keberatan'));
    }
}