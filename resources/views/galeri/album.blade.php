@extends('layouts.public_app')

@section('title', 'Album: ' . $album->nama)

@section('content')
<style>
    .photo-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .photo-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.2) !important;
        z-index: 10;
    }
    .photo-card .card-img-top {
        cursor: pointer;
    }
</style>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($album->nama, 50) }}</li>
        </ol>
    </nav>
    <h2 class="mb-2 text-center">{{ $album->nama }}</h2>
    <p class="text-center text-muted mb-5">{{ $album->deskripsi }}</p>

    <div class="row">
        {{-- LOOP 1: HANYA UNTUK MENAMPILKAN KARTU FOTO --}}
        @forelse($album->photos as $photo)
            @if($photo->file_path && Storage::disk('public')->exists($photo->file_path))
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 photo-card">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" 
                             class="card-img-top" 
                             alt="{{ $photo->judul ?: $photo->file_name }}" 
                             style="height: 200px; object-fit: cover;"
                             data-bs-toggle="modal" 
                             data-bs-target="#photoModal{{ $photo->id }}">
                        
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1">{{ $photo->judul ?: Str::limit($photo->file_name, 25) }}</h6>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Album ini belum memiliki foto.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('galeri.index') }}" class="btn btn-secondary me-2">Kembali ke Galeri</a>
    </div>
</div>

{{-- LOOP 2: HANYA UNTUK MENDEFINISIKAN SEMUA MODAL --}}
@foreach($album->photos as $photo)
    @if($photo->file_path && Storage::disk('public')->exists($photo->file_path))
    <div class="modal fade" id="photoModal{{ $photo->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $photo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel{{ $photo->id }}">{{ $photo->judul ?: $photo->file_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid" alt="{{ $photo->judul ?: $photo->file_name }}">
                    @if($photo->deskripsi)
                        <p class="mt-3 p-3 text-start">{{ $photo->deskripsi }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection