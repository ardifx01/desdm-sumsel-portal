@extends('layouts.public_app')

@section('title', 'Video: ' . $video->judul)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($video->judul, 50) }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $video->judul }}</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 mb-4">
                <div class="ratio ratio-16x9">
                    {!! $video->embed_code !!}
                </div>
            </div>
            
            @if($video->deskripsi)
            <div class="content-body">
                <h3 class="mt-5">Deskripsi Video</h3>
                <p class="lead">{{ $video->deskripsi }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection