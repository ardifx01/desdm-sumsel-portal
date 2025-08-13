<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk Permohonan Informasi
        Schema::create('permohonan_informasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Wajib diisi
            $table->string('nomor_registrasi')->unique();
            
            // Kolom spesifik untuk permohonan
            $table->text('rincian_informasi');
            $table->text('tujuan_penggunaan_informasi')->nullable();
            $table->string('cara_mendapatkan_informasi');
            $table->string('cara_mendapatkan_salinan')->nullable();
            
            // Kolom untuk manajemen admin
            $table->string('status')->default('Menunggu Diproses');
            $table->text('catatan_admin')->nullable();
            
            $table->timestamp('tanggal_permohonan');
            $table->timestamps();
        });

        // Tabel untuk Pengajuan Keberatan
        Schema::create('pengajuan_keberatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Wajib diisi
            $table->string('nomor_registrasi_permohonan');
            
            // Kolom spesifik untuk keberatan
            $table->text('alasan_keberatan');
            $table->string('jenis_keberatan');
            $table->text('kasus_posisi')->nullable();
            
            // Kolom untuk manajemen admin
            $table->string('status')->default('Menunggu Diproses');
            $table->text('catatan_admin')->nullable();
            
            $table->timestamp('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_keberatan');
        Schema::dropIfExists('permohonan_informasi');
    }
};