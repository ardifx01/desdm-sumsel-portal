@extends('layouts.public_app')

@section('title', 'Kontak PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kontak PPID</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Kontak Pejabat Pengelola Informasi dan Dokumentasi (PPID)</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <p class="lead text-center mb-4">Silakan hubungi kami melalui informasi kontak di bawah ini untuk segala pertanyaan atau permohonan terkait informasi publik.</p>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <h5><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Alamat Kantor:</h5>
                            <p class="mb-0">Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</p>
                            <p class="mb-0">Jl. Angkatan 45 No.2440, Demang Lebar Daun, Kec. Ilir Barat I,</p>
                            <p class="mb-0">Kota Palembang, Sumatera Selatan 30137</p>
                            {{-- Ganti dengan alamat resmi PPID DESDM Sumsel --}}
                        </li>
                        <li class="list-group-item">
                            <h5><i class="bi bi-telephone-fill me-2 text-primary"></i>Telepon:</h5>
                            <p class="mb-0"><a href="tel:+62711379040" class="text-decoration-none">+62 711 379040</a></p>
                            <h5><i class="bi bi-printer-fill me-2 text-primary"></i>Faksimile:</h5>
                            <p class="mb-0"><a href="fax:+62711xxxxxx" class="text-decoration-none">+62 711 XXXXXX</a></p>
                            {{-- Ganti dengan nomor telepon/fax resmi PPID DESDM Sumsel --}}
                        </li>
                        <li class="list-group-item">
                            <h5><i class="bi bi-envelope-fill me-2 text-primary"></i>Email:</h5>
                            <p class="mb-0"><a href="mailto:desdm.sumselprov@gmail.com" class="text-decoration-none">desdm.sumselprov@gmail.com</a></p>
                            {{-- Ganti dengan email resmi PPID DESDM Sumsel --}}
                        </li>
                        <li class="list-group-item">
                            <h5><i class="bi bi-clock-fill me-2 text-primary"></i>Jam Pelayanan:</h5>
                            <p class="mb-0">Senin - Kamis: 08.00 - 16.00 WIB</p>
                            <p class="mb-0">Jumat: 08.00 - 16.30 WIB</p>
                            <p class="mb-0">Istirahat: 12.00 - 13.00 WIB (Senin-Kamis), 11.30 - 13.00 WIB (Jumat)</p>
                            <p class="mb-0">Tutup pada Hari Sabtu, Minggu, dan Libur Nasional</p>
                            {{-- Ganti dengan jam pelayanan resmi PPID DESDM Sumsel --}}
                        </li>
                    </ul>

                    <h5><i class="bi bi-map-fill me-2 text-primary"></i>Peta Lokasi:</h5>
                    <div class="ratio ratio-16x9 mb-4">
                        {{-- Ganti src dengan embed kode dari Google Maps --}}
                        {{-- Cara mendapatkan kode embed Google Maps: --}}
                        {{-- 1. Buka Google Maps (maps.google.com) --}}
                        {{-- 2. Cari lokasi "Dinas ESDM Provinsi Sumatera Selatan" --}}
                        {{-- 3. Klik "Bagikan" -> "Sematkan peta" -> "SALIN HTML" --}}
                        {{-- 4. Tempelkan kode iframe di bawah ini --}}
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d63751.027040031804!2d104.7435257!3d-2.9755408!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75dd77fa7bad%3A0x7c3787e83297c183!2sOffice%20of%20Energy%20and%20Mineral%20Resources!5e0!3m2!1sen!2sid!4v1753357066578!5m2!1sen!2sid" 
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('informasi-publik.index') }}" class="btn btn-secondary me-2">Kembali ke Informasi Publik</a>
    </div>
</div>
@endsection