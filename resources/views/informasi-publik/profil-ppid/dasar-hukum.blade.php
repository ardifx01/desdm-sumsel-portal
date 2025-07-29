@extends('layouts.public_app')

@section('title', 'Dasar Hukum PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dasar Hukum</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Dasar Hukum Pembentukan PPID Dinas ESDM Provinsi Sumatera Selatan</h2>

    <p>Pembentukan dan operasional PPID Dinas ESDM Provinsi Sumatera Selatan berlandaskan pada peraturan perundang-undangan sebagai berikut:</p>
    <ol>
        <li>**Undang-Undang Nomor 14 Tahun 2008** tentang Keterbukaan Informasi Publik.</li>
        <li>**Peraturan Pemerintah Nomor 61 Tahun 2010** tentang Pelaksanaan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</li>
        <li>**Peraturan Komisi Informasi Pusat Republik Indonesia Nomor 1 Tahun 2021** tentang Standar Layanan Informasi Publik.</li>
        <li>**Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 3 Tahun 2017** tentang Pedoman Pengelolaan Pelayanan Informasi dan Dokumentasi Kementerian Dalam Negeri dan Pemerintahan Daerah.</li>
        <li>**Keputusan Gubernur Sumatera Selatan Nomor [...] Tahun [...]** tentang Pembentukan Pejabat Pengelola Informasi dan Dokumentasi di Lingkungan Pemerintah Provinsi Sumatera Selatan.</li>
        <li>**Keputusan Kepala Dinas ESDM Provinsi Sumatera Selatan Nomor [...] Tahun [...]** tentang Pembentukan Tim Pelaksana dan Atasan Pejabat Pengelola Informasi dan Dokumentasi di Lingkungan Dinas ESDM Provinsi Sumatera Selatan.</li>
        {{-- Ganti dengan dasar hukum resmi yang lebih rinci --}}
    </ol>
    <p>Peraturan-peraturan ini menjamin hak setiap warga negara untuk memperoleh informasi publik.</p>

    <a href="{{ route('informasi-publik.profil-ppid.index') }}" class="btn btn-secondary mt-4">Kembali ke Profil PPID</a>
</div>
@endsection