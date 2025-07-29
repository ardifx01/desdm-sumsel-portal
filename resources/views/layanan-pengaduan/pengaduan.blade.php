@extends('layouts.public_app')

@section('title', 'Pengaduan Masyarakat')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengaduan Masyarakat</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Sistem Pengaduan Masyarakat</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <p class="lead mb-4">Dinas ESDM Provinsi Sumatera Selatan berkomitmen untuk menanggapi setiap pengaduan, kritik, dan saran dari masyarakat.</p>
            <p class="mb-5">Kami terintegrasi dengan Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional (SP4N-LAPOR!) untuk memastikan setiap masukan Anda tercatat dan ditindaklanjuti secara profesional.</p>

            <a href="https://www.lapor.go.id/" target="_blank" class="btn btn-lg btn-danger mb-4">
                <i class="bi bi-megaphone-fill me-2"></i> Ajukan Pengaduan via SP4N-LAPOR!
            </a>

            <p class="text-muted">Klik tombol di atas untuk menuju portal resmi SP4N-LAPOR!.</p>
            <small class="text-muted">SP4N-LAPOR! adalah kanal pengaduan resmi pemerintah Indonesia.</small>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('layanan-pengaduan.index') }}" class="btn btn-secondary">Kembali ke Layanan & Pengaduan</a>
    </div>
</div>
@endsection