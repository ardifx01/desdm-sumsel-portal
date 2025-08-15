<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\AlbumController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rute Publik (tidak memerlukan otentikasi)
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk Berita (bisa diakses publik)
Route::get('/berita', [PostController::class, 'index']);
Route::get('/berita/{post:slug}', [PostController::class, 'show']); // Menggunakan slug untuk URL yang lebih baik

// Rute untuk Dokumen (BARU)
Route::get('/dokumen', [DokumenController::class, 'index']);
Route::get('/dokumen/{dokuman:slug}', [DokumenController::class, 'show']); // 'dokuman' sesuai parameter di controller

// Rute untuk Galeri (BARU)
Route::get('/album', [AlbumController::class, 'index']);
Route::get('/album/{album:slug}', [AlbumController::class, 'show']);

// Rute yang Dilindungi (memerlukan token otentikasi yang valid)
Route::middleware('auth:sanctum')->group(function () {
    
    // Rute untuk mendapatkan detail pengguna yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- Di sinilah kita akan menambahkan rute API lainnya nanti ---
    // Contoh: Route::get('/berita', [Api\BeritaController::class, 'index']);
});