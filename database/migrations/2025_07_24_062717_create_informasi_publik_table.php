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
        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('informasi_publik_categories')->onDelete('cascade'); // Foreign key ke kategori
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten'); // Konten informasi (bisa HTML)
            $table->string('file_path')->nullable(); // Path file yang bisa diunduh
            $table->string('file_nama')->nullable(); // Nama asli file
            $table->string('file_tipe')->nullable(); // Tipe file (pdf, docx, dll)
            $table->string('thumbnail')->nullable(); // Gambar thumbnail untuk informasi
            $table->timestamp('tanggal_publikasi')->nullable(); // Tanggal informasi dipublikasi
            $table->integer('hits')->default(0); // Jumlah kali diakses/unduh
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_publik');
    }
};