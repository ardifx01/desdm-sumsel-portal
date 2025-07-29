@extends('layouts.public_app')

@section('title', 'Album: ' . $album->nama)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($album->nama, 50) }}</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Album: {{ $album->nama }}</h2>
    <p class="text-center text-muted">{{ $album->deskripsi }}</p>
    <hr>

    <div class="row">
        @forelse($album->photos as $photo)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('storage/' . $photo->file_path) }}" class="card-img-top" alt="{{ $photo->judul ?: $photo->file_name }}" style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <h6 class="card-title mb-1">{{ $photo->judul ?: Str::limit($photo->file_name, 30) }}</h6>
                    <p class="card-text small text-muted">{{ Str::limit($photo->deskripsi, 50) }}</p>
                    {{-- Opsional: Modal untuk tampilan gambar lebih besar --}}
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#photoModal{{ $photo->id }}">
                        Lihat Gambar
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="photoModal{{ $photo->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $photo->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoModalLabel{{ $photo->id }}">{{ $photo->judul ?: $photo->file_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid" alt="{{ $photo->judul ?: $photo->file_name }}">
                        @if($photo->deskripsi)
                            <p class="mt-3">{{ $photo->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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
@endsection