@extends('layouts.public_app')

@section('title', 'Galeri Foto & Video')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Galeri Foto & Video Dinas ESDM Provinsi Sumatera Selatan</h2>

    {{-- Bagian Galeri Foto --}}
    <h3 class="mt-5 mb-3 text-primary">Galeri Foto</h3>
    <div class="row">
        @forelse($albums as $album)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0">
                @if($album->thumbnail)
                    <img src="{{ asset('storage/' . $album->thumbnail) }}" class="card-img-top" alt="{{ $album->nama }}" style="height: 180px; object-fit: cover;"> {{-- UBAH INI --}}
                @else
                    <img src="https://via.placeholder.com/400x180?text=Album" class="card-img-top" alt="Album Thumbnail" style="height: 180px; object-fit: cover;">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title mb-2">{{ Str::limit($album->nama, 40) }}</h5>
                    <p class="card-text text-muted small">{{ $album->photos->count() }} Foto</p>
                    <a href="{{ route('galeri.album', $album->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Album</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-3">
            <p class="text-muted">Belum ada album foto yang tersedia.</p>
        </div>
        @endforelse
    </div>

    {{-- Bagian Galeri Video --}}
    <h3 class="mt-5 mb-3 text-success">Galeri Video</h3>
    <div class="row">
        @forelse($videos as $video)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                @if($video->thumbnail)
                    <img src="{{ $video->thumbnail }}" class="card-img-top" alt="{{ $video->judul }}" style="height: 200px; object-fit: cover;">
                @else
                    {{-- Default thumbnail untuk YouTube --}}
                    @php
                        $videoId = '';
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->embed_code, $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                        <img src="http://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" class="card-img-top" alt="{{ $video->judul }}" style="height: 200px; object-fit: cover;"> {{-- MENGGUNAKAN PATH BARU --}}
                    @else
                        <img src="https://via.placeholder.com/400x200?text=Video" class="card-img-top" alt="Video Thumbnail" style="height: 200px; object-fit: cover;">
                    @endif
                @endif
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ Str::limit($video->judul, 60) }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit(strip_tags($video->deskripsi), 80) }}</p>
                    <a href="{{ route('galeri.video', $video->slug) }}" class="btn btn-sm btn-outline-success mt-2">Tonton Video</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-3">
            <p class="text-muted">Belum ada video yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection