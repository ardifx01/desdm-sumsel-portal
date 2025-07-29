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
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            // Mengubah tipe kolom dari string menjadi text
            $table->text('tujuan_penggunaan_informasi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            // Mengembalikan tipe kolom dari text menjadi string (jika diperlukan untuk rollback)
            // Catatan: Mengembalikan ke string bisa menyebabkan kehilangan data jika ada data yang sudah melebihi 255 karakter
            $table->string('tujuan_penggunaan_informasi', 255)->nullable()->change();
        });
    }
};
