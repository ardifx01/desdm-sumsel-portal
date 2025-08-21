@extends('layouts.public_app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="display-1 fw-bold text-primary opacity-25">404</div>
            <h1 class="display-4 fw-bold mt-4">Halaman Tidak Ditemukan</h1>
            <p class="lead text-muted my-3">
                Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
            </p>

            {{-- Menampilkan pesan error detail HANYA saat mode debug aktif --}}
            @if(app()->bound('debug') && config('app.debug'))
                <div class="alert alert-warning text-start small">
                    <strong>Pesan Error (Debug Mode):</strong><br>
                    {{ $exception->getMessage() ?: 'Tidak ada pesan error spesifik.' }}
                </div>
            @endif

            <div class="d-flex justify-content-center gap-2 mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection