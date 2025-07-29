@extends('layouts.public_app')

@section('title', 'Cek Status Layanan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cek Status Layanan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Cek Status Layanan / Pengaduan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <p class="lead mb-4">Untuk melacak status permohonan, pengaduan, atau layanan Anda, silakan masukkan nomor registrasi yang telah Anda terima.</p>

            {{-- Formulir Cek Status (Frontend Saja untuk Saat Ini) --}}
            <form action="#" method="GET" class="col-md-6 mx-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg" placeholder="Masukkan Nomor Registrasi..." aria-label="Nomor Registrasi" name="nomor_registrasi">
                    <button class="btn btn-primary btn-lg" type="submit">Cek Status</button>
                </div>
            </form>

            <p class="text-muted small mt-4">Catatan: Fitur cek status terintegrasi penuh akan dikembangkan pada fase berikutnya.</p>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('layanan-pengaduan.index') }}" class="btn btn-secondary">Kembali ke Layanan & Pengaduan</a>
    </div>
</div>
@endsection