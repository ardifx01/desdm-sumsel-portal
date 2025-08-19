@extends('layouts.public_app')

@section('title', 'FAQ Umum')

@section('content')
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ Umum</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Pertanyaan Umum (FAQ)</h1>
        <p class="lead text-muted">Jawaban atas pertanyaan yang sering diajukan seputar layanan dinas.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="accordion accordion-flush" id="faqAccordion">
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
            </div>

            <div class="card mt-5 bg-light border-0">
                <div class="card-body text-center">
                    <p class="mb-2">Tidak menemukan jawaban yang Anda cari?</p>
                    <a href="{{ url('/kontak') }}" class="btn btn-primary">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection