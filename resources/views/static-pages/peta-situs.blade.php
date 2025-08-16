@extends('layouts.public_app')

@section('title', 'Peta Situs')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Peta Situs</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Peta Situs Portal Web Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <p class="lead mb-4">Berikut adalah struktur lengkap halaman-halaman yang tersedia di portal web kami untuk memudahkan Anda menemukan informasi.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h4><i class="bi bi-house-door-fill me-2 text-primary"></i>Halaman Utama</h4>
                            <ul>
                                <li><a href="{{ url('/') }}">Beranda</a></li>
                            </ul>

                            <h4><i class="bi bi-info-circle-fill me-2 text-primary"></i>Tentang Kami</h4>
                            <ul>
                                <li><a href="{{ route('tentang-kami.visi-misi') }}">Visi, Misi & Tujuan</a></li>
                                <li><a href="{{ route('tentang-kami.struktur-organisasi') }}">Struktur Organisasi Dinas</a></li>
                                <li><a href="{{ route('tentang-kami.tugas-fungsi') }}">Tugas & Fungsi Dinas</a></li>
                                <li><a href="{{ route('tentang-kami.profil-pimpinan') }}">Profil Pimpinan Dinas</a></li>
                                <li><a href="{{ route('bidang-sektoral.index') }}">Daftar Bidang & Unit</a></li>
                                <li><a href="{{ route('kinerja.publik') }}">Capaian Kinerja</a></li>
                            </ul>

                            <h4><i class="bi bi-journals me-2 text-primary"></i>Informasi Publik (PPID)</h4>
                            <ul>
                                <li><a href="{{ route('informasi-publik.index') }}">Daftar Informasi Publik (DIP)</a></li>
                                <li><a href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID Overview</a></li>
                                <li><a href="{{ route('informasi-publik.profil-ppid.visi-misi-maklumat') }}">Visi, Misi & Maklumat PPID</a></li>
                                <li><a href="{{ route('informasi-publik.profil-ppid.struktur-organisasi') }}">Struktur Organisasi PPID</a></li>
                                <li><a href="{{ route('informasi-publik.profil-ppid.tugas-fungsi') }}">Tugas & Fungsi PPID</a></li>
                                <li><a href="{{ route('informasi-publik.profil-ppid.dasar-hukum') }}">Dasar Hukum PPID</a></li>
                                <li><a href="{{ route('informasi-publik.permohonan.prosedur') }}">Alur Permohonan Informasi</a></li>
                                <li><a href="{{ route('informasi-publik.permohonan.form') }}">Formulir Permohonan Informasi</a></li>
                                <li><a href="{{ route('informasi-publik.keberatan.prosedur') }}">Alur Pengajuan Keberatan</a></li>
                                <li><a href="{{ route('informasi-publik.keberatan.form') }}">Formulir Pengajuan Keberatan</a></li>
                                <li><a href="{{ route('informasi-publik.laporan-statistik') }}">Laporan & Statistik PPID</a></li>
                                <li><a href="{{ route('informasi-publik.kontak-ppid') }}">Kontak PPID</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">

                            <h4><i class="bi bi-file-earmark-ruled-fill me-2 text-primary"></i>Media Center</h4>
                            <ul>
                                <li><a href="{{ route('publikasi.index') }}">Daftar Publikasi & Dokumen</a></li>
                                <li><a href="{{ route('berita.index') }}">Berita</a></li>
                                <li><a href="{{ route('galeri.index') }}">Galeri Foto & Video</a></li>
                            </ul>

                            <h4><i class="bi bi-headset me-2 text-primary"></i>Layanan & Pengaduan</h4>
                            <ul>
                                <li><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan Overview</a></li>
                                <li><a href="{{ route('layanan-pengaduan.pengaduan') }}">Pengaduan Masyarakat</a></li>
                                <li><a href="{{ route('layanan-pengaduan.faq-umum') }}">FAQ Umum</a></li>
                                <li><a href="{{ route('layanan-pengaduan.daftar-layanan') }}">Daftar Layanan Umum</a></li>
                                <li><a href="{{ route('layanan-pengaduan.cek-status') }}">Cek Status Layanan</a></li>
                            </ul>

                            <h4><i class="bi bi-telephone-fill me-2 text-primary"></i>Kontak</h4>
                            <ul>
                                <li><a href="{{ route('kontak.index') }}">Kontak Umum Dinas</a></li>
                            </ul>

                            <h4><i class="bi bi-file-text-fill me-2 text-primary"></i>Lain-Lain (Footer)</h4>
                            <ul>
                                <li><a href="{{ route('static-pages.show', 'kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                                <li><a href="{{ route('static-pages.show', 'disclaimer') }}">Disclaimer</a></li>
                                <li><a href="{{ route('static-pages.show', 'aksesibilitas') }}">Halaman Aksesibilitas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection