<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pastikan DB diimpor

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membersihkan tabel categories agar khusus untuk 'post'.
     */
    public function up(): void
    {
        // Langkah 1: Hapus semua baris yang tipenya BUKAN 'post'
        // Ini akan menghapus kategori 'Peraturan', 'Laporan Tahunan', dll.
        DB::table('categories')->where('type', '!=', 'post')->delete();

        // Langkah 2: Hapus kolom 'type' karena sudah tidak diperlukan lagi
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     * Mengembalikan struktur dan data (jika memungkinkan).
     */
    public function down(): void
    {
        // Langkah 1: Tambahkan kembali kolom 'type'
        Schema::table('categories', function (Blueprint $table) {
            $table->string('type')->default('post')->after('slug');
        });

        // Catatan: Data kategori 'document' yang dihapus tidak bisa dikembalikan
        // secara otomatis. Ini adalah operasi yang destruktif.
    }
};