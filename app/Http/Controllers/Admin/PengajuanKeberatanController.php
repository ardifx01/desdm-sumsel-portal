<?php

namespace App\Http\Controllers\Admin;

use App\Models\PengajuanKeberatan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PengajuanKeberatanController extends Controller
{
    private $statuses = ['Menunggu Diproses', 'Diproses', 'Diterima', 'Ditolak', 'Selesai'];

    public function index(Request $request)
    {
        Gate::authorize('viewAny', PengajuanKeberatan::class);

        $statuses = $this->statuses;
        $query = PengajuanKeberatan::with('user')->orderBy('tanggal_pengajuan', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('nomor_registrasi_permohonan', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $keberatan = $query->paginate(10);

        return view('admin.keberatan.index', compact('keberatan', 'statuses'));
    }

    public function show($id)
    {
        $pengajuan_keberatan = PengajuanKeberatan::with('user')->findOrFail($id);
        Gate::authorize('view', $pengajuan_keberatan);

        $statuses = $this->statuses;
        return view('admin.keberatan.show', compact('pengajuan_keberatan', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan_keberatan = PengajuanKeberatan::findOrFail($id);
        Gate::authorize('update', $pengajuan_keberatan);

        $request->validate([
            'status' => 'required|in:' . implode(',', $this->statuses),
            'catatan_admin' => 'nullable|string',
        ]);

        $pengajuan_keberatan->update($request->only('status', 'catatan_admin'));

        return redirect()->route('admin.keberatan.show', ['keberatan_item' => $pengajuan_keberatan->id])->with('success', 'Status pengajuan keberatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengajuan_keberatan = PengajuanKeberatan::findOrFail($id);
        Gate::authorize('delete', $pengajuan_keberatan);

        $pengajuan_keberatan->delete();
        return redirect()->route('admin.keberatan.index')->with('success', 'Pengajuan keberatan berhasil dihapus!');
    }
}