@extends('layouts.public_app')

@section('title', 'Galeri Foto & Video')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Galeri</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Galeri Foto & Video</h1>
        <p class="lead text-muted">Dokumentasi visual kegiatan Dinas ESDM Provinsi Sumatera Selatan.</p>
    </div>
</div>

<div class="container py-5">

    {{-- Bagian Galeri Foto --}}
    <div class="mb-5">
        <h2 class="mb-4">Album Foto</h2>
        <div class="row g-4">
            @forelse($albums as $album)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('galeri.album', $album->slug) }}" class="gallery-card">
                    <div class="card-img-wrapper">
                        @if($album->thumbnail && Storage::disk('public')->exists($album->thumbnail))
                            <img src="{{ asset('storage/' . $album->thumbnail) }}" class="card-img" alt="{{ $album->nama }}">
                        @else
                            <div class="placeholder-icon"><i class="bi bi-images"></i></div>
                        @endif

                        <div class="card-body-overlay">
                            <h5 class="card-title">{{ $album->nama }}</h5>
                            <p class="card-text small">{{ $album->photos->count() }} Foto</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">Belum ada album foto yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>

    <hr class="my-5">

    {{-- Bagian Galeri Video --}}
    <div>
        <h2 class="mb-4">Galeri Video</h2>
        <div class="row g-4">
            @forelse($videos as $video)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('galeri.video', $video->slug) }}" class="gallery-card">
                    <div class="card-img-wrapper">
                        @if($video->thumbnail)
                            <img src="{{ $video->thumbnail }}" class="card-img" alt="{{ $video->judul }}">
                        @else
                            <div class="placeholder-icon"><i class="bi bi-camera-video-off"></i></div>
                        @endif

                        <div class="play-icon"><i class="bi bi-play-circle-fill"></i></div>

                        <div class="card-body-overlay">
                            <h5 class="card-title">{{ Str::limit($video->judul, 50) }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">Belum ada video yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection