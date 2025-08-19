@extends('layouts.public_app')

@section('title', 'Alur Pengajuan Keberatan Informasi')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alur Pengajuan Keberatan</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Alur Pengajuan Keberatan</h1>
        <p class="lead text-muted">Langkah-langkah yang dapat Anda tempuh jika merasa keberatan dengan keputusan PPID.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Placeholder untuk Infografis Resmi --}}
            <div class="card shadow-sm border-0 text-center p-4 mb-5">
                <h4 class="text-muted">Infografis Alur Keberatan</h4>
                @php
                    $infografisPath = 'images/infografis-keberatan.png';
                    $placeholderUrl = 'https://placehold.co/1200x600/E5E7EB/6B7280?text=Infografis+Alur+Keberatan';
                @endphp
                @if(file_exists(public_path($infografisPath)))
                    <img src="{{ asset($infografisPath) }}" alt="Infografis Alur Pengajuan Keberatan" class="img-fluid rounded mt-3">
                @else
                    <img src="{{ $placeholderUrl }}" alt="Placeholder Infografis" class="img-fluid rounded mt-3">
                @endif
            </div>

            <div class="flowchart-container">
                {{-- PERBAIKAN: Semua langkah dikembalikan --}}
                <div class="flowchart-step"><div class="step-number">1</div><div class="step-content p-3"><p class="mb-0">Pemohon keberatan mengisi formulir pengajuan keberatan secara online atau datang langsung ke Kantor PPID.</p></div></div>
                <div class="flowchart-step"><div class="step-number">2</div><div class="step-content p-3"><p class="mb-0">Melengkapi nomor registrasi permohonan informasi sebelumnya dan alasan keberatan yang jelas.</p></div></div>
                <div class="flowchart-step"><div class="step-number">3</div><div class="step-content p-3"><p class="mb-0">Petugas PPID menerima dan memverifikasi pengajuan keberatan.</p></div></div>
                <div class="flowchart-step"><div class="step-number">4</div><div class="step-content p-3"><p class="mb-0">PPID akan memberikan tanggapan atas keberatan paling lambat 30 hari kerja sejak permohonan keberatan diterima.</p></div></div>
                <div class="flowchart-step"><div class="step-number">5</div><div class="step-content p-3"><p class="mb-0">Jika keberatan diterima, informasi akan diberikan. Jika ditolak, pemohon berhak mengajukan sengketa informasi ke Komisi Informasi.</p></div></div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow">
                    <i class="bi bi-send-fill me-2"></i> Ajukan Keberatan Sekarang
                </a>
            </div>

        </div>
    </div>
</div>
@endsection