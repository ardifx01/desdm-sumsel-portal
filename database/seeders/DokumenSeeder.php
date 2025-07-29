<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DokumenCategory;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Kategori Dokumen
        $regulasi = DokumenCategory::firstOrCreate(
            ['nama' => 'Regulasi'],
            ['slug' => 'regulasi', 'deskripsi' => 'Peraturan dan kebijakan terkait ESDM.']
        );
        $perencanaan = DokumenCategory::firstOrCreate(
            ['nama' => 'Dokumen Perencanaan'],
            ['slug' => 'dokumen-perencanaan', 'deskripsi' => 'Rencana strategis dan kerja dinas.']
        );
        $keuangan = DokumenCategory::firstOrCreate(
            ['nama' => 'Laporan Keuangan'],
            ['slug' => 'laporan-keuangan', 'deskripsi' => 'Laporan anggaran dan realisasi keuangan dinas.']
        );
        $kinerja = DokumenCategory::firstOrCreate(
            ['nama' => 'Laporan Kinerja'],
            ['slug' => 'laporan-kinerja', 'deskripsi' => 'Laporan akuntabilitas dan capaian kinerja dinas.']
        );
        $edukasi = DokumenCategory::firstOrCreate(
            ['nama' => 'Materi Edukasi'],
            ['slug' => 'materi-edukasi', 'deskripsi' => 'Materi sosialisasi dan edukasi untuk masyarakat.']
        );

        // Buat folder untuk file dummy jika belum ada
        if (!Storage::exists('public/dokumen')) {
            Storage::makeDirectory('public/dokumen');
        }

        // Contoh data Dokumen
        $dataDokumen = [
            // Regulasi
            [
                'category_id' => $regulasi->id,
                'judul' => 'Peraturan Gubernur Sumsel Nomor 10 Tahun 2024 tentang Izin Usaha Pertambangan',
                'deskripsi' => 'Peraturan terbaru mengenai tata cara dan persyaratan perizinan usaha pertambangan di wilayah Provinsi Sumatera Selatan.',
                'file_nama' => 'Pergub-10-2024-IUP.pdf',
                'file_tipe' => 'application/pdf',
                'tanggal_publikasi' => now()->subMonths(2),
                'is_active' => true,
            ],
            // Dokumen Perencanaan
            [
                'category_id' => $perencanaan->id,
                'judul' => 'Rencana Kerja Pemerintah Daerah (RKPD) 2025',
                'deskripsi' => 'Dokumen perencanaan tahunan yang memuat arah kebijakan, program, dan kegiatan prioritas Pemerintah Provinsi Sumatera Selatan untuk tahun 2025.',
                'file_nama' => 'RKPD-Sumsel-2025.pdf',
                'file_tipe' => 'application/pdf',
                'tanggal_publikasi' => now()->subMonths(5),
                'is_active' => true,
            ],
            // Laporan Keuangan
            [
                'category_id' => $keuangan->id,
                'judul' => 'Laporan Realisasi Anggaran (LRA) Dinas ESDM Sumsel Tahun 2024',
                'deskripsi' => 'Laporan yang menyajikan ikhtisar sumber, alokasi, dan penggunaan sumber daya keuangan yang dikelola oleh Dinas ESDM Sumsel selama tahun anggaran 2024.',
                'file_nama' => 'LRA-DESDM-Sumsel-2024.xlsx',
                'file_tipe' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'tanggal_publikasi' => now()->subMonths(1),
                'is_active' => true,
            ],
            // Laporan Kinerja
            [
                'category_id' => $kinerja->id,
                'judul' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) 2023',
                'deskripsi' => 'Laporan periodik yang memuat pertanggungjawaban kinerja instansi pemerintah selama tahun 2023.',
                'file_nama' => 'LAKIP-DESDM-Sumsel-2023.pdf',
                'file_tipe' => 'application/pdf',
                'tanggal_publikasi' => now()->subMonths(4),
                'is_active' => true,
            ],
            // Materi Edukasi
            [
                'category_id' => $edukasi->id,
                'judul' => 'Panduan Konservasi Energi di Rumah Tangga',
                'deskripsi' => 'Buku panduan praktis berisi tips dan trik untuk menghemat energi listrik di rumah, mengurangi biaya bulanan, dan mendukung keberlanjutan lingkungan.',
                'file_nama' => 'Panduan-Konservasi-Energi.pdf',
                'file_tipe' => 'application/pdf',
                'tanggal_publikasi' => now()->subMonths(8),
                'is_active' => true,
            ],
        ];

        // Simulasikan penyimpanan file dummy
        foreach ($dataDokumen as $key => $data) {
            $dataDokumen[$key]['slug'] = Str::slug($data['judul']);
            $filePath = 'public/dokumen/' . $data['file_nama'];
            // Buat file dummy di storage
            Storage::put($filePath, "Konten dummy untuk dokumen: " . $data['judul']);
            $dataDokumen[$key]['file_path'] = $filePath;
        }

        // Masukkan data dokumen ke database
        foreach ($dataDokumen as $data) {
            Dokumen::create($data);
        }
    }
}