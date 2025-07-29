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
        Schema::create('dokumen_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Nama kategori (Regulasi, Laporan Kinerja, dll.)
            $table->string('slug')->unique(); // Slug untuk URL yang ramah SEO
            $table->text('deskripsi')->nullable(); // Deskripsi kategori
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_categories');
    }
};