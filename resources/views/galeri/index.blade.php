@extends('layouts.public_app')

@section('title', 'Galeri Foto & Video')

@section('content')
<style>
    .card-galeri {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    .card-galeri:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border-color: #0d6efd;
    }
    .card-galeri .card-img-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .card-galeri:hover .card-img-overlay {
        opacity: 1;
    }
    .card-galeri .card-title-overlay {
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }
    .card-galeri:hover .card-title-overlay {
        transform: translateY(0);
    }
</style>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Galeri Foto & Video</h2>
    <p class="text-center text-muted mb-5">Dokumentasi Kegiatan Dinas ESDM Provinsi Sumatera Selatan</p>

    {{-- Bagian Galeri Foto --}}
    <h3 class="mt-5 mb-4">Galeri Foto</h3>
    <div class="row">
        @forelse($albums as $album)
        <div class="col-md-6 col-lg-4 mb-4">
            <a href="{{ route('galeri.album', $album->slug) }}" class="text-decoration-none">
                <div class="card card-galeri h-100 shadow-sm">
                    {{-- PERBAIKAN DI SINI --}}
                    @if($album->thumbnail && Storage::disk('public')->exists($album->thumbnail))
                        <img src="{{ asset('storage/' . $album->thumbnail) }}" class="card-img" alt="{{ $album->nama }}" style="height: 250px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 250px;">
                            <i class="bi bi-images" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                    @endif
                    <div class="card-img-overlay text-white p-3">
                        <h5 class="card-title card-title-overlay">{{ $album->nama }}</h5>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $album->photos->count() }} Foto</small>
                        <span class="text-primary fw-bold">Lihat Album</span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-3">
            <p class="text-muted">Belum ada album foto yang tersedia.</p>
        </div>
        @endforelse
    </div>

    {{-- Bagian Galeri Video --}}
    <h3 class="mt-5 mb-4">Galeri Video</h3>
    <div class="row">
        @forelse($videos as $video)
        <div class="col-md-6 col-lg-4 mb-4">
            <a href="{{ route('galeri.video', $video->slug) }}" class="text-decoration-none">
                <div class="card card-galeri h-100 shadow-sm">
                    <div class="position-relative">
                        {{-- PERBAIKAN DI SINI --}}
                        @if($video->thumbnail)
                            <img src="{{ $video->thumbnail }}" class="card-img-top" alt="{{ $video->judul }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-dark" style="height: 200px;">
                                <i class="bi bi-camera-video-off-fill" style="font-size: 3rem; color: #555;"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-play-circle-fill text-white" style="font-size: 4rem; opacity: 0.8;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-2" style="min-height: 48px;">{{ Str::limit($video->judul, 50) }}</h5>
                    </div>
                    <div class="card-footer bg-white">
                        <span class="text-primary fw-bold">Tonton Video</span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-3">
            <p class="text-muted">Belum ada video yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection