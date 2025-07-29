@extends('layouts.public_app')

@section('title', 'FAQ Umum')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">FAQ Umum</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Pertanyaan Umum (FAQ) Dinas ESDM Provinsi Sumatera Selatan</h2>

    <p class="lead text-center mb-5">Berikut adalah daftar pertanyaan yang sering diajukan terkait layanan dan operasional Dinas ESDM Sumsel.</p>

    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Apa saja tugas utama Dinas ESDM Provinsi Sumatera Selatan?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Dinas ESDM Sumsel memiliki tugas utama merumuskan dan melaksanakan kebijakan di bidang energi, ketenagalistrikan, mineral dan batubara, serta geologi di wilayah provinsi. Ini mencakup perencanaan, perizinan, pengawasan, dan pengembangan potensi daerah.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Bagaimana cara mendapatkan izin usaha pertambangan di Sumsel?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Proses perizinan usaha pertambangan diatur dalam Peraturan Gubernur dan peraturan teknis terkait. Informasi detail mengenai persyaratan dan alur perizinan dapat Anda temukan di halaman <a href="{{ route('publikasi.index', ['kategori' => 'regulasi']) }}">Regulasi</a> atau menghubungi Bidang Pengusahaan Minerba.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Apakah ada program subsidi listrik untuk masyarakat miskin di daerah pedesaan?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Program subsidi listrik dan peningkatan rasio elektrifikasi terus diupayakan oleh pemerintah. Informasi mengenai program terbaru dapat dilihat di bagian <a href="{{ route('berita.index') }}">Berita & Pengumuman</a> atau menghubungi Bidang Ketenagalistrikan.
                </div>
            </div>
        </div>
        {{-- Tambahkan pertanyaan dan jawaban lain sesuai kebutuhan --}}
    </div>

    <div class="text-center mt-5">
        <p>Jika pertanyaan Anda belum terjawab, silakan <a href="{{ route('layanan-pengaduan.pengaduan') }}">ajukan pengaduan</a> atau hubungi kami di halaman <a href="{{ url('/kontak') }}">Kontak Umum</a>.</p>
        <a href="{{ route('layanan-pengaduan.index') }}" class="btn btn-secondary mt-3">Kembali ke Layanan & Pengaduan</a>
    </div>
</div>
@endsection