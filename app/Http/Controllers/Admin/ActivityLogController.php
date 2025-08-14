<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Hanya super_admin yang bisa melihat log
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $activities = Activity::with(['causer', 'subject'])
                                ->latest()
                                ->paginate(20);

        return view('admin.activity-log.index', compact('activities'));
    }

        /**
     * Menghapus semua catatan log aktivitas.
     */
    public function clearLog()
    {
        // Pastikan hanya super_admin yang bisa menjalankan aksi ini
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        try {
            // Menghapus semua record dari tabel activity_log
            Activity::query()->delete();

            // Mencatat aksi pembersihan log itu sendiri
            activity()
                ->causedBy(auth()->user())
                ->log('Membersihkan semua log aktivitas');

            return redirect()->route('admin.activity-log.index')->with('success', 'Semua log aktivitas berhasil dibersihkan.');

        } catch (\Exception $e) {
            return redirect()->route('admin.activity-log.index')->with('error', 'Gagal membersihkan log aktivitas: ' . $e->getMessage());
        }
    }
}