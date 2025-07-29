<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonan_informasi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi')->unique(); // Nomor registrasi permohonan (misal: PI/DESDM/2024/0001)
            $table->string('nama_pemohon');
            $table->string('email_pemohon');
            $table->string('telp_pemohon')->nullable();
            $table->string('alamat_pemohon');
            $table->string('pekerjaan_pemohon')->nullable();
            $table->string('identitas_pemohon')->nullable(); // Path file KTP/Identitas
            $table->string('jenis_pemohon')->nullable(); // Perorangan, Badan Hukum, Kelompok Masyarakat
            $table->string('tujuan_penggunaan_informasi')->nullable(); // Tujuan penggunaan informasi
            $table->text('rincian_informasi'); // Rincian informasi yang dibutuhkan
            $table->string('cara_mendapatkan_informasi'); // Melihat, Membaca, Mendengar, Mendapatkan Salinan (Softcopy/Hardcopy)
            $table->string('cara_mendapatkan_salinan')->nullable(); // Mengambil Langsung, Pos, Email, Fax
            $table->string('status')->default('Menunggu Diproses'); // Menunggu Diproses, Diproses, Diterima, Ditolak, Selesai
            $table->text('catatan_admin')->nullable(); // Catatan dari admin/PPID
            $table->timestamp('tanggal_permohonan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_informasi');
    }
};