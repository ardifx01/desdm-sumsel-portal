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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('dokumen_categories')->onDelete('cascade'); // Foreign key ke kategori
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('deskripsi')->nullable(); // Deskripsi dokumen
            $table->string('file_path'); // Path file dokumen
            $table->string('file_nama'); // Nama asli file
            $table->string('file_tipe')->nullable(); // Tipe file (pdf, docx, dll)
            $table->timestamp('tanggal_publikasi')->nullable(); // Tanggal dokumen dipublikasi
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
        Schema::dropIfExists('dokumen');
    }
};