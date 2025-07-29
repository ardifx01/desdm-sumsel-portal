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
        Schema::create('seksis', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke tabel 'bidangs'
            $table->foreignId('bidang_id')
                  ->constrained('bidangs') // Nama tabel bidangs
                  ->onDelete('cascade'); // Jika bidang dihapus, semua seksi di dalamnya ikut terhapus

            $table->string('nama_seksi'); // Nama seksi/sub bagian
            $table->longText('tugas')->nullable(); // Tugas seksi (HTML)
            $table->integer('urutan')->default(0); // Urutan tampilan

            // Foreign Key untuk kepala seksi
            // Pastikan tabel 'pejabat' sudah ada dan terjalankan migrasinya
            $table->foreignId('pejabat_kepala_id')
                  ->nullable()
                  ->constrained('pejabat') // Nama tabel pejabat
                  ->onDelete('set null'); // Jika pejabat dihapus, FK menjadi null

            $table->boolean('is_active')->default(true); // Status aktif/nonaktif

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seksis');
    }
};