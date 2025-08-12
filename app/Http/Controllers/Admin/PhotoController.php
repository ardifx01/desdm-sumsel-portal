<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PhotoController extends Controller
{
    // ... (method index, create, edit, destroy tidak berubah) ...
    public function index(Album $album)
    {
        Gate::authorize('view', $album);
        $photos = $album->photos()->orderBy('created_at', 'desc')->paginate(12);
        return view('admin.photos.index', compact('photos', 'album'));
    }

    public function create(Album $album)
    {
        Gate::authorize('update', $album);
        return view('admin.photos.create', compact('album'));
    }

    public function store(Request $request, Album $album)
    {
        Gate::authorize('update', $album);

        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('photos')) {
            $optimizerChain = OptimizerChainFactory::create();

            foreach ($request->file('photos') as $uploadedFile) {
                $folderRelativePath = 'photos/' . date('Y') . '/' . date('m');
                $filePath = $uploadedFile->store($folderRelativePath, 'public');
                
                // --- PERBAIKAN UNTUK MENGHILANGKAN ERROR IDE ---
                $absolutePath = storage_path('app/public/' . $filePath);
                $optimizerChain->optimize($absolutePath);
                // -------------------------------------------

                $fileNameOriginal = $uploadedFile->getClientOriginalName();

                $album->photos()->create([
                    'judul' => pathinfo($fileNameOriginal, PATHINFO_FILENAME),
                    'deskripsi' => null,
                    'file_path' => $filePath,
                    'file_name' => $fileNameOriginal,
                    'is_active' => $request->boolean('is_active'),
                ]);
            }
        }

        return redirect()->route('admin.albums.photos.index', $album)->with('success', 'Foto-foto berhasil diunggah dan dioptimalkan!');
    }

    public function edit(Album $album, Photo $photo)
    {
        Gate::authorize('update', $album);
        if ($photo->album_id !== $album->id) {
            abort(404);
        }
        return view('admin.photos.edit', compact('album', 'photo'));
    }

    public function update(Request $request, Album $album, Photo $photo)
    {
        Gate::authorize('update', $album);
        if ($photo->album_id !== $album->id) {
            abort(404);
        }

        $request->validate([
            'file_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $filePath = $photo->file_path;
        $fileNameOriginal = $photo->file_name;
        if ($request->hasFile('file_photo')) {
            if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
            $uploadedFile = $request->file('file_photo');
            $folderRelativePath = 'photos/' . date('Y') . '/' . date('m');
            $filePath = $uploadedFile->store($folderRelativePath, 'public');
            
            // --- PERBAIKAN UNTUK MENGHILANGKAN ERROR IDE ---
            $absolutePath = storage_path('app/public/' . $filePath);
            OptimizerChainFactory::create()->optimize($absolutePath);
            // -------------------------------------------

            $fileNameOriginal = $uploadedFile->getClientOriginalName();
        }

        $photo->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_name' => $fileNameOriginal,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.albums.photos.index', $album)->with('success', 'Detail foto berhasil diperbarui!');
    }

    public function destroy(Album $album, Photo $photo)
    {
        Gate::authorize('update', $album);
        if ($photo->album_id !== $album->id) {
            abort(404);
        }

        if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }
        $photo->delete();

        return redirect()->route('admin.albums.photos.index', $album)->with('success', 'Foto berhasil dihapus!');
    }
}