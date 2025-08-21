@extends('layouts.public_app')

@section('title', 'Profil PPID')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil PPID</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Pusat Informasi PPID</h1>
        <p class="lead text-muted">Semua yang perlu Anda ketahui tentang Pejabat Pengelola Informasi dan Dokumentasi kami.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        {{-- Kolom Sidebar Navigasi (Kiri) --}}
        <div class="col-lg-3">
            <div class="ppid-sidebar-nav-wrapper">
                {{-- PERBAIKAN: Menggunakan vstack dan gap-2 untuk jarak --}}
                <nav id="ppid-navbar" class="ppid-sidebar-nav nav flex-column vstack gap-2">
                    <a class="nav-link" href="#visi-misi"><i class="bi bi-bullseye"></i> Visi, Misi & Maklumat</a>
                    <a class="nav-link" href="#struktur"><i class="bi bi-diagram-3-fill"></i> Struktur Organisasi</a>
                    <a class="nav-link" href="#tugas-fungsi"><i class="bi bi-journal-richtext"></i> Tugas & Fungsi</a>
                    <a class="nav-link" href="#dasar-hukum"><i class="bi bi-umbrella"></i> Dasar Hukum</a>
                </nav>
            </div>
        </div>

        {{-- Kolom Konten Utama (Kanan) --}}
        <div class="col-lg-9" data-bs-spy="scroll" data-bs-target="#ppid-navbar" data-bs-offset="150" tabindex="0">
            <div class="vstack gap-5">

                {{-- Bagian 1: Visi, Misi & Maklumat --}}
                <section id="visi-misi" class="ppid-content-section">
                    <h2 class="section-title mb-4">Visi, Misi & Maklumat</h2>
                    <h4 class="fw-bold text-primary">Visi</h4>
                    <blockquote class="blockquote fs-5 border-start border-5 border-primary ps-4">
                        <p>"Terwujudnya Pelayanan Informasi Publik yang Transparan, Akuntabel, dan Inklusif demi Terpenuhinya Hak Masyarakat atas Informasi."</p>
                    </blockquote>
                    <h4 class="fw-bold text-primary mt-5">Misi</h4>
                    <ol class="styled-ol">
                        <li>Meningkatkan kualitas pengelolaan dan pelayanan informasi publik.</li>
                        <li>Menyediakan informasi publik secara cepat, tepat, dan akurat.</li>
                        <li>Membangun sistem dokumentasi yang tertib dan modern.</li>
                        <li>Meningkatkan kapasitas dan kompetensi petugas PPID.</li>
                    </ol>
                    <h4 class="fw-bold text-primary mt-5">Maklumat Pelayanan</h4>
                    <div class="alert alert-light border-start border-5 border-primary mt-3">
                        <p class="mb-0 fst-italic">"Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan informasi publik sesuai standar operasional prosedur yang telah ditetapkan..."</p>
                    </div>
                </section>

                {{-- Bagian 2: Struktur Organisasi --}}
                <section id="struktur" class="ppid-content-section">
                    <h2 class="section-title mb-4">Struktur Organisasi</h2>
                    @php
                        // Definisikan path gambar dan URL placeholder
                        $strukturImagePath = 'images/struktur_ppid.png';
                        // Rekomendasi dimensi yang umum untuk bagan adalah rasio 4:3
                        $placeholderUrl = 'https://placehold.co/1200x900/E5E7EB/6B7280?text=Bagan+Struktur+PPID';
                    @endphp

                    @if(file_exists(public_path($strukturImagePath)))
                        {{-- Jika file fisik ada di public/images/struktur_ppid.png --}}
                        <img src="{{ asset($strukturImagePath) }}" alt="Bagan Struktur Organisasi PPID" class="img-fluid border shadow-sm rounded mb-4">
                    @else
                        {{-- Jika file tidak ada, tampilkan placeholder --}}
                        <img src="{{ $placeholderUrl }}" alt="Bagan Struktur Organisasi PPID tidak tersedia" class="img-fluid border shadow-sm rounded mb-4">
                    @endif                    
                    <p>Struktur PPID Dinas ESDM Provinsi Sumatera Selatan menjamin alur koordinasi dan pelayanan yang efektif, terdiri dari:</p>
                    <ul>
                        <li><strong>Atasan PPID:</strong> Penanggung jawab tertinggi.</li>
                        <li><strong>PPID:</strong> Manajer pengelolaan dan pelayanan informasi.</li>
                        <li><strong>PPID Pelaksana:</strong> Tim teknis pelayanan informasi.</li>
                        <li><strong>Tim Pertimbangan:</strong> Tim ahli untuk kasus informasi kompleks.</li>
                    </ul>
                </section>
                
                {{-- Bagian 3: Tugas & Fungsi --}}
                <section id="tugas-fungsi" class="ppid-content-section">
                    <h2 class="section-title mb-4">Tugas & Fungsi PPID</h2>
                    <h4 class="fw-bold text-primary">Tugas Pokok PPID</h4>
                    <p>Melaksanakan tugas dan fungsi sebagai Pejabat Pengelola Informasi dan Dokumentasi di lingkungan Dinas ESDM Provinsi Sumatera Selatan sesuai dengan peraturan perundang-undangan yang berlaku.</p>

                    <h4 class="fw-bold text-primary mt-5">Fungsi PPID</h4>
                    <ol class="styled-ol">
                        <li>Penyimpanan, pendokumentasian, penyediaan, dan pelayanan informasi publik.</li>
                        <li>Pengelolaan sistem informasi dan dokumentasi yang mudah diakses.</li>
                        <li>Penetapan standar operasional prosedur (SOP) pelayanan informasi.</li>
                        <li>Melakukan pengujian konsekuensi atas informasi yang dikecualikan.</li>
                        <li>Melakukan klasifikasi informasi publik.</li>
                        <li>Mengelola pengajuan keberatan dan proses sengketa informasi.</li>
                        <li>Menyusun laporan layanan informasi publik secara berkala.</li>
                    </ol>
                </section>

                {{-- Bagian 4: Dasar Hukum --}}
                <section id="dasar-hukum" class="ppid-content-section">
                    <h2 class="section-title mb-4">Dasar Hukum</h2>
                    <p>Pembentukan dan operasional PPID berlandaskan pada peraturan sebagai berikut:</p>
                    <ol class="styled-ol">
                        <li><strong>UU No. 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</li>
                        <li><strong>PP No. 61 Tahun 2010</strong> tentang Pelaksanaan UU No. 14 Tahun 2008.</li>
                        <li><strong>Perki No. 1 Tahun 2021</strong> tentang Standar Layanan Informasi Publik.</li>
                        <li><strong>Permendagri No. 3 Tahun 2017</strong> tentang Pedoman Pengelolaan Pelayanan Informasi.</li>
                        <li><strong>Keputusan Gubernur & Kepala Dinas</strong> terkait pembentukan PPID di lingkungan Pemprov Sumsel.</li>
                    </ol>
                </section>

            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.ppid-content-section');
        
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        sections.forEach(section => {
            observer.observe(section);
        });
        
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#ppid-navbar',
            offset: 150
        });
    });
</script>
@endpush