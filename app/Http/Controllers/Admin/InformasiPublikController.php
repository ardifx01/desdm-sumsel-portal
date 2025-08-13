<?php

namespace App\Http\Controllers\Admin;

use App\Models\InformasiPublik;
use App\Models\InformasiPublikCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class InformasiPublikController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', InformasiPublik::class);
        $categories = InformasiPublikCategory::orderBy('nama')->get();
        $query = InformasiPublik::with('category')->orderBy('tanggal_publikasi', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('judul', 'like', '%' . $search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', (int)$request->category_id);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $informasiPublik = $query->paginate(10);
        return view('admin.informasi-publik.index', compact('informasiPublik', 'categories'));
    }

    public function create()
    {
        Gate::authorize('create', InformasiPublik::class);
        $categories = InformasiPublikCategory::orderBy('nama')->get();
        return view('admin.informasi-publik.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', InformasiPublik::class);

        $request->validate([
            'judul' => 'required|string|max:255|unique:informasi_publik,judul',
            'category_id' => 'required|exists:informasi_publik_categories,id',
            'konten' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $filePath = null;
        $fileNama = null;
        $fileTipe = null;
        $thumbnailPath = null;

        if ($request->hasFile('file_dokumen')) {
            $uploadedFile = $request->file('file_dokumen');
            $folderRelativePath = 'informasi_publik/dokumen';
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        if ($request->hasFile('thumbnail')) {
            $uploadedThumbnail = $request->file('thumbnail');
            $folderRelativePath = 'informasi_publik/thumbnails';
            $thumbnailPath = $uploadedThumbnail->store($folderRelativePath, 'public');
        }

        $informasiPublik = InformasiPublik::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        // PERUBAHAN DI SINI
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Item "' . $informasiPublik->judul . '" berhasil ditambahkan!');
    }

    public function edit(InformasiPublik $informasi_publik_item)
    {
        Gate::authorize('update', $informasi_publik_item);
        $categories = InformasiPublikCategory::orderBy('nama')->get();
        return view('admin.informasi-publik.edit', compact('informasi_publik_item', 'categories'));
    }

    public function update(Request $request, InformasiPublik $informasi_publik_item)
    {
        Gate::authorize('update', $informasi_publik_item);

        $request->validate([
            'judul' => 'required|string|max:255|unique:informasi_publik,judul,' . $informasi_publik_item->id,
            'category_id' => 'required|exists:informasi_publik_categories,id',
            'konten' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tanggal_publikasi' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $filePath = $informasi_publik_item->file_path;
        $fileNama = $informasi_publik_item->file_nama;
        $fileTipe = $informasi_publik_item->file_tipe;
        $thumbnailPath = $informasi_publik_item->thumbnail;

        if ($request->hasFile('file_dokumen')) {
            if ($informasi_publik_item->file_path && Storage::disk('public')->exists($informasi_publik_item->file_path)) {
                Storage::disk('public')->delete($informasi_publik_item->file_path);
            }
            $uploadedFile = $request->file('file_dokumen');
            $folderRelativePath = 'informasi_publik/dokumen';
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            $fileNama = $uploadedFile->getClientOriginalName();
            $fileTipe = $uploadedFile->getClientMimeType();
        }

        if ($request->hasFile('thumbnail')) {
            if ($informasi_publik_item->thumbnail && Storage::disk('public')->exists($informasi_publik_item->thumbnail)) {
                Storage::disk('public')->delete($informasi_publik_item->thumbnail);
            }
            $uploadedThumbnail = $request->file('thumbnail');
            $folderRelativePath = 'informasi_publik/thumbnails';
            $thumbnailPath = $uploadedThumbnail->store($folderRelativePath, 'public');
        }

        $informasi_publik_item->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'file_path' => $filePath,
            'file_nama' => $fileNama,
            'file_tipe' => $fileTipe,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'is_active' => $request->boolean('is_active'),
        ]);

        // PERUBAHAN DI SINI
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Item "' . $informasi_publik_item->judul . '" berhasil diperbarui!');
    }

    public function destroy(InformasiPublik $informasi_publik_item)
    {
        Gate::authorize('delete', $informasi_publik_item);

        if ($informasi_publik_item->file_path && Storage::disk('public')->exists($informasi_publik_item->file_path)) {
            Storage::disk('public')->delete($informasi_publik_item->file_path);
        }
        if ($informasi_publik_item->thumbnail && Storage::disk('public')->exists($informasi_publik_item->thumbnail)) {
            Storage::disk('public')->delete($informasi_publik_item->thumbnail);
        }

        $judulItem = $informasi_publik_item->judul; // Simpan nama sebelum dihapus
        $informasi_publik_item->delete();

        // PERUBAHAN DI SINI
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Item "' . $judulItem . '" berhasil dihapus!');
    }
}