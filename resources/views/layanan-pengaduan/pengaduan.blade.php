@extends('layouts.public_app')

@section('title', 'Pengaduan Masyarakat')

@section('content')
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengaduan Masyarakat</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Sistem Pengaduan Masyarakat</h1>
        <p class="lead text-muted">Kami terintegrasi dengan SP4N-LAPOR! untuk penanganan pengaduan yang transparan.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 text-center p-5">
                <img src="https://www.lapor.go.id/themes/lapor/assets/images/logo.png" alt="Logo SP4N-LAPOR!" class="mx-auto mb-4" style="max-width: 200px;">
                <p class="lead mb-4">Dinas ESDM Provinsi Sumatera Selatan berkomitmen untuk menanggapi setiap pengaduan, kritik, dan saran dari masyarakat secara profesional.</p>
                <p>Klik tombol di bawah ini untuk menuju portal resmi **Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional (SP4N-LAPOR!)**.</p>
                
                <div class="d-grid gap-2 col-8 mx-auto mt-4">
                    <a href="https://www.lapor.go.id/" target="_blank" class="btn btn-lg btn-danger">
                        <i class="bi bi-megaphone-fill me-2"></i> Ajukan via SP4N-LAPOR!
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection