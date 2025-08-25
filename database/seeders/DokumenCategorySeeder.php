<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DokumenCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dokumen_categories')->insert([
            [
                'id' => 1,
                'nama' => 'Regulasi',
                'slug' => 'regulasi',
                'deskripsi' => 'Peraturan dan kebijakan terkait ESDM.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
            [
                'id' => 2,
                'nama' => 'Dokumen Perencanaan',
                'slug' => 'dokumen-perencanaan',
                'deskripsi' => 'Rencana strategis dan kerja dinas.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
            [
                'id' => 3,
                'nama' => 'Laporan Keuangan',
                'slug' => 'laporan-keuangan',
                'deskripsi' => 'Laporan anggaran dan realisasi keuangan dinas.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
            [
                'id' => 4,
                'nama' => 'Laporan Kinerja',
                'slug' => 'laporan-kinerja',
                'deskripsi' => 'Laporan akuntabilitas dan capaian kinerja dinas.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
            [
                'id' => 5,
                'nama' => 'Materi Edukasi',
                'slug' => 'materi-edukasi',
                'deskripsi' => 'Materi sosialisasi dan edukasi untuk masyarakat.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
        ]);
    }
}