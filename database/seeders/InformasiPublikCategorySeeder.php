<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InformasiPublikCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('informasi_publik_categories')->insert([
            [
                'id' => 1,
                'nama' => 'Informasi Berkala',
                'slug' => 'informasi-berkala',
                'deskripsi' => 'Informasi yang wajib diumumkan secara berkala, minimal 6 bulan sekali.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
            [
                'id' => 2,
                'nama' => 'Informasi Serta Merta',
                'slug' => 'informasi-serta-merta',
                'deskripsi' => 'Informasi yang wajib diumumkan segera tanpa penundaan jika dapat mengancam hajat hidup orang banyak.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
            [
                'id' => 3,
                'nama' => 'Informasi Setiap Saat',
                'slug' => 'informasi-setiap-saat',
                'deskripsi' => 'Informasi yang wajib tersedia setiap saat, dapat diakses kapan pun oleh masyarakat.',
                'created_at' => '2025-07-24 05:00:56',
                'updated_at' => '2025-07-24 05:00:56',
            ],
        ]);
    }
}