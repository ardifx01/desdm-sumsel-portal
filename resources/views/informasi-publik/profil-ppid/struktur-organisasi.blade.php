@extends('layouts.public_app')

@section('title', 'Struktur Organisasi PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID</a></li>
            <li class="breadcrumb-item active" aria-current="page">Struktur Organisasi PPID</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID)</h2>

    <div class="text-center mb-5">
        {{-- Pastikan Anda memiliki gambar struktur organisasi PPID di public/images/struktur_ppid.png atau sejenisnya --}}
        <img src="{{ asset('images/struktur_ppid.png') }}" alt="Bagan Struktur Organisasi PPID DESDM Sumsel" class="img-fluid border shadow-sm" style="max-height: 800px; object-fit: contain;">
        <p class="mt-3 text-muted">Bagan Struktur Organisasi PPID Dinas ESDM Provinsi Sumatera Selatan</p>
    </div>

    <h3>Penjelasan Struktur PPID</h3>
    <p>Struktur PPID Dinas ESDM Provinsi Sumatera Selatan terdiri dari:</p>
    <ul>
        <li>**Atasan PPID:** Pejabat yang bertanggung jawab tertinggi dalam pelaksanaan tugas PPID.</li>
        <li>**PPID:** Pejabat yang bertanggung jawab atas pengelolaan dan pelayanan informasi dan dokumentasi.</li>
        <li>**PPID Pelaksana:** Staf atau unit yang bertugas melaksanakan pelayanan informasi secara langsung.</li>
        <li>**Tim Pertimbangan:** Tim yang memberikan masukan dan pertimbangan terkait permohonan informasi yang kompleks atau berpotensi dikecualikan.</li>
    </ul>
    <p>Setiap komponen struktur memiliki peran vital dalam menjamin hak masyarakat atas informasi.</p>

    <a href="{{ route('informasi-publik.profil-ppid.index') }}" class="btn btn-secondary mt-4">Kembali ke Profil PPID</a>
</div>
@endsection