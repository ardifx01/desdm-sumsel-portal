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
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Nama bidang/UPTD/cabang dinas, harus unik
            $table->string('slug')->unique(); // Slug untuk URL, harus unik

            // Kolom 'tipe' dengan enum yang disepakati
            $table->enum('tipe', ['bidang', 'UPTD', 'cabang_dinas']);

            $table->longText('tupoksi')->nullable(); // Konten Tugas Pokok & Fungsi (HTML)

            // Foreign Key untuk kepala bidang/UPTD/cabang dinas
            // Pastikan tabel 'pejabat' sudah ada dan terjalankan migrasinya
            $table->foreignId('pejabat_kepala_id')
                  ->nullable()
                  ->constrained('pejabat') // Nama tabel pejabat
                  ->onDelete('set null'); // Jika pejabat dihapus, FK menjadi null

            $table->text('wilayah_kerja')->nullable(); // Wilayah kerja (khusus cabang dinas)
            $table->text('alamat')->nullable(); // Alamat (khusus cabang dinas atau UPTD)
            $table->longText('map')->nullable(); // Embed code peta (khusus cabang dinas atau UPTD)
            $table->longText('grafik_kinerja')->nullable(); // Embed code grafik

            $table->boolean('is_active')->default(true); // Status aktif/nonaktif

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};