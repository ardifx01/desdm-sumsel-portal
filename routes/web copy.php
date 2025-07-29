<?php

// Import Controllers yang digunakan
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\LayananInformasiController;
use App\Http\Controllers\LaporanStatistikController;
use App\Http\Controllers\ProfilPpidController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BidangSektoralController;
use App\Http\Controllers\LayananPengaduanController;
use App\Http\Controllers\KontakUmumController;
use App\Http\Controllers\HalamanStatisController;

// Controllers bawaan Laravel/Breeze
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Beranda
Route::get('/', function () {
    return view('welcome');
});

// --- Rute MODUL PUBLIK (Harap Perhatikan Urutan Ini) ---

// Modul Tentang Kami
Route::prefix('tentang-kami')->name('tentang-kami.')->group(function () {
    Route::get('/', [TentangKamiController::class, 'index'])->name('index');
    Route::get('/visi-misi', [TentangKamiController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [TentangKamiController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/tugas-fungsi', [TentangKamiController::class, 'tugasFungsi'])->name('tugas-fungsi');
    Route::get('/profil-pimpinan', [TentangKamiController::class, 'profilPimpinan'])->name('profil-pimpinan');
    Route::get('/profil-pimpinan/{id}', [TentangKamiController::class, 'detailPimpinan'])->name('detail-pimpinan');
});

// Modul Bidang & Data Sektoral (Versi Statis)
// Pastikan grup ini DI ATAS group Informasi Publik jika InformasPublik memiliki wildcard {slug} di level rootnya
Route::prefix('bidang-sektoral')->name('bidang-sektoral.')->group(function () {
    Route::get('/', [BidangSektoralController::class, 'index'])->name('index');
    Route::get('/data-statistik', [BidangSektoralController::class, 'showDataStatistik'])->name('data-statistik');
    Route::get('/{slug}', [BidangSektoralController::class, 'show'])->name('show'); // Pastikan ini di paling bawah dalam grup ini
});

// Modul Layanan & Pengaduan
Route::prefix('layanan-pengaduan')->name('layanan-pengaduan.')->group(function () {
    Route::get('/', [LayananPengaduanController::class, 'index'])->name('index');
    Route::get('/pengaduan', [LayananPengaduanController::class, 'showPengaduan'])->name('pengaduan');
    Route::get('/faq-umum', [LayananPengaduanController::class, 'showFaqUmum'])->name('faq-umum');
    Route::get('/daftar-layanan', [LayananPengaduanController::class, 'showDaftarLayanan'])->name('daftar-layanan');
    Route::get('/cek-status', [LayananPengaduanController::class, 'showCekStatus'])->name('cek-status');
});

// Modul Publikasi & Dokumen Resmi
Route::prefix('publikasi')->name('publikasi.')->group(function () {
    Route::get('/', [DokumenController::class, 'index'])->name('index');
    Route::get('/{slug}', [DokumenController::class, 'show'])->name('show'); // Pastikan ini di paling bawah dalam grup ini
});

// Modul Berita & Media
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [BeritaController::class, 'show'])->name('show'); // Pastikan ini di paling bawah dalam grup ini
});

// Modul Galeri
Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/album/{slug}', [GaleriController::class, 'showAlbum'])->name('album');
    Route::get('/video/{slug}', [GaleriController::class, 'showVideo'])->name('video');
});

// Modul Informasi Publik (PPID)
// Sangat penting agar rute-rute spesifik (seperti profil-ppid, permohonan, keberatan, laporan-statistik, kontak)
// berada DI ATAS rute generik '/{slug}' di dalam grup ini.
Route::prefix('informasi-publik')->name('informasi-publik.')->group(function () {

    // Rute Profil PPID (Paling spesifik dalam group PPID)
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
    Route::get('/', [InformasiPublikController::class, 'index'])->name('index'); // Ini adalah informasi-publik/

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
    Route::get('/kebijakan-privasi', [HalamanStatisController::class, 'showKebijakanPrivasi'])->name('kebijakan-privasi');
    Route::get('/disclaimer', [HalamanStatisController::class, 'showDisclaimer'])->name('disclaimer');
    Route::get('/aksesibilitas', [HalamanStatisController::class, 'showAksesibilitas'])->name('aksesibilitas');
});

// --- Rute AUTENTIKASI BREEZE (Tetap di bagian paling bawah) ---
// Ini adalah bagian rute autentikasi yang dibuat oleh Laravel Breeze.
// Penting agar tidak bentrok dengan rute spesifik Anda di atas.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; // Memasukkan rute autentikasi dari auth.php