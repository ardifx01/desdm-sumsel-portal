@extends('layouts.public_app')

@section('title', 'Layanan & Pengaduan')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Layanan & Pengaduan</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Pusat Layanan & Pengaduan</h1>
        <p class="lead text-muted">Kami berkomitmen memberikan pelayanan terbaik dan menanggapi setiap masukan dari masyarakat.</p>
    </div>
</div>

<div class="container py-5">
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
</div>
@endsection