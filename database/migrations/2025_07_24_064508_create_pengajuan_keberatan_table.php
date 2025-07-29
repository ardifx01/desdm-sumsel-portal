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
        Schema::create('pengajuan_keberatan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi_permohonan'); // Nomor registrasi permohonan informasi yang diajukan keberatan
            $table->string('nama_pemohon');
            $table->string('email_pemohon');
            $table->string('telp_pemohon')->nullable();
            $table->string('alamat_pemohon');
            $table->text('alasan_keberatan'); // Alasan pengajuan keberatan
            $table->string('jenis_keberatan'); // Info Ditolak, Info Tidak Disediakan, Info Tidak Ditanggapi, Info Tidak Sesuai, Biaya Tidak Wajar, Info Terlambat
            $table->text('kasus_posisi')->nullable(); // Penjelasan singkat kasus posisi/kronologi
            $table->string('identitas_pemohon')->nullable(); // Path file KTP/Identitas
            $table->string('status')->default('Menunggu Diproses'); // Menunggu Diproses, Diproses, Diterima, Ditolak, Selesai
            $table->text('catatan_admin')->nullable(); // Catatan dari admin/PPID
            $table->timestamp('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_keberatan');
    }
};