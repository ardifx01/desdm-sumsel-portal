@extends('layouts.public_app')

@section('title', 'Alur Permohonan Informasi Publik')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alur Permohonan Informasi</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Alur Permohonan Informasi</h1>
        <p class="lead text-muted">Ikuti langkah-langkah mudah berikut untuk mengajukan permohonan informasi publik.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Placeholder untuk Infografis Resmi --}}
            <div class="card shadow-sm border-0 text-center p-4 mb-5">
                <h4 class="text-muted">Infografis Alur Permohonan</h4>
                @php
                    $infografisPath = 'images/infografis-permohonan.png';
                    $placeholderUrl = 'https://placehold.co/1200x600/E5E7EB/6B7280?text=Infografis+Alur+Permohonan';
                @endphp
                @if(file_exists(public_path($infografisPath)))
                    <img src="{{ asset($infografisPath) }}" alt="Infografis Alur Permohonan Informasi" class="img-fluid rounded mt-3">
                @else
                    <img src="{{ $placeholderUrl }}" alt="Placeholder Infografis" class="img-fluid rounded mt-3">
                @endif
            </div>
            
            <div class="flowchart-container">
                {{-- PERBAIKAN: Semua langkah dikembalikan --}}
                <div class="flowchart-step"><div class="step-number">1</div><div class="step-content p-3"><p class="mb-0">Pemohon mengisi formulir permohonan informasi secara online atau datang langsung ke Kantor PPID.</p></div></div>
                <div class="flowchart-step"><div class="step-number">2</div><div class="step-content p-3"><p class="mb-0">Melengkapi persyaratan identitas (KTP untuk perorangan, Akta Pendirian untuk Badan Hukum, dll).</p></div></div>
                <div class="flowchart-step"><div class="step-number">3</div><div class="step-content p-3"><p class="mb-0">Petugas PPID menerima dan memverifikasi permohonan.</p></div></div>
                <div class="flowchart-step"><div class="step-number">4</div><div class="step-content p-3"><p class="mb-0">Jika permohonan lengkap, petugas mencatat dalam register permohonan dan memberikan tanda bukti penerimaan.</p></div></div>
                <div class="flowchart-step"><div class="step-number">5</div><div class="step-content p-3"><p class="mb-0">PPID melakukan proses klasifikasi informasi dan berkoordinasi dengan unit terkait.</p></div></div>
                <div class="flowchart-step"><div class="step-number">6</div><div class="step-content p-3"><p class="mb-0">Informasi diberikan paling lambat 10 hari kerja sejak permohonan diterima. Jangka waktu dapat diperpanjang 7 hari kerja.</p></div></div>
                <div class="flowchart-step"><div class="step-number">7</div><div class="step-content p-3"><p class="mb-0">Apabila permohonan ditolak, PPID harus memberikan alasan penolakan dan mekanisme keberatan.</p></div></div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow">
                    <i class="bi bi-send-fill me-2"></i> Ajukan Permohonan Sekarang
                </a>
            </div>

        </div>
    </div>
</div>
@endsection