@extends('layouts.public_app')

@section('title', 'Daftar Layanan Umum')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Layanan Umum</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Daftar Layanan Umum Dinas ESDM Provinsi Sumatera Selatan</h2>

    <p class="lead text-center mb-5">Berikut adalah berbagai layanan umum yang disediakan oleh Dinas ESDM Provinsi Sumatera Selatan.</p>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-file-earmark-text me-2"></i>Layanan Konsultasi Teknis Geologi</h5>
                    <p class="card-text">Menyediakan konsultasi dan informasi teknis terkait geologi dan potensi sumber daya bumi.</p>
                    <p class="card-text small text-muted"><strong>Unit Penanggung Jawab:</strong> UPTD Geolab</p>
                    <a href="{{ route('bidang-sektoral.show', 'uptd-geolab') }}" class="btn btn-sm btn-outline-primary">Lihat Detail Unit</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-building-fill-gear me-2"></i>Verifikasi Data Produksi Minerba</h5>
                    <p class="card-text">Layanan verifikasi data produksi mineral dan batubara dari perusahaan pertambangan.</p>
                    <p class="card-text small text-muted"><strong>Unit Penanggung Jawab:</strong> Bidang Teknik dan Penerimaan Minerba</p>
                    <a href="{{ route('bidang-sektoral.show', 'bidang-teknik-dan-penerimaan-minerba') }}" class="btn btn-sm btn-outline-primary">Lihat Detail Unit</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-person-lines-fill me-2"></i>Pendampingan Program Konservasi Energi</h5>
                    <p class="card-text">Pendampingan dan edukasi untuk implementasi program konservasi energi di instansi atau masyarakat.</p>
                    <p class="card-text small text-muted"><strong>Unit Penanggung Jawab:</strong> Bidang Energi</p>
                    <a href="{{ route('bidang-sektoral.show', 'bidang-energi') }}" class="btn btn-sm btn-outline-primary">Lihat Detail Unit</a>
                </div>
            </div>
        </div>
        {{-- Tambahkan layanan umum lainnya --}}
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('layanan-pengaduan.index') }}" class="btn btn-secondary">Kembali ke Layanan & Pengaduan</a>
    </div>
</div>
@endsection