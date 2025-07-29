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
        Schema::create('pejabat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('nip')->nullable(); // NIP bisa kosong
            $table->text('deskripsi_singkat')->nullable(); // Deskripsi singkat tentang pejabat
            $table->string('foto')->nullable(); // Nama file foto
            $table->integer('urutan')->default(0); // Untuk mengurutkan pejabat
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pejabat');
    }
};