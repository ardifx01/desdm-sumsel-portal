<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dokumen;
use App\Models\DokumenCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate; // <-- Pastikan ini ada

class DocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Dokumen::class);

        $categories = DokumenCategory::orderBy('nama')->get();
        $query = Dokumen::with('category')->orderBy('tanggal_publikasi', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('judul', 'like', '%' . $search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', (int)$request->category_id);
        }
        if ($request->filled('status_aktif')) {
            $isActive = filter_var($request->status_aktif, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
        }

        $dokumen = $query->paginate(10);

        return view('admin.dokumen.index', compact('dokumen', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Dokumen::class);
        $categories = DokumenCategory::orderBy('nama')->get();
        return view('admin.dokumen.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Dokumen::class);

        $request->validate([
            'judul' => 'required|string|max:255|unique:dokumen,judul',
            'category_id' => 'required|exists:dokumen_categories,id',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $filePath = null;
        $fileNama = null;
        $fileTipe = null;

        if ($request->hasFile('file_dokumen')) {
            $uploadedFile = $request->file('file_dokumen');
            $folderRelativePath = 'dokumen';
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        Dokumen::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokuman)
    {
        Gate::authorize('update', $dokuman);
        $categories = DokumenCategory::orderBy('nama')->get();
        return view('admin.dokumen.edit', compact('dokuman', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokumen $dokuman)
    {
        Gate::authorize('update', $dokuman);

        $request->validate([
            'judul' => 'required|string|max:255|unique:dokumen,judul,' . $dokuman->id,
            'category_id' => 'required|exists:dokumen_categories,id',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $filePath = $dokuman->file_path;
        $fileNama = $dokuman->file_nama;
        $fileTipe = $dokuman->file_tipe;

        if ($request->hasFile('file_dokumen')) {
            if ($dokuman->file_path && Storage::disk('public')->exists($dokuman->file_path)) {
                Storage::disk('public')->delete($dokuman->file_path);
            }
            $uploadedFile = $request->file('file_dokumen');
            $folderRelativePath = 'dokumen';
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        $dokuman->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokuman)
    {
        Gate::authorize('delete', $dokuman);

        if ($dokuman->file_path && Storage::disk('public')->exists($dokuman->file_path)) {
            Storage::disk('public')->delete($dokuman->file_path);
        }
        $dokuman->delete();
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}