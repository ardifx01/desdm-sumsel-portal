@extends('layouts.public_app')

@section('title', 'Profil PPID')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    {{-- ... (Hero section tidak berubah, biarkan seperti sebelumnya) ... --}}
</div>

<div class="container py-5">
    <div class="row g-5">
        {{-- Kolom Sidebar Navigasi (Kiri) --}}
        <div class="col-lg-3">
            <nav id="ppid-navbar" class="ppid-sidebar-nav nav nav-pills flex-column">
                <a class="nav-link" href="#visi-misi"><i class="bi bi-bullseye"></i> Visi, Misi & Maklumat</a>
                <a class="nav-link" href="#struktur"><i class="bi bi-diagram-3-fill"></i> Struktur Organisasi</a>
                <a class="nav-link" href="#tugas-fungsi"><i class="bi bi-journal-richtext"></i> Tugas & Fungsi</a>
                <a class="nav-link" href="#dasar-hukum"><i class="bi bi-gavel"></i> Dasar Hukum</a>
            </nav>
        </div>

        {{-- Kolom Konten Utama (Kanan) --}}
        <div class="col-lg-9" data-bs-spy="scroll" data-bs-target="#ppid-navbar" data-bs-offset="100" tabindex="0">
            <div class="vstack gap-5">

                {{-- Bagian 1: Visi, Misi & Maklumat --}}
                <section id="visi-misi" class="content-section">
                    <h2 class="section-title mb-4">Visi, Misi & Maklumat</h2>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="fw-bold text-primary">Visi</h4>
                            <blockquote class="blockquote fs-5">
                                <p>"Terwujudnya Pelayanan Informasi Publik yang Transparan, Akuntabel, dan Inklusif demi Terpenuhinya Hak Masyarakat atas Informasi."</p>
                            </blockquote>
                            <hr class="my-4">
                            <h4 class="fw-bold text-primary">Misi</h4>
                            <ol class="styled-ol">
                                <li>Meningkatkan kualitas pengelolaan dan pelayanan informasi publik.</li>
                                <li>Menyediakan informasi publik secara cepat, tepat, dan akurat.</li>
                                <li>Membangun sistem dokumentasi yang tertib dan modern.</li>
                                <li>Meningkatkan kapasitas dan kompetensi petugas PPID.</li>
                            </ol>
                            <hr class="my-4">
                            <h4 class="fw-bold text-primary">Maklumat Pelayanan</h4>
                            <div class="alert alert-light border-start border-5 border-primary mt-3">
                                <p class="mb-0 fst-italic">"Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan informasi publik sesuai standar operasional prosedur yang telah ditetapkan..."</p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Bagian 2: Struktur Organisasi --}}
                <section id="struktur" class="content-section">
                    <h2 class="section-title mb-4">Struktur Organisasi PPID</h2>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <img src="{{ asset('images/struktur_ppid.png') }}" alt="Bagan Struktur Organisasi PPID" class="img-fluid border shadow-sm rounded mb-4">
                            <p>Struktur PPID Dinas ESDM Provinsi Sumatera Selatan menjamin alur koordinasi dan pelayanan yang efektif, terdiri dari:</p>
                            <ul>
                                <li><strong>Atasan PPID:</strong> Penanggung jawab tertinggi.</li>
                                <li><strong>PPID:</strong> Manajer pengelolaan dan pelayanan informasi.</li>
                                <li><strong>PPID Pelaksana:</strong> Tim teknis pelayanan informasi.</li>
                                <li><strong>Tim Pertimbangan:</strong> Tim ahli untuk kasus informasi kompleks.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                    {{-- Bagian 3: Tugas & Fungsi --}}
                    <section id="tugas-fungsi" class="content-card">
                        <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-journal-richtext me-3"></i>Tugas & Fungsi PPID</h3></div>
                        <div class="card-body p-4 content-body">
                            <h4 class="fw-bold">Tugas Pokok PPID</h4>
                            <p>Melaksanakan tugas dan fungsi sebagai Pejabat Pengelola Informasi dan Dokumentasi di lingkungan Dinas ESDM Provinsi Sumatera Selatan sesuai dengan peraturan perundang-undangan yang berlaku.</p>

                            <h4 class="fw-bold mt-4">Fungsi PPID</h4>
                            <ol class="styled-ol">
                                <li>Penyimpanan, pendokumentasian, penyediaan, dan pelayanan informasi publik.</li>
                                <li>Pengelolaan sistem informasi dan dokumentasi yang mudah diakses.</li>
                                <li>Penetapan standar operasional prosedur (SOP) pelayanan informasi.</li>
                                <li>Melakukan pengujian konsekuensi atas informasi yang dikecualikan.</li>
                                <li>Melakukan klasifikasi informasi publik.</li>
                                <li>Mengelola pengajuan keberatan dan proses sengketa informasi.</li>
                                <li>Menyusun laporan layanan informasi publik secara berkala.</li>
                            </ol>
                        </div>
                    </section>

                    {{-- Bagian 4: Dasar Hukum --}}
                    <section id="dasar-hukum" class="content-card">
                        <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-gavel me-3"></i>Dasar Hukum</h3></div>
                        <div class="card-body p-4 content-body">
                            <p>Pembentukan dan operasional PPID berlandaskan pada peraturan sebagai berikut:</p>
                            <ol class="styled-ol">
                                <li><strong>UU No. 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</li>
                                <li><strong>PP No. 61 Tahun 2010</strong> tentang Pelaksanaan UU No. 14 Tahun 2008.</li>
                                <li><strong>Perki No. 1 Tahun 2021</strong> tentang Standar Layanan Informasi Publik.</li>
                                <li><strong>Permendagri No. 3 Tahun 2017</strong> tentang Pedoman Pengelolaan Pelayanan Informasi.</li>
                                <li><strong>Keputusan Gubernur & Kepala Dinas</strong> terkait pembentukan PPID di lingkungan Pemprov Sumsel.</li>
                            </ol>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // JavaScript untuk animasi "Reveal on Scroll"
    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.content-section');
        
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1 // Muncul saat 10% bagian terlihat
        });

        sections.forEach(section => {
            observer.observe(section);
        });
        
        // Mengaktifkan Scrollspy Bootstrap
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#ppid-navbar'
        })
    });
</script>
@endpush