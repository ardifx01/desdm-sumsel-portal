@extends('layouts.public_app')

@section('title', 'Cek Status Layanan')

@section('content')
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cek Status Layanan</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Cek Status Layanan</h1>
        <p class="lead text-muted">Lacak progres permohonan atau pengaduan Anda di sini.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-5">
                    <p class="text-center mb-4">Untuk melacak status permohonan atau pengaduan Anda, silakan masuk ke dasbor personal Anda.</p>
                    <div class="d-grid col-md-6 mx-auto">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Dasbor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection