@extends('layouts.public_app')

@section('title', 'Album: ' . $album->nama)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($album->nama, 50) }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $album->nama }}</h1>
        @if($album->deskripsi)
        <p class="lead text-muted">{{ $album->deskripsi }}</p>
        @endif
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @forelse($album->photos as $photo)
            <div class="col-md-4 col-lg-3">
                @php
                    // Memanggil accessor 'display_image_url' yang sudah kita buat
                    $imageUrl = $photo->display_image_url;
                @endphp
                
                {{-- Cek apakah URL ada (bukan null) --}}
                @if($imageUrl)
                    <a href="{{ $imageUrl }}"
                       class="glightbox photo-item"
                       data-gallery="gallery-album"
                       data-title="{{ $photo->judul ?: Str::limit($photo->file_name, 25) }}"
                       data-description="{{ $photo->deskripsi }}">
                        
                        <img src="{{ $imageUrl }}" 
                             class="img-fluid" 
                             alt="{{ $photo->judul ?: $photo->file_name }}"
                             style="height: 250px; width: 100%; object-fit: cover;">
                    </a>
                @else
                    {{-- Tampilkan placeholder jika accessor mengembalikan null --}}
                    <div class="photo-item d-flex align-items-center justify-content-center bg-light" style="height: 250px;">
                        <i class="bi bi-image-alt fs-1 text-muted"></i>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-4">Album ini belum memiliki foto.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('galeri.index') }}" class="btn btn-secondary btn-lg">Kembali ke Semua Galeri</a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Inisialisasi GLightbox
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
    });
</script>
@endpush