@extends('layouts.public_app')

@section('title', 'Video: ' . $video->judul)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($video->judul, 50) }}</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Video: {{ $video->judul }}</h2>
    <hr>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="ratio ratio-16x9 mb-4">
                {!! $video->embed_code !!} {{-- Langsung sematkan kode embed --}}
            </div>
            <p class="lead">{{ $video->deskripsi }}</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('galeri.index') }}" class="btn btn-secondary me-2">Kembali ke Galeri</a>
    </div>
</div>
@endsection