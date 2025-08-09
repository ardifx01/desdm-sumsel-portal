@extends('layouts.public_app')

@section('title', 'Beranda')

@section('content')
<style>
    .masthead {
        /* Menggunakan gambar latar belakang dengan efek overlay gelap */
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('storage/images/hero-desdm-sumsel.png') }}') no-repeat center center;
        background-size: cover;
        background-position: center;
        color: white;
        height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden; /* Penting untuk animasi masuk */
    }
    .masthead h1, .masthead h2, .masthead p {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5); /* Bayangan teks lebih kuat */
        color: white; /* Memastikan semua teks berwarna putih */
    }

    /* Definisi animasi untuk teks */
    @keyframes fadeInSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Definisi animasi baru untuk tombol */
    @keyframes buttonPopIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .masthead .animated-title {
        animation: fadeInSlideUp 1s ease-in-out;
    }
    .masthead .animated-subtitle {
        animation: fadeInSlideUp 1s ease-in-out 0.3s forwards;
        opacity: 0;
    }
    .masthead .animated-text {
        animation: fadeInSlideUp 1s ease-in-out 0.6s forwards;
        opacity: 0;
    }
    
    .masthead .animated-buttons .btn:nth-child(1) {
        animation: buttonPopIn 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0.9s forwards;
        opacity: 0;
    }
    .masthead .animated-buttons .btn:nth-child(2) {
        animation: buttonPopIn 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) 1.2s forwards;
        opacity: 0;
    }

    /* Mengubah warna tombol agar kontras dengan latar belakang gelap */
    .masthead .btn-primary {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: white;
    }
    .masthead .btn-outline-light {
        border-color: white;
        color: white;
    }
    .masthead .btn-outline-light:hover {
        background-color: white;
        color: var(--bs-primary);
    }
        /* Aturan baru untuk menghilangkan garis bawah pada tautan di section features */
    #features .btn-link {
        text-decoration: none;
    }
</style>

<header class="masthead">
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
            {{-- <a href="{{ url('/tentang-kami') }}" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih Lanjut</a> --}}
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
                <h5 class="card-title fw-bold">Profil Pimpinan</h5>
                <p class="card-text text-muted">Kenali para pemimpin dan pejabat di lingkungan dinas kami.</p>
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
                <h5 class="card-title fw-bold">Data Statistik</h5>
                <p class="card-text text-muted">Analisis data dan statistik terkini sektor ESDM.</p>
                <a href="{{ route('bidang-sektoral.data-statistik') }}" class="btn btn-link">Lihat Statistik <i class="fas fa-arrow-right"></i></a>
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
                            {{-- Menggunakan variabel $posts dari controller --}}
                            @forelse($posts as $post)
                            <a href="{{ route('berita.show', $post->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="text-truncate">{{ $post->title }}</span>
                                @if($loop->first)
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
                            {{-- Menggunakan variabel $dokumen dari controller --}}
                            @forelse($dokumen as $doc)
                            <a href="{{ route('publikasi.show', $doc->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="text-truncate">{{ $doc->judul }}</span>

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
        <h2 class="fw-bold mb-4">Layanan Kami</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm p-4 pejabat-card">
                    <i class="fas fa-file-alt fa-4x text-primary mb-3"></i>
                    <h5 class="fw-bold">Pengajuan Izin</h5>
                    <p class="text-muted">Proses pengajuan dan pengelolaan perizinan di bidang ESDM.</p>
                    <a href="{{ url('/layanan/perizinan') }}" class="btn btn-outline-primary mt-auto">Detail Layanan</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm p-4 pejabat-card">
                    <i class="fas fa-bullhorn fa-4x text-primary mb-3"></i>
                    <h5 class="fw-bold">Pelayanan Publik</h5>
                    <p class="text-muted">Informasi dan pelayanan untuk kebutuhan masyarakat umum.</p>
                    <a href="{{ url('/layanan/publik') }}" class="btn btn-outline-primary mt-auto">Detail Layanan</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm p-4 pejabat-card">
                    <i class="fas fa-headset fa-4x text-primary mb-3"></i>
                    <h5 class="fw-bold">Pusat Bantuan</h5>
                    <p class="text-muted">Dapatkan bantuan dan jawaban atas pertanyaan umum Anda.</p>
                    <a href="{{ url('/kontak') }}" class="btn btn-outline-primary mt-auto">Hubungi Kami</a>
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
