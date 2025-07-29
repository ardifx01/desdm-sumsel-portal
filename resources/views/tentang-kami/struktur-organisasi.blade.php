@extends('layouts.public_app')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li>
            <li class="breadcrumb-item active" aria-current="page">Struktur Organisasi</li>
        </ol>
    </nav>
    <h2 class="mb-4">Struktur Organisasi Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="text-center mb-5">
        {{-- Pastikan Anda memiliki gambar struktur organisasi di public/images/struktur_organisasi.png atau sejenisnya --}}
        <img src="{{ asset('storage/images/str.png') }}" alt="Bagan Struktur Organisasi DESDM Sumsel" loading="lazy" class="img-fluid border shadow-sm" style="max-height: 800px; width: auto; object-fit: contain;">
        {{-- <img src="{{ asset('images/str.png') }}" alt="Bagan Struktur Organisasi DESDM Sumsel" loading="lazy" class="img-fluid border shadow-sm" style="max-height: 800px; object-fit: contain;"> --}}
        <p class="mt-3 text-muted">Bagan Struktur Organisasi Dinas ESDM Provinsi Sumatera Selatan</p>
    </div>

    <h3>Deskripsi Umum Struktur</h3>
    <p>Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan dipimpin oleh seorang Kepala Dinas dan dibantu oleh beberapa bidang teknis yang masing-masing dipimpin oleh Kepala Bidang, antara lain:</p>
    <ul>
        <li>Bidang Energi</li>
        <li>Bidang Ketenagalistrikan</li>
        <li>Bidang Pengusahaan Mineral dan Batubara</li>
        <li>Bidang Teknik dan Penerimaan Mineral dan Batubara</li>
        <li>Unit Pelaksana Teknis Dinas (UPTD) Geologi dan Laboratorium</li>
        <li>Cabang Dinas Regional I-VII
    </ul>
    <p>Setiap Bidang, UPTD dan Cabang Dinas memiliki tugas dan fungsi spesifik yang mendukung pencapaian visi dan misi Dinas.</p>

    <a href="{{ route('tentang-kami.index') }}" class="btn btn-secondary mt-4">Kembali ke Tentang Kami</a>
</div>
@endsection