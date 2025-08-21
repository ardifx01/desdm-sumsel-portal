@extends('layouts.public_app')

@section('title', 'Beranda')

@section('content')

{{-- CSS untuk gambar latar belakang tetap di sini sebagai inline style --}}
@php
    $heroImageUrl = asset('storage/images/hero-desdm-sumsel.png');
@endphp
<header class="masthead" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ $heroImageUrl }}') no-repeat center center; background-size: cover;">
    <div class="container">
        <h2 class="display-4 fw-light animated-title">Selamat Datang di Portal Resmi</h2>
        <h1 class="display-2 fw-bold mb-4 animated-subtitle">{{ config('app.name', 'DESDM Sumsel') }}</h1>
        <p class="lead animated-text">
            Sumber informasi terpercaya mengenai energi dan sumber daya mineral di Provinsi Sumatera Selatan.
        </p>

        <p class="animated-text">
            Temukan informasi publik, berita terkini, dan layanan kami.
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center animated-buttons">
            <a href="{{ url('/informasi-publik') }}" class="btn btn-primary btn-lg px-4 me-sm-3">Akses Informasi Publik</a>
            <a href="{{ url('/') }}#tentang-kami" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</header>


<section id="tentang-kami" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold">Tentang Kami</h2>
                <p class="lead text-muted">Kami berkomitmen untuk mengelola sumber daya energi dan mineral secara berkelanjutan demi kemakmuran masyarakat Sumatera Selatan.</p>
            </div>
        </div>
<div class="row g-4 justify-content-center"> {{-- Menambahkan justify-content-center untuk memusatkan baris kedua --}}

    {{-- BARIS PERTAMA: 3 CARD --}}
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center p-4 pejabat-card">
            <div class="card-body">
                <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Visi & Misi</h5>
                <p class="card-text text-muted">Pelajari visi, misi, dan tujuan strategis kami dalam mengelola sumber daya.</p>
                <a href="{{ url('/tentang-kami/visi-misi') }}" class="btn btn-link" >Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center p-4 pejabat-card">
            <div class="card-body">
                <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Tugas & Fungsi</h5>
                <p class="card-text text-muted">Informasi mengenai peran dan tanggung jawab Dinas ESDM Sumsel.</p>
                <a href="{{ url('/tentang-kami/tugas-fungsi') }}" class="btn btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center p-4 pejabat-card">
            <div class="card-body">
                <i class="fas fa-crown fa-3x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Profil Pejabat</h5>
                <p class="card-text text-muted">Kenali para pejabat struktural di lingkungan dinas kami.</p>
                <a href="{{ url('/tentang-kami/profil-pimpinan') }}" class="btn btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    {{-- BARIS KEDUA: 2 CARD DENGAN LEBAR YANG SAMA --}}
    {{-- Menggunakan col-md-4 dan justify-content-center --}}
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center p-4 pejabat-card">
            <div class="card-body">
                <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Struktur Organisasi</h5>
                <p class="card-text text-muted">Kenali lebih dekat tim dan struktur yang menjalankan operasional kami.</p>
                <a href="{{ url('/tentang-kami/struktur-organisasi') }}" class="btn btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center p-4 pejabat-card">
            <div class="card-body">
                <i class="fas fa-puzzle-piece fa-3x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Profil Bidang</h5>
                <p class="card-text text-muted">Informasi lengkap mengenai tim, tugas, dan tanggung jawab setiap bidang.</p>
                <a href="{{ route('bidang-sektoral.index') }}" class="btn btn-link">Lihat Profil <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center p-4 pejabat-card">
            <div class="card-body">
                <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Capaian Kinerja</h5>
                <p class="card-text text-muted">Analisis data dan statistik terkini Capaian Kinerja Dinas ESDM.</p>
                <a href="{{ route('kinerja.publik') }}" class="btn btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
    </div>
</section>

<section id="news-publications" class="py-5">
    <div class="container">
        <div class="row">
            {{-- Kolom Berita Terkini --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-primary">Berita Terkini</h5>
                        <p class="card-text text-muted">Lihat berita dan pengumuman terbaru dari Dinas ESDM Sumsel.</p>
                        <div class="list-group list-group-flush mb-3">
                            @forelse($posts as $post)
                            <a href="{{ route('berita.show', $post->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="text-truncate">{{ $post->title }}</span>
                                @if($loop->first)
                                    <span class="badge bg-danger rounded-pill">Hot</span>
                                @else
                                    <span class="badge bg-primary rounded-pill">Baru</span>
                                @endif
                            </a>
                            @empty
                            <div class="list-group-item">
                                Belum ada berita terbaru.
                            </div>
                            @endforelse
                        </div>
                        <a href="{{ url('/berita') }}" class="btn btn-sm btn-outline-primary mt-auto">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            
            {{-- Kolom Publikasi Resmi --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-primary">Publikasi Resmi</h5>
                        <p class="card-text text-muted">Akses dokumen perencanaan, regulasi, dan laporan kinerja.</p>
                        <div class="list-group list-group-flush mb-3">
                            @forelse($dokumen as $doc)
                            <a href="{{ route('publikasi.show', $doc->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="text-truncate">{{ $doc->judul }}</span>
                                @if($loop->first)
                                    <span class="badge bg-danger rounded-pill">Hot</span>
                                @else
                                    <span class="badge bg-primary rounded-pill">Baru</span>
                                @endif
                            </a>
                            @empty
                            <div class="list-group-item">
                                Belum ada publikasi terbaru.
                            </div>
                            @endforelse
                        </div>
                        <a href="{{ url('/publikasi') }}" class="btn btn-sm btn-outline-primary mt-auto">Lihat Publikasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Pusat Layanan & Pengaduan</h2>
        
        <div class="row g-4 justify-content-center">
            {{-- Kartu 1: Pengaduan Masyarakat --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 service-card card-danger">
                    <div class="card-body-content">
                        <img src="https://www.lapor.go.id/themes/lapor/assets/images/logo.png" alt="Logo SP4N-LAPOR!" class="card-logo">
                        <h5 class="card-title">Pengaduan Masyarakat</h5>
                        <p class="card-text text-muted small">Gunakan kanal pengaduan resmi pemerintah melalui SP4N-LAPOR!.</p>
                        <div class="mt-auto">
                            <a href="https://www.lapor.go.id/" target="_blank" class="btn btn-danger">Ajukan di LAPOR!</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu 2: Pertanyaan Umum (FAQ) --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 service-card card-success">
                    <div class="card-body-content">
                        <i class="bi bi-question-circle-fill card-icon"></i>
                        <h5 class="card-title">Pertanyaan Umum (FAQ)</h5>
                        <p class="card-text text-muted small">Temukan jawaban atas pertanyaan yang sering diajukan.</p>
                        <div class="mt-auto">
                            <a href="{{ route('layanan-pengaduan.faq-umum') }}" class="btn btn-success">Lihat FAQ</a>
                        </div>
                    </div>
                </div>
            </div>

        {{-- Kartu 3: Daftar Layanan Umum --}}
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 service-card card-info">
                <div class="card-body-content">
                    <i class="bi bi-tools card-icon"></i>
                    <h5 class="card-title">Daftar Layanan Umum</h5>
                    <p class="card-text text-muted small">Informasi mengenai berbagai layanan non-perizinan kami.</p>
                    <div class="mt-auto">
                        <a href="{{ route('layanan-pengaduan.daftar-layanan') }}" class="btn btn-info">Lihat Daftar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 4: Cek Status Layanan --}}
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 service-card card-warning">
                <div class="card-body-content">
                    <i class="bi bi-search card-icon"></i>
                    <h5 class="card-title">Cek Status Layanan</h5>
                    <p class="card-text text-muted small">Lacak status permohonan atau pengaduan Anda.</p>
                    <div class="mt-auto">
                        <a href="{{ route('login') }}" class="btn btn-warning">Cek Status</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="cta" class="py-5 bg-primary text-white text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold">Ada Pertanyaan?</h2>
                <p class="lead">Jangan ragu untuk menghubungi tim kami atau mengunjungi kantor kami.</p>
                <a href="{{ url('/kontak') }}" class="btn btn-outline-light btn-lg">Hubungi Kami Sekarang</a>
            </div>
        </div>
    </div>
</section>



@endsection
