@extends('layouts.public_app')

@section('title', 'Layanan & Pengaduan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Layanan & Pengaduan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Layanan dan Pengaduan Masyarakat</h2>

    <p class="lead text-center mb-5">Kami berkomitmen untuk memberikan pelayanan terbaik dan menanggapi setiap masukan dari masyarakat.</p>

    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-chat-dots-fill text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Sistem Pengaduan Masyarakat</h5>
                    <p class="card-text">Laporkan keluhan atau berikan saran Anda melalui SP4N-LAPOR!.</p>
                    <a href="{{ route('layanan-pengaduan.pengaduan') }}" class="btn btn-sm btn-primary mt-2">Ajukan Pengaduan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-question-circle-fill text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Pertanyaan Umum (FAQ)</h5>
                    <p class="card-text">Temukan jawaban atas pertanyaan yang sering diajukan seputar layanan dinas.</p>
                    <a href="{{ route('layanan-pengaduan.faq-umum') }}" class="btn btn-sm btn-success mt-2">Lihat FAQ</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-tools text-info" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Daftar Layanan Umum</h5>
                    <p class="card-text">Informasi mengenai berbagai layanan non-perizinan kami.</p>
                    <a href="{{ route('layanan-pengaduan.daftar-layanan') }}" class="btn btn-sm btn-info mt-2">Lihat Daftar Layanan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mx-auto">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-search text-warning" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Cek Status Layanan</h5>
                    <p class="card-text">Lacak status permohonan atau pengaduan Anda.</p>
                    <a href="{{ route('layanan-pengaduan.cek-status') }}" class="btn btn-sm btn-warning mt-2">Cek Status</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection