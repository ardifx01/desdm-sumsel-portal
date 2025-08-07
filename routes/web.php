<?php

// Import Controllers yang digunakan
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\InformasiPublikController; // Frontend Info Publik
use App\Http\Controllers\LayananInformasiController;
use App\Http\Controllers\LaporanStatistikController;
use App\Http\Controllers\ProfilPpidController;
use App\Http\Controllers\DokumenController; // Frontend Dokumen
use App\Http\Controllers\BeritaController; // Frontend Berita
use App\Http\Controllers\GaleriController; // Frontend Galeri
use App\Http\Controllers\BidangSektoralController;
use App\Http\Controllers\LayananPengaduanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\KontakUmumController;
use App\Http\Controllers\HalamanStatisController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
// Controllers Admin (untuk backend)
use App\Http\Controllers\Admin\CategoryController; // CRUD Kategori Berita
use App\Http\Controllers\Admin\PostController; // CRUD Berita
use App\Http\Controllers\Admin\DokumenCategoryController; // CRUD Kategori Dokumen
use App\Http\Controllers\Admin\DocController; // CRUD Dokumen
use App\Http\Controllers\Admin\InformasiPublikCategoryController; // CRUD Kategori Info Publik
use App\Http\Controllers\Admin\InformasiPublikController as AdminInformasiPublikController; // CRUD Informasi Publik Item (NEW!)
use App\Http\Controllers\Admin\AlbumController; // CRUD Album Foto
use App\Http\Controllers\Admin\PhotoController; // CRUD Foto dalam Album
use App\Http\Controllers\Admin\VideoController; // CRUD Video
use App\Http\Controllers\Admin\PejabatController;
use App\Http\Controllers\Admin\PermohonanInformasiController; // <-- TAMBAHKAN BARIS INI
use App\Http\Controllers\Admin\PengajuanKeberatanController; // <-- TAMBAHKAN BARIS INI
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\SeksiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\WelcomeController;
// Controllers bawaan Laravel/Breeze
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



// Rute Halaman Beranda
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Rute Halaman Beranda


// --- Rute MODUL PUBLIK (Pastikan Urutan Ini) ---

// Modul Tentang Kami
Route::prefix('tentang-kami')->name('tentang-kami.')->group(function () {
    Route::get('/', [TentangKamiController::class, 'index'])->name('index');
    Route::get('/visi-misi', [TentangKamiController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [TentangKamiController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/tugas-fungsi', [TentangKamiController::class, 'tugasFungsi'])->name('tugas-fungsi');
    Route::get('/profil-pimpinan', [TentangKamiController::class, 'profilPimpinan'])->name('profil-pimpinan');
    Route::get('/profil-pimpinan/{id}', [TentangKamiController::class, 'detailPimpinan'])->name('detail-pimpinan');
});


// Modul Bidang & Data Sektoral
Route::prefix('bidang-sektoral')->name('bidang-sektoral.')->group(function () {
    Route::get('/', [BidangSektoralController::class, 'index'])->name('index');
    Route::get('/data-statistik', [BidangSektoralController::class, 'showDataStatistik'])->name('data-statistik');
    Route::get('/{slug}', [BidangSektoralController::class, 'show'])->name('show'); // <--- BARIS INI
});

// Modul Layanan & Pengaduan
Route::prefix('layanan-pengaduan')->name('layanan-pengaduan.')->group(function () {
    Route::get('/', [LayananPengaduanController::class, 'index'])->name('index');
    Route::get('/pengaduan', [LayananPengaduanController::class, 'showPengaduan'])->name('pengaduan');
    Route::get('/faq-umum', [LayananPengaduanController::class, 'showFaqUmum'])->name('faq-umum');
    Route::get('/daftar-layanan', [LayananPengaduanController::class, 'showDaftarLayanan'])->name('daftar-layanan');
    // Route::get('/cek-status', [LayananPengaduanController::class, 'showCekStatus'])->name('cek-status');

    // Route GET untuk menampilkan form Cek Status (sudah ada, kita pakai ini)
    Route::get('/cek-status', [LayananPengaduanController::class, 'showCekStatus'])->name('cek-status');

    // TAMBAHKAN ROUTE POST INI UNTUK MEMPROSES FORM
    Route::post('/cek-status', [LayananPengaduanController::class, 'processCekStatus'])->name('cek-status.process');
});

// Modul Publikasi & Dokumen Resmi
Route::prefix('publikasi')->name('publikasi.')->group(function () {
    Route::get('/', [DokumenController::class, 'index'])->name('index');
    Route::get('/{slug}', [DokumenController::class, 'show'])->name('show');
});

// Modul Berita & Media
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [BeritaController::class, 'show'])->name('show');
});
// Rute untuk Komentar
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{comment}/verify', [CommentController::class, 'verifyEmail'])->name('comments.verify-email');
// Modul Galeri (Sisi Publik)
Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/album/{slug}', [GaleriController::class, 'showAlbum'])->name('album');
    Route::get('/video/{slug}', [GaleriController::class, 'showVideo'])->name('video');
});

// Modul Informasi Publik (PPID)
// Pastikan rute spesifik (profil-ppid, permohonan, keberatan, laporan-statistik, kontak)
// berada DI ATAS rute generik '/{slug}' di dalam grup ini.
Route::prefix('informasi-publik')->name('informasi-publik.')->group(function () {

    // Rute Profil PPID
    Route::prefix('profil-ppid')->name('profil-ppid.')->group(function () {
        Route::get('/', [ProfilPpidController::class, 'index'])->name('index');
        Route::get('/visi-misi-maklumat', [ProfilPpidController::class, 'visiMisiMaklumat'])->name('visi-misi-maklumat');
        Route::get('/struktur-organisasi', [ProfilPpidController::class, 'strukturOrganisasiPpid'])->name('struktur-organisasi');
        Route::get('/dasar-hukum', [ProfilPpidController::class, 'dasarHukumPpid'])->name('dasar-hukum');
        Route::get('/tugas-fungsi', [ProfilPpidController::class, 'tugasFungsiPpid'])->name('tugas-fungsi');
    });

    // Rute untuk Laporan & Statistik PPID
    Route::get('/laporan-statistik', [LaporanStatistikController::class, 'index'])->name('laporan-statistik');

    // Rute Prosedur Pelayanan Informasi (Permohonan)
    Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/prosedur', [LayananInformasiController::class, 'showProsedurPermohonan'])->name('prosedur');
        Route::get('/form', [LayananInformasiController::class, 'showFormPermohonan'])->name('form');
        Route::post('/store', [LayananInformasiController::class, 'storePermohonan'])->name('store');
        Route::get('/sukses', [LayananInformasiController::class, 'showPermohonanSukses'])->name('sukses');
    });

    // Rute Prosedur Pelayanan Informasi (Keberatan)
    Route::prefix('keberatan')->name('keberatan.')->group(function () {
        Route::get('/prosedur', [LayananInformasiController::class, 'showProsedurKeberatan'])->name('prosedur');
        Route::get('/form', [LayananInformasiController::class, 'showFormKeberatan'])->name('form');
        Route::post('/store', [LayananInformasiController::class, 'storeKeberatan'])->name('store');
        Route::get('/sukses', [LayananInformasiController::class, 'showKeberatanSukses'])->name('sukses');
    });

    // Rute Kontak PPID
    Route::get('/kontak', [ProfilPpidController::class, 'kontakPpid'])->name('kontak-ppid');

    // Rute Daftar Informasi Publik (DIP) - khusus index
    Route::get('/', [InformasiPublikController::class, 'index'])->name('index');

    // Rute paling umum dengan {slug} untuk detail informasi publik (HARUS DI PALING BAWAH)
    Route::get('/{slug}', [InformasiPublikController::class, 'show'])->name('show');
});


// Modul Kontak Umum
Route::prefix('kontak')->name('kontak.')->group(function () {
    Route::get('/', [KontakUmumController::class, 'index'])->name('index');
    Route::post('/send-mail', [KontakUmumController::class, 'sendMail'])->name('send-mail');
    Route::get('/sukses', [KontakUmumController::class, 'showSukses'])->name('sukses');
});

// Modul Halaman Statis Footer (Lain-Lain)
Route::prefix('halaman-statis')->name('static-pages.')->group(function () {
    Route::get('/peta-situs', [HalamanStatisController::class, 'showPetaSitus'])->name('peta-situs');
    Route::get('/{slug}', [HalamanStatisController::class, 'show'])->name('show');
});

// Tambahkan di bagian rute publik
Route::get('/search', [SearchController::class, 'index'])->name('search');

// --- Rute AUTENTIKASI BREEZE (Tetap di bagian paling bawah) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute ADMIN / BACKEND (CRUD) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin Utama
        Route::get('/', function () { return view('admin.dashboard'); })->name('dashboard');

        // CRUD halaman statis
        Route::resource('static-pages', StaticPageController::class);

        // CRUD Kategori Berita
        Route::resource('categories', CategoryController::class);

        // CRUD Berita
        Route::resource('posts', PostController::class);

        // CRUD Kategori Dokumen
        Route::resource('dokumen-categories', DokumenCategoryController::class)->parameters([
            'dokumen-categories' => 'category_dokumen',
        ]);

        // CRUD Dokumen
        Route::resource('dokumen', DocController::class)->parameters([
            'dokumen' => 'dokuman',
        ]);

        // CRUD Kategori Informasi Publik
        Route::resource('informasi-publik-categories', InformasiPublikCategoryController::class)->parameters([
            'informasi-publik-categories' => 'informasi_publik_category',
        ]);

        // CRUD Informasi Publik (Item)
        Route::resource('informasi-publik', AdminInformasiPublikController::class)->parameters([ // <-- TAMBAHKAN BARIS INI
            'informasi-publik' => 'informasi_publik_item',
        ]);

        // CRUD Album Foto
        Route::resource('albums', AlbumController::class);

        // CRUD Foto dalam Album (Nested Resource)
        Route::resource('albums.photos', PhotoController::class)->parameters([
            'photos' => 'photo',
        ]);

        // CRUD Video
        Route::resource('videos', VideoController::class);

        // CRUD Pejabat Dinas
        Route::resource('pejabat', PejabatController::class); // <-- TAMBAHKAN BARIS INI

        // CRUD Permohonan Informasi
        Route::resource('permohonan', PermohonanInformasiController::class)->only(['index', 'show', 'update', 'destroy'])->parameters([
            'permohonan' => 'permohonan_item', // Mengubah nama parameter
        ]); // <-- TAMBAHKAN BARIS INI

        // CRUD Pengajuan Keberatan
        Route::resource('keberatan', PengajuanKeberatanController::class)->only(['index', 'show', 'update', 'destroy'])->parameters([
            'keberatan' => 'keberatan_item', // Mengubah nama parameter
        ]); // <-- TAMBAHKAN BARIS INI

        // =========================================================================
            // RUTE BARU: PENGELOLAAN BIDANG (BACKEND ADMIN)
            // =========================================================================
            // URL-nya menjadi /admin/bidang karena prefix 'admin' sudah ada di atasnya
            Route::resource('bidang', BidangController::class)->names([ // <--- CUKUP "bidang"
                'index' => 'bidang.index', // <--- CUKUP "bidang.index"
                'create' => 'bidang.create',
                'store' => 'bidang.store',
                'edit' => 'bidang.edit',
                'update' => 'bidang.update',
                'destroy' => 'bidang.destroy',
                'show' => 'bidang.show_preview',
            ]);

            // =========================================================================
            // RUTE BARU: PENGELOLAAN SEKSI (BACKEND ADMIN)
            // =========================================================================
            // URL-nya menjadi /admin/bidang/{bidang}/seksi
            Route::resource('bidang/{bidang}/seksi', SeksiController::class)->names([ // <--- CUKUP "bidang/{bidang}/seksi"
                'index' => 'bidang.seksi.index', // <--- CUKUP "bidang.seksi.index"
                'create' => 'bidang.seksi.create',
                'store' => 'bidang.seksi.store',
                'edit' => 'bidang.seksi.edit',
                'update' => 'bidang.seksi.update',
                'destroy' => 'bidang.seksi.destroy',
                'show' => 'bidang.seksi.show_preview',
            ]);

        // ... di dalam grup rute admin
        Route::get('comments', [CommentsController::class, 'index'])->name('comments.index');
        Route::patch('comments/{comment}/approve', [CommentsController::class, 'approve'])->name('comments.approve');
        Route::patch('comments/{comment}/reject', [CommentsController::class, 'reject'])->name('comments.reject');
        Route::delete('comments/{comment}', [CommentsController::class, 'destroy'])->name('comments.destroy');
        Route::get('comments/{comment}', [CommentsController::class, 'show'])->name('comments.show');
        Route::post('comments/reply', [CommentsController::class, 'reply'])->name('comments.reply');

        // Rute untuk Pengaturan Umum Web
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});


require __DIR__.'/auth.php'; // Memasukkan rute autentikasi dari auth.php