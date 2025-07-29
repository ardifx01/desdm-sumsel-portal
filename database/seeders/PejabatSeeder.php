<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pejabat; // Import model Pejabat
use Illuminate\Support\Facades\Storage; // Untuk menyimpan gambar dummy

class PejabatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan folder untuk foto ada
        if (!Storage::exists('public/pejabat')) {
            Storage::makeDirectory('public/pejabat');
        }

        // Contoh data pimpinan
        $pejabatData = [
            [
                'nama' => 'Dr. Ir. H. John Doe, M.T.',
                'jabatan' => 'Kepala Dinas ESDM',
                'nip' => '197001011995031001',
                'deskripsi_singkat' => 'Beliau adalah Kepala Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan sejak tahun 2020. Dengan pengalaman lebih dari 25 tahun di sektor ESDM, beliau memimpin dinas ini menuju visi yang lebih maju dan berkelanjutan. Berkomitmen tinggi pada transparansi dan pelayanan publik.',
                'foto' => null, // Akan kita ganti dengan nama file jika ada
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Ir. Jane Smith, M.Sc.',
                'jabatan' => 'Sekretaris Dinas',
                'nip' => '197505102000012003',
                'deskripsi_singkat' => 'Sebagai Sekretaris Dinas, beliau bertanggung jawab atas tata kelola administrasi dan keuangan dinas. Memiliki keahlian dalam manajemen organisasi dan sumber daya manusia.',
                'foto' => null, // Akan kita ganti dengan nama file jika ada
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Budi Santoso, S.T., M.Eng.',
                'jabatan' => 'Kepala Bidang Energi',
                'nip' => '198003152005011005',
                'deskripsi_singkat' => 'Pakar di bidang energi terbarukan dan konservasi energi. Beliau memimpin inovasi dalam pengembangan potensi energi di Sumsel.',
                'foto' => null, // Akan kita ganti dengan nama file jika ada
                'urutan' => 3,
                'is_active' => true,
            ],
        ];

        // Masukkan data ke database
        foreach ($pejabatData as $data) {
            // Untuk foto, jika Anda memiliki gambar dummy, Anda bisa menirunya di sini.
            // Misal, jika Anda punya default_avatar.png di public/images
            // Maka secara programatis, kita bisa menyalinnya ke storage/app/public/pejabat
            // Namun, untuk sederhana, biarkan null dulu atau siapkan gambar secara manual.
            // Jika ingin otomatis:
            // $sourcePath = public_path('images/default_avatar.png');
            // if (file_exists($sourcePath)) {
            //     $fileName = 'pejabat_' . \Illuminate\Support\Str::slug($data['nama']) . '.png';
            //     Storage::disk('public')->put('pejabat/' . $fileName, file_get_contents($sourcePath));
            //     $data['foto'] = $fileName;
            // }

            Pejabat::create($data);
        }
    }
}