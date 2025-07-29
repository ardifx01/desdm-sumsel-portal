<?php

namespace App\Http\Controllers\Admin; // Namespace yang benar

use App\Models\Post;
use App\Models\Category; // Untuk memilih kategori
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Base Controller
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI KEMBALI
use Illuminate\Support\Facades\Log; // Untuk logging

class PostController extends Controller // Nama kelas adalah PostController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Log::info('Halaman manajemen berita diakses.');
        Log::warning('Testing warning log entry.');
        $categories = Category::ofTypePost()->orderBy('name')->get();

        $query = Post::with('category', 'author');

        // Implementasi Filter dan Pencarian
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('content_html', 'like', '%' . $search . '%');
            });
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Memulai proses store Post. Request data: ' . json_encode($request->all()));
        Log::info('PHP $_FILES data: ' . json_encode($_FILES));

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content_html' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB, hanya gambar
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $uploadedFile = $request->file('featured_image');

            Log::info('File gambar terdeteksi oleh Laravel: ' . $uploadedFile->getClientOriginalName());
            Log::info('Path temporer: ' . $uploadedFile->getRealPath());
            Log::info('Test temp file existence (before copy): ' . (file_exists($uploadedFile->getRealPath()) ? 'YA' : 'TIDAK'));
            if (file_exists($uploadedFile->getRealPath())) {
                $tempContent = file_get_contents($uploadedFile->getRealPath());
                Log::info('Test temp file content length: ' . strlen($tempContent) . ' bytes (should match ' . $uploadedFile->getSize() . ')');
                // Opsional: Log beberapa byte pertama untuk konfirmasi
                // Log::info('Test temp file first 20 bytes: ' . substr($tempContent, 0, 20));
            } else {
                Log::error('ERROR: File temporer TIDAK ADA di ' . $uploadedFile->getRealPath() . ' sebelum operasi copy!');
            }            
            Log::info('Ukuran: ' . $uploadedFile->getSize());
            Log::info('Error Upload: ' . $uploadedFile->getError());

            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                Log::error('Upload file PHP error: ' . $uploadedFile->getError() . ' - ' . $this->getPhpUploadErrorMessage($uploadedFile->getError()));
                return back()->withInput()->withErrors(['featured_image' => 'Upload file gagal dengan kode error PHP: ' . $uploadedFile->getError()]);
            }

            try {
                $year = date('Y');
                $month = date('m');
                $folderRelativePath = 'images/posts/' . $year . '/' . $month;
                $uploadDir = storage_path('app/public/' . $folderRelativePath); // Path absolut ke folder tujuan
                $fileName = Str::random(40) . '.' . $uploadedFile->getClientOriginalExtension(); // Nama unik
                $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName; // Path lengkap file akhir

                Log::info('Mencoba menyimpan ke folder: ' . $uploadDir);
                Log::info('Nama file akhir: ' . $fileName);
                Log::info('Jalur file akhir absolut: ' . $targetPath);

                // Buat folder jika belum ada
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                    Log::info('Folder tujuan dibuat: ' . $uploadDir);
                }

                // --- MENGGUNAKAN COPY DAN UNLINK SECARA EKSPLISIT ---
                Log::info('Copy: Memulai operasi copy dari ' . $uploadedFile->getRealPath() . ' ke ' . $targetPath);
                $copySuccess = copy($uploadedFile->getRealPath(), $targetPath);
                Log::info('Copy: Hasil operasi copy: ' . ($copySuccess ? 'BERHASIL' : 'GAGAL'));
                Log::info('Copy: Apakah file tujuan ada setelah copy? ' . (file_exists($targetPath) ? 'YA' : 'TIDAK'));

                if ($copySuccess) {
                    Log::info('Unlink: Memulai operasi unlink temporer: ' . $uploadedFile->getRealPath());
                    $unlinkSuccess = unlink($uploadedFile->getRealPath());
                    Log::info('Unlink: Hasil operasi unlink: ' . ($unlinkSuccess ? 'BERHASIL' : 'GAGAL'));
                    Log::info('Unlink: Apakah file temporer ada setelah unlink? ' . (file_exists($uploadedFile->getRealPath()) ? 'YA' : 'TIDAK'));

                    if ($unlinkSuccess) {
                        $imagePath = $folderRelativePath . '/' . $fileName;
                        Log::info('Gambar berhasil di-*copy* dan diproses: ' . $imagePath);
                    } else {
                        throw new \Exception('File berhasil di-copy, tapi gagal menghapus file temporer: ' . $uploadedFile->getRealPath());
                    }
                } else {
                    // Jika copy gagal
                    $error = error_get_last();
                    throw new \Exception('Gagal meng-copy file dari folder temporer: ' . $uploadedFile->getRealPath() . ' ke ' . $targetPath . ' | Pesan PHP: ' . ($error ? $error['message'] : 'Tidak ada pesan error PHP'));
                }

            } catch (\Exception $e) {
                Log::error('Gagal menyimpan gambar (try-catch): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
                return back()->withInput()->withErrors(['featured_image' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
            }
        } else {
            Log::warning('Tidak ada file gambar yang diunggah atau deteksi file gagal.');
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_OK) {
                Log::error('PHP Upload Error Code: ' . $_FILES['featured_image']['error'] . ' - ' . $this->getPhpUploadErrorMessage($_FILES['featured_image']['error']));
                return back()->withInput()->withErrors(['featured_image' => 'Upload file PHP error: ' . $this->getPhpUploadErrorMessage($_FILES['featured_image']['error'])]);
            }
        }

        // Logika otomatisasi meta_title
        $metaTitle = $request->meta_title ?: $request->title;
        // Jika Anda ingin meta_description juga otomatis dari excerpt jika kosong:
        $metaDescription = $request->meta_description ?: Str::limit(strip_tags($request->excerpt ?: $request->content_html), 160);

        Post::create([
            'title' => $request->title,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'featured_image_url' => $imagePath, // Path gambar
            'category_id' => $request->category_id,
            'author_id' => auth()->id(),
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::ofTypePost()->orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content_html' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $imagePath = $post->featured_image_url; // Default ke gambar lama
        if ($request->hasFile('featured_image') && $_FILES['featured_image']['error'] == 0) {
            // ... (hapus gambar lama) ...

            $uploadedFile = $request->file('featured_image');
            Log::info('UPDATE: File gambar terdeteksi oleh Laravel: ' . $uploadedFile->getClientOriginalName());
            Log::info('UPDATE: Path temporer: ' . $uploadedFile->getRealPath());
            Log::info('Test temp file existence (before copy): ' . (file_exists($uploadedFile->getRealPath()) ? 'YA' : 'TIDAK'));
            if (file_exists($uploadedFile->getRealPath())) {
                $tempContent = file_get_contents($uploadedFile->getRealPath());
                Log::info('Test temp file content length: ' . strlen($tempContent) . ' bytes (should match ' . $uploadedFile->getSize() . ')');
                // Opsional: Log beberapa byte pertama untuk konfirmasi
                // Log::info('Test temp file first 20 bytes: ' . substr($tempContent, 0, 20));
            } else {
                Log::error('ERROR: File temporer TIDAK ADA di ' . $uploadedFile->getRealPath() . ' sebelum operasi copy!');
            }            
            Log::info('UPDATE: Ukuran: ' . $uploadedFile->getSize());
            Log::info('UPDATE: Error Upload: ' . $uploadedFile->getError());

            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                Log::error('UPDATE: Upload file PHP error: ' . $uploadedFile->getError() . ' - ' . $this->getPhpUploadErrorMessage($uploadedFile->getError()));
                return back()->withInput()->withErrors(['featured_image' => 'UPDATE: Upload file gagal dengan kode error PHP: ' . $uploadedFile->getError()]);
            }

            try {
                $year = date('Y');
                $month = date('m');
                $folderRelativePath = 'images/posts/' . $year . '/' . $month;
                $uploadDir = storage_path('app/public/' . $folderRelativePath); // Path absolut
                $fileName = Str::random(40) . '.' . $uploadedFile->getClientOriginalExtension();
                $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

                Log::info('UPDATE: Mencoba menyimpan ke folder: ' . $uploadDir);
                Log::info('UPDATE: Nama file akhir: ' . $fileName);
                Log::info('UPDATE: Jalur file akhir absolut: ' . $targetPath);

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                    Log::info('UPDATE: Folder tujuan dibuat: ' . $uploadDir);
                }

                // --- MENGGUNAKAN COPY DAN UNLINK SECARA EKSPLISIT ---
                Log::info('UPDATE: Copy: Memulai operasi copy dari ' . $uploadedFile->getRealPath() . ' ke ' . $targetPath);
                $copySuccess = copy($uploadedFile->getRealPath(), $targetPath);
                Log::info('UPDATE: Copy: Hasil operasi copy: ' . ($copySuccess ? 'BERHASIL' : 'GAGAL'));
                Log::info('UPDATE: Copy: Apakah file tujuan ada setelah copy? ' . (file_exists($targetPath) ? 'YA' : 'TIDAK'));

                if ($copySuccess) {
                    Log::info('UPDATE: Unlink: Memulai operasi unlink temporer: ' . $uploadedFile->getRealPath());
                    $unlinkSuccess = unlink($uploadedFile->getRealPath());
                    Log::info('UPDATE: Unlink: Hasil operasi unlink: ' . ($unlinkSuccess ? 'BERHASIL' : 'GAGAL'));
                    Log::info('UPDATE: Unlink: Apakah file temporer ada setelah unlink? ' . (file_exists($uploadedFile->getRealPath()) ? 'YA' : 'TIDAK'));

                    if ($unlinkSuccess) {
                        $imagePath = $folderRelativePath . '/' . $fileName;
                        Log::info('UPDATE: Gambar berhasil di-*copy* dan diproses: ' . $imagePath);
                    } else {
                        throw new \Exception('UPDATE: File berhasil di-copy, tapi gagal menghapus file temporer: ' . $uploadedFile->getRealPath());
                    }
                } else {
                    // Jika copy gagal
                    $error = error_get_last();
                    throw new \Exception('UPDATE: Gagal meng-copy file dari folder temporer: ' . $uploadedFile->getRealPath() . ' ke ' . $targetPath . ' | Pesan PHP: ' . ($error ? $error['message'] : 'Tidak ada pesan error PHP'));
                }

            } catch (\Exception $e) {
                Log::error('UPDATE: Gagal menyimpan gambar (try-catch): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
                return back()->withInput()->withErrors(['featured_image' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
            }
        } else {
            Log::warning('UPDATE: Tidak ada file gambar yang diunggah atau deteksi file gagal.');
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_OK) {
                Log::error('UPDATE: PHP Upload Error Code: ' . $_FILES['featured_image']['error'] . ' - ' . $this->getPhpUploadErrorMessage($_FILES['featured_image']['error']));
                return back()->withInput()->withErrors(['featured_image' => 'UPDATE: Upload file PHP error: ' . $this->getPhpUploadErrorMessage($_FILES['featured_image']['error'])]);
            }
        }

        // Logika otomatisasi meta_title
        $metaTitle = $request->meta_title ?: $request->title;
        // Jika Anda ingin meta_description juga otomatis dari excerpt jika kosong:
        $metaDescription = $request->meta_description ?: Str::limit(strip_tags($request->excerpt ?: $request->content_html), 160);

        $post->update([
            'title' => $request->title,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content_html' => $request->content_html,
            'featured_image_url' => $imagePath,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar terkait jika ada
        if ($post->featured_image_url && Storage::disk('public')->exists($post->featured_image_url)) {
            Storage::disk('public')->delete($post->featured_image_url);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus!');
    }

    // --- Tambahkan helper function untuk pesan error upload PHP ---
    private function getPhpUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "Ukuran file melebihi batas upload_max_filesize di php.ini.";
            case UPLOAD_ERR_FORM_SIZE:
                return "Ukuran file melebihi batas MAX_FILE_SIZE di formulir HTML.";
            case UPLOAD_ERR_PARTIAL:
                return "File hanya terupload sebagian.";
            case UPLOAD_ERR_NO_FILE:
                return "Tidak ada file yang terupload.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Folder sementara tidak ditemukan.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Gagal menulis file ke disk.";
            case UPLOAD_ERR_EXTENSION:
                return "Upload dihentikan oleh ekstensi PHP.";
            default:
                return "Kesalahan upload tidak diketahui.";
        }
    }
}