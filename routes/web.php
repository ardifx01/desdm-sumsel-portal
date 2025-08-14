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
use App\Http\Controllers\Admin\PermohonanInformasiController;
use App\Http\Controllers\Admin\PengajuanKeberatanController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\SeksiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController; // Admin Dashboard
use App\Http\Controllers\UserDashboardController; // User Dashboard
use App\Http\Controllers\Admin\ActivityLogController;

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

// --- Rute MODUL PUBLIK ---

// Modul Tentang Kami
Route::prefix('tentang-kami')->name('tentang-kami.')->group(function () {
    Route::get('/', [TentangKamiController::class, 'index'])->name('index');
    Route::get('/visi-misi', [TentangKamiController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [TentangKamiController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/tugas-fungsi', [TentangKamiController::class, 'tugasFungsi'])->name('tugas-fungsi');
    Route::get('/profil-pimpinan', [TentangKamiController::class, 'profilPimpinan'])->name('profil-pimpinan');
    Route::get('/profil-pimpinan/{id}', [TentangKamiController::class, 'detailPimpinan'])->name('detail-pimpinan');
});

// Rute Modal Pejabat
Route::get('/pejabat-modal/{pejabat}', [TentangKamiController::class, 'showModal'])->name('pejabat.showModal');

// Modul Bidang & Data Sektoral
Route::prefix('bidang-sektoral')->name('bidang-sektoral.')->group(function () {
    Route::get('/', [BidangSektoralController::class, 'index'])->name('index');
    Route::get('/data-statistik', [BidangSektoralController::class, 'showDataStatistik'])->name('data-statistik');
    Route::get('/{slug}', [BidangSektoralController::class, 'show'])->name('show');
});

// Modul Layanan & Pengaduan
Route::prefix('layanan-pengaduan')->name('layanan-pengaduan.')->group(function () {
    Route::get('/', [LayananPengaduanController::class, 'index'])->name('index');
    Route::get('/pengaduan', [LayananPengaduanController::class, 'showPengaduan'])->name('pengaduan');
    Route::get('/faq-umum', [LayananPengaduanController::class, 'showFaqUmum'])->name('faq-umum');
    Route::get('/daftar-layanan', [LayananPengaduanController::class, 'showDaftarLayanan'])->name('daftar-layanan');
    Route::get('/cek-status', [LayananPengaduanController::class, 'showCekStatus'])->name('cek-status');
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
    Route::post('/{post}/share-count', [BeritaController::class, 'incrementShareCount'])->name('share.count');
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
        
        // Rute yang dilindungi: hanya untuk pengguna yang sudah login
        Route::get('/form', [LayananInformasiController::class, 'showFormPermohonan'])->middleware('auth')->name('form');
        Route::post('/store', [LayananInformasiController::class, 'storePermohonan'])->middleware('auth')->name('store');
        
        Route::get('/sukses', [LayananInformasiController::class, 'showPermohonanSukses'])->name('sukses');
    });

    // Rute Prosedur Pelayanan Informasi (Keberatan)
    Route::prefix('keberatan')->name('keberatan.')->group(function () {
        Route::get('/prosedur', [LayananInformasiController::class, 'showProsedurKeberatan'])->name('prosedur');

        // Rute yang dilindungi: hanya untuk pengguna yang sudah login
        Route::get('/form', [LayananInformasiController::class, 'showFormKeberatan'])->middleware('auth')->name('form');
        Route::post('/store', [LayananInformasiController::class, 'storeKeberatan'])->middleware('auth')->name('store');

        Route::get('/sukses', [LayananInformasiController::class, 'showKeberatanSukses'])->name('sukses');
    });

    // Rute Kontak PPID
    Route::get('/kontak', [ProfilPpidController::class, 'kontakPpid'])->name('kontak-ppid');

    // Rute Daftar Informasi Publik (DIP) - khusus index
    Route::get('/', [InformasiPublikController::class, 'index'])->name('index');
    Route::get('/laporan-statistik', [InformasiPublikController::class, 'laporanStatistik'])->name('laporan-statistik');
    
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

// --- Rute AUTENTIKASI BREEZE ---

// Rute Dashboard Cerdas (Mengarah ke Admin atau User Dashboard)
Route::get('/dashboard', function () {
    // Periksa peran pengguna yang sedang login
    if (in_array(auth()->user()->role, ['super_admin', 'ppid_admin', 'editor'])) {
        // Jika peran adalah salah satu dari admin, panggil controller dasbor admin
        return app(DashboardController::class)->index();
    } else {
        // Jika tidak (misalnya peran 'user'), panggil controller dasbor pengguna publik
        return app(UserDashboardController::class)->index();
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // Rute Profil Pengguna (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // RUTE BARU untuk edit profil publik
    Route::get('/profil-saya', [ProfileController::class, 'editPublic'])->name('profile.edit.public');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTE BARU UNTUK DASBOR PENGGUNA ---
    Route::get('/dasbor/permohonan/{permohonan}', [UserDashboardController::class, 'showPermohonan'])
        ->name('user-dashboard.permohonan.show');
        
    Route::get('/dasbor/keberatan/{keberatan}', [UserDashboardController::class, 'showKeberatan'])
        ->name('user-dashboard.keberatan.show');

    // --- Rute ADMIN / BACKEND (CRUD) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin Utama (Jika diperlukan, tapi sudah ditangani oleh rute /dashboard di atas)
        // Route::get('/', function () { return view('admin.dashboard'); })->name('dashboard');

        // Rute untuk manajemen pengguna yang dilindungi oleh middleware 'can:manage-users'
        Route::middleware('can:manage-users')->group(function () {
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::get('users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('users', [UserController::class, 'store'])->name('users.store');
            Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::patch('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        // CRUD halaman statis
        Route::resource('static-pages', StaticPageController::class);

        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
        Route::delete('activity-log/clear', [ActivityLogController::class, 'clearLog'])->name('activity-log.clear');
        
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
        Route::resource('informasi-publik', AdminInformasiPublikController::class)->parameters([
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
        Route::resource('pejabat', PejabatController::class);

        // CRUD Permohonan Informasi
        Route::resource('permohonan', PermohonanInformasiController::class)->only(['index', 'show', 'update', 'destroy'])->parameters([
            'permohonan' => 'permohonan_item',
        ]);

        // CRUD Pengajuan Keberatan
        Route::resource('keberatan', PengajuanKeberatanController::class)->only(['index', 'show', 'update', 'destroy'])->parameters([
            'keberatan' => 'keberatan_item',
        ]);

        // =========================================================================
        // RUTE BARU: PENGELOLAAN BIDANG (BACKEND ADMIN)
        // =========================================================================
        Route::resource('bidang', BidangController::class)->names([
            'index' => 'bidang.index',
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
        Route::resource('bidang/{bidang}/seksi', SeksiController::class)->names([
            'index' => 'bidang.seksi.index',
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
        Route::post('settings/reset-counter', [SettingController::class, 'resetCounter'])->name('settings.reset-counter');
    });
});

require __DIR__.'/auth.php'; // Memasukkan rute autentikasi dari auth.php