@extends('layouts.public_app')

@section('title', 'Peta Situs')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Peta Situs</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Peta Situs</h1>
        <p class="lead text-muted">Struktur navigasi lengkap portal web Dinas ESDM Provinsi Sumatera Selatan.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card content-card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <ul class="sitemap-tree">
                        {{-- Halaman Utama --}}
                        <li class="sitemap-item">
                            <a href="{{ url('/') }}" class="sitemap-link"><i class="bi bi-house-door-fill"></i> Beranda</a>
                        </li>
                        
                        {{-- Tentang Kami --}}
                        <li class="sitemap-item">
                            <span class="sitemap-link"><i class="bi bi-info-circle-fill"></i> Tentang Kami</span>
                            <ul>
                                <li class="sitemap-item"><a href="{{ route('tentang-kami.visi-misi') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Visi, Misi & Tujuan</a></li>
                                <li class="sitemap-item"><a href="{{ route('tentang-kami.struktur-organisasi') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Struktur Organisasi</a></li>
                                <li class="sitemap-item"><a href="{{ route('tentang-kami.tugas-fungsi') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Tugas & Fungsi</a></li>
                                <li class="sitemap-item"><a href="{{ route('tentang-kami.profil-pimpinan') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Profil Pimpinan</a></li>
                                <li class="sitemap-item"><a href="{{ route('bidang-sektoral.index') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Profil Bidang & Unit</a></li>
                                <li class="sitemap-item"><a href="{{ route('kinerja.publik') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Capaian Kinerja</a></li>
                            </ul>
                        </li>

                        {{-- PPID --}}
                        <li class="sitemap-item">
                            <span class="sitemap-link"><i class="bi bi-journals"></i> Informasi Publik (PPID)</span>
                            <ul>
                                <li class="sitemap-item"><a href="{{ route('informasi-publik.index') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Daftar Informasi Publik</a></li>
                                <li class="sitemap-item"><a href="{{ route('informasi-publik.profil-ppid.index') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Profil PPID</a></li>
                                <li class="sitemap-item"><a href="{{ route('informasi-publik.permohonan.prosedur') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Alur Permohonan</a></li>
                                <li class="sitemap-item"><a href="{{ route('informasi-publik.keberatan.prosedur') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Alur Keberatan</a></li>
                                {{-- Kita link ke halaman login untuk formulir --}}
                                <li class="sitemap-item"><a href="{{ route('login') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Formulir Online (Wajib Login)</a></li>
                            </ul>
                        </li>

                        {{-- Media Center --}}
                        <li class="sitemap-item">
                            <span class="sitemap-link"><i class="bi bi-file-earmark-ruled-fill"></i> Media Center</span>
                            <ul>
                                <li class="sitemap-item"><a href="{{ route('publikasi.index') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Publikasi & Dokumen</a></li>
                                <li class="sitemap-item"><a href="{{ route('berita.index') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Berita</a></li>
                                <li class="sitemap-item"><a href="{{ route('galeri.index') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Galeri</a></li>
                            </ul>
                        </li>
                        
                        {{-- Layanan & Pengaduan --}}
                        <li class="sitemap-item">
                            <span class="sitemap-link"><i class="bi bi-headset"></i> Layanan & Pengaduan</span>
                            <ul>
                                {{-- Link ke beranda karena sudah dipindah --}}
                                <li class="sitemap-item"><a href="{{ url('/#services') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Pusat Layanan</a></li>
                                <li class="sitemap-item"><a href="https://www.lapor.go.id/" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Pengaduan Masyarakat</a></li>
                                <li class="sitemap-item"><a href="{{ route('layanan-pengaduan.daftar-layanan') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Daftar Layanan Umum</a></li>
                                <li class="sitemap-item"><a href="{{ route('layanan-pengaduan.faq-umum') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> FAQ Umum</a></li>
                            </ul>
                        </li>

                        {{-- Kontak --}}
                        <li class="sitemap-item">
                            <a href="{{ route('kontak.index') }}" class="sitemap-link"><i class="bi bi-telephone-fill"></i> Kontak</a>
                        </li>
                        
                        {{-- Lain-lain --}}
                        <li class="sitemap-item">
                            <span class="sitemap-link"><i class="bi bi-three-dots"></i> Lain-lain</span>
                             <ul>
                                <li class="sitemap-item"><a href="{{ route('static-pages.show', 'kebijakan-privasi') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Kebijakan Privasi</a></li>
                                <li class="sitemap-item"><a href="{{ route('static-pages.show', 'disclaimer') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Disclaimer</a></li>
                                <li class="sitemap-item"><a href="{{ route('static-pages.show', 'aksesibilitas') }}" class="sitemap-link"><i class="bi bi-caret-right-fill"></i> Halaman Aksesibilitas</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>    
</div>
@endsection