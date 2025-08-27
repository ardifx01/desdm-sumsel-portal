<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $indexes = [
        'posts' => ['name' => 'posts_title_excerpt_content_html_fulltext', 'columns' => ['title', 'excerpt', 'content_html']],
        'dokumen' => ['name' => 'dokumen_judul_deskripsi_fulltext', 'columns' => ['judul', 'deskripsi']],
        'informasi_publik' => ['name' => 'informasi_publik_judul_konten_fulltext', 'columns' => ['judul', 'konten']],
        'pejabat' => ['name' => 'pejabat_nama_jabatan_fulltext', 'columns' => ['nama', 'jabatan']],
        'bidangs' => ['name' => 'bidangs_nama_tupoksi_fulltext', 'columns' => ['nama', 'tupoksi']],
        'seksis' => ['name' => 'seksi_nama_seksi_tugas_fulltext', 'columns' => ['nama_seksi', 'tugas']],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $details) {
            if (Schema::hasIndex($table, $details['name'])) {
                Schema::table($table, function (Blueprint $table) use ($details) {
                    $table->dropFullText($details['name']);
                });
            }
            Schema::table($table, function (Blueprint $table) use ($details) {
                $table->fullText($details['columns'], $details['name']);
            });
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $details) {
            if (Schema::hasIndex($table, $details['name'])) {
                Schema::table($table, function (Blueprint $table) use ($details) {
                    $table->dropFullText($details['name']);
                });
            }
        }
    }
};