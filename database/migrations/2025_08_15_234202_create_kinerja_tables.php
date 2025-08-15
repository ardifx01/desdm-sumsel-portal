<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel 1: Master untuk Indikator Kinerja
        Schema::create('indikator_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sasaran_strategis_id')->constrained('sasaran_strategis')->onDelete('cascade');
            $table->string('nama_indikator');
            $table->string('satuan');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Tabel 2: Data transaksional untuk Target & Realisasi
        Schema::create('kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_kinerja_id')->constrained('indikator_kinerja')->onDelete('cascade');
            $table->year('tahun');
            $table->enum('triwulan', ['1', '2', '3', '4']);
            $table->decimal('target', 15, 2)->nullable();
            $table->decimal('realisasi', 15, 2)->nullable();
            $table->timestamps();

            // Mencegah duplikasi data untuk indikator yang sama pada periode yang sama
            $table->unique(['tahun', 'triwulan', 'indikator_kinerja_id'], 'kinerja_periode_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja');
        Schema::dropIfExists('indikator_kinerja');
    }
};