<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama untuk didefinisikan ulang
        Schema::dropIfExists('kinerja');

        // Buat ulang tabel kinerja dengan struktur baru
        Schema::create('kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_kinerja_id')->constrained('indikator_kinerja')->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('target_tahunan', 15, 2)->nullable();
            $table->decimal('realisasi_q1', 15, 2)->nullable();
            $table->decimal('realisasi_q2', 15, 2)->nullable();
            $table->decimal('realisasi_q3', 15, 2)->nullable();
            $table->decimal('realisasi_q4', 15, 2)->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'indikator_kinerja_id']);
        });
    }

    public function down(): void
    {
        // Logika rollback (opsional, bisa disesuaikan)
        Schema::dropIfExists('kinerja');
    }
};