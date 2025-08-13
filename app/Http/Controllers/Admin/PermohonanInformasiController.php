<?php

namespace App\Http\Controllers\Admin;

use App\Models\PermohonanInformasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PermohonanInformasiController extends Controller
{
    private $statuses = ['Menunggu Diproses', 'Diproses', 'Diterima', 'Ditolak', 'Selesai'];

    public function index(Request $request)
    {
        Gate::authorize('viewAny', PermohonanInformasi::class);
        
        $statuses = $this->statuses;
        $query = PermohonanInformasi::with('user')->orderBy('tanggal_permohonan', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('nomor_registrasi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permohonan = $query->paginate(10);

        return view('admin.permohonan.index', compact('permohonan', 'statuses'));
    }

    public function show($id)
    {
        $permohonan_informasi = PermohonanInformasi::with('user')->findOrFail($id);
        Gate::authorize('view', $permohonan_informasi);
        
        $statuses = $this->statuses;
        return view('admin.permohonan.show', compact('permohonan_informasi', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $permohonan_informasi = PermohonanInformasi::findOrFail($id);
        Gate::authorize('update', $permohonan_informasi);

        $request->validate([
            'status' => 'required|in:' . implode(',', $this->statuses),
            'catatan_admin' => 'nullable|string',
        ]);

        $permohonan_informasi->update($request->only('status', 'catatan_admin'));

        return redirect()->route('admin.permohonan.show', ['permohonan_item' => $permohonan_informasi->id])->with('success', 'Status permohonan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $permohonan_informasi = PermohonanInformasi::findOrFail($id);
        Gate::authorize('delete', $permohonan_informasi);

        if ($permohonan_informasi->identitas_pemohon && Storage::disk('public')->exists($permohonan_informasi->identitas_pemohon)) {
            Storage::disk('public')->delete($permohonan_informasi->identitas_pemohon);
        }

        $permohonan_informasi->delete();
        return redirect()->route('admin.permohonan.index')->with('success', 'Permohonan berhasil dihapus!');
    }
}