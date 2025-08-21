@extends('layouts.public_app')

@section('title', 'Daftar Layanan Umum')

@section('content')
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Layanan Umum</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Daftar Layanan Umum</h1>
        <p class="lead text-muted">Berbagai layanan umum yang disediakan oleh unit-unit teknis kami.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        {{-- Menggunakan kelas service-list-card baru --}}
        {{-- Layanan 1: Konsultasi Teknis Geologi --}}
        <div class="col-md-6">
            <div class="card h-100 shadow-sm service-list-card">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><i class="bi bi-file-earmark-text me-2"></i>Layanan Konsultasi Teknis Geologi</h5>
                    <p class="card-text">Menyediakan konsultasi dan informasi teknis terkait geologi dan potensi sumber daya bumi.</p>
                    <p class="card-text small text-muted"><strong>Unit Penanggung Jawab:</strong> UPTD Geolab</p>
                    <a href="{{ route('bidang-sektoral.show', 'uptd-geologi-dan-laboratorium') }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail Unit</a>
                </div>
            </div>
        </div>

        {{-- Layanan 2: Verifikasi Data Produksi Minerba --}}
        <div class="col-md-6">
            <div class="card h-100 shadow-sm service-list-card">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><i class="bi bi-building-fill-gear me-2"></i>Verifikasi Data Produksi Minerba</h5>
                    <p class="card-text">Layanan verifikasi data produksi mineral dan batubara dari perusahaan pertambangan.</p>
                    <p class="card-text small text-muted"><strong>Unit Penanggung Jawab:</strong> Bidang Teknik dan Penerimaan Minerba</p>
                    <a href="{{ route('bidang-sektoral.show', 'bidang-teknik-dan-penerimaan-mineral-dan-batubara') }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail Unit</a>
                </div>
            </div>
        </div>

        {{-- Layanan 3: Pendampingan Program Konservasi Energi --}}
        <div class="col-md-6">
            <div class="card h-100 shadow-sm service-list-card">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Pendampingan Program Konservasi Energi</h5>
                    <p class="card-text">Pendampingan dan edukasi untuk implementasi program konservasi energi di instansi atau masyarakat.</p>
                    <p class="card-text small text-muted"><strong>Unit Penanggung Jawab:</strong> Bidang Energi</p>
                    <a href="{{ route('bidang-sektoral.show', 'bidang-energi') }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail Unit</a>
                </div>
            </div>
        </div>        
        {{-- (Tambahkan layanan lain dengan format yang sama) --}}

            <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
            </div>        
    </div>
</div>
@endsection