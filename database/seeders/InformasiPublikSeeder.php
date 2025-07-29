<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InformasiPublikCategory;
use App\Models\InformasiPublik;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Untuk Str::slug

class InformasiPublikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Kategori Informasi Publik
        $berkala = InformasiPublikCategory::firstOrCreate(
            ['nama' => 'Informasi Berkala'],
            ['slug' => 'informasi-berkala', 'deskripsi' => 'Informasi yang wajib diumumkan secara berkala, minimal 6 bulan sekali.']
        );

        $sertaMerta = InformasiPublikCategory::firstOrCreate(
            ['nama' => 'Informasi Serta Merta'],
            ['slug' => 'informasi-serta-merta', 'deskripsi' => 'Informasi yang wajib diumumkan segera tanpa penundaan jika dapat mengancam hajat hidup orang banyak.']
        );

        $setiapSaat = InformasiPublikCategory::firstOrCreate(
            ['nama' => 'Informasi Setiap Saat'],
            ['slug' => 'informasi-setiap-saat', 'deskripsi' => 'Informasi yang wajib tersedia setiap saat, dapat diakses kapan pun oleh masyarakat.']
        );

        // Buat folder untuk file dummy jika belum ada
        if (!Storage::exists('public/informasi_publik')) {
            Storage::makeDirectory('public/informasi_publik');
        }
        if (!Storage::exists('public/thumbnails')) {
            Storage::makeDirectory('public/thumbnails');
        }

        // Contoh data Informasi Publik
        $dataInformasi = [
            // Informasi Berkala
            [
                'category_id' => $berkala->id,
                'judul' => 'Laporan Akuntabilitas Kinerja Instansi Pemerintah Tahun 2024',
                'konten' => '<p>Dokumen LAKIP Dinas ESDM Provinsi Sumatera Selatan tahun 2024. Berisi capaian kinerja dan akuntabilitas penggunaan anggaran.</p><p>Dokumen ini penting untuk transparansi dan evaluasi kinerja instansi.</p>',
                'file_path' => null, // akan kita simulasikan file
                'file_nama' => 'LAKIP-DESDM-Sumsel-2024.pdf',
                'file_tipe' => 'application/pdf',
                'thumbnail' => null, // akan kita simulasikan thumbnail
                'tanggal_publikasi' => now()->subMonths(1),
                'is_active' => true,
            ],
            [
                'category_id' => $berkala->id,
                'judul' => 'Rencana Strategis (Renstra) Dinas ESDM Sumsel 2025-2029',
                'konten' => '<p>Dokumen perencanaan jangka menengah Dinas ESDM Sumsel. Memuat visi, misi, tujuan, strategi, dan kebijakan Dinas untuk periode lima tahun.</p>',
                'file_path' => null,
                'file_nama' => 'RENSTRA-DESDM-Sumsel-2025-2029.pdf',
                'file_tipe' => 'application/pdf',
                'thumbnail' => null,
                'tanggal_publikasi' => now()->subMonths(3),
                'is_active' => true,
            ],
            // Informasi Serta Merta
            [
                'category_id' => $sertaMerta->id,
                'judul' => 'Peringatan Dini Potensi Longsor di Area Pertambangan XYZ',
                'konten' => '<p>Masyarakat diimbau untuk meningkatkan kewaspadaan terkait potensi longsor di area pertambangan XYZ menyusul intensitas hujan yang tinggi.</p><p>Dinas ESDM bersama pihak terkait sedang melakukan pemantauan intensif dan telah menyiapkan langkah-langkah mitigasi.</p>',
                'file_path' => null,
                'file_nama' => null,
                'file_tipe' => null,
                'thumbnail' => null,
                'tanggal_publikasi' => now()->subHours(5),
                'is_active' => true,
            ],
            // Informasi Setiap Saat
            [
                'category_id' => $setiapSaat->id,
                'judul' => 'Daftar IUP Mineral Bukan Logam dan Batuan di Sumsel',
                'konten' => '<p>Daftar Izin Usaha Pertambangan (IUP) untuk komoditas mineral bukan logam dan batuan di wilayah Provinsi Sumatera Selatan.</p><p>Dokumen ini diperbarui secara berkala dan dapat diakses setiap saat oleh masyarakat.</p>',
                'file_path' => null,
                'file_nama' => 'Daftar-IUP-Non-Logam-Sumsel.xlsx',
                'file_tipe' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'thumbnail' => null,
                'tanggal_publikasi' => now()->subDays(10),
                'is_active' => true,
            ],
            [
                'category_id' => $setiapSaat->id,
                'judul' => 'Prosedur Permohonan Informasi Publik DESDM Sumsel',
                'konten' => '<p>Panduan lengkap mengenai tata cara dan persyaratan untuk mengajukan permohonan informasi publik kepada Dinas ESDM Sumatera Selatan.</p>',
                'file_path' => null,
                'file_nama' => 'Prosedur-Permohonan-Informasi-Publik.pdf',
                'file_tipe' => 'application/pdf',
                'thumbnail' => null,
                'tanggal_publikasi' => now()->subDays(20),
                'is_active' => true,
            ],
        ];

        // Simulasikan penyimpanan file dummy dan thumbnail
        foreach ($dataInformasi as $key => $data) {
            // Generate slug
            $dataInformasi[$key]['slug'] = Str::slug($data['judul']);

            // Simulasikan penyimpanan file
            if ($data['file_nama']) {
                $dummyContent = "Ini adalah konten dummy untuk file " . $data['file_nama'] . ".";
                $filePath = 'public/informasi_publik/' . $data['file_nama'];
                Storage::put($filePath, $dummyContent);
                $dataInformasi[$key]['file_path'] = $filePath;
            }

            // Simulasikan penyimpanan thumbnail
            // Anda bisa menyiapkan gambar placeholder di public/images/thumbnail_default.png
            // Lalu salin ke storage/app/public/thumbnails
            // Untuk kesederhanaan, kita hanya akan memberikan nama file dummy
            $dummyThumbnailName = 'thumbnail_' . ($key + 1) . '.png';
            // Jika Anda punya gambar default, bisa lakukan:
            // $sourceThumbnailPath = public_path('images/thumbnail_default.png');
            // if (file_exists($sourceThumbnailPath)) {
            //     Storage::disk('public')->put('thumbnails/' . $dummyThumbnailName, file_get_contents($sourceThumbnailPath));
            //     $dataInformasi[$key]['thumbnail'] = $dummyThumbnailName;
            // } else {
            //     $dataInformasi[$key]['thumbnail'] = null; // Atau nama file placeholder default
            // }
            // Untuk sekarang, kita biarkan null atau bisa Anda atur manual setelah seeder.
            $dataInformasi[$key]['thumbnail'] = null;
        }

        // Masukkan data informasi publik ke database
        foreach ($dataInformasi as $data) {
            InformasiPublik::create($data);
        }
    }
}