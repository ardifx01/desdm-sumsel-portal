<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->string('jenis_pemohon')->after('user_id');
            $table->string('pekerjaan_pemohon')->nullable()->after('jenis_pemohon');
            $table->string('identitas_pemohon')->nullable()->after('pekerjaan_pemohon');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->dropColumn(['jenis_pemohon', 'pekerjaan_pemohon', 'identitas_pemohon']);
        });
    }
};