<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom 'telp' dan 'alamat' ke tabel 'users'.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'telp' setelah kolom 'email'
            // Kolom ini bisa kosong (nullable)
            $table->string('telp')->nullable()->after('email');

            // Menambahkan kolom 'alamat' setelah kolom 'telp'
            // Kolom ini bisa kosong (nullable) dan bertipe TEXT untuk menampung alamat panjang
            $table->text('alamat')->nullable()->after('telp');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom 'telp' dan 'alamat' jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Pastikan untuk menghapus dalam urutan terbalik atau secara bersamaan
            $table->dropColumn(['telp', 'alamat']);
        });
    }
};