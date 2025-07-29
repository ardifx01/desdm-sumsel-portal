@extends('layouts.public_app')

@section('title', $post->title)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita & Media</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index', ['kategori' => $post->category->slug ?? 'all']) }}">{{ $post->category->name ?? 'Tanpa Kategori' }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="card-title mb-3">{{ $post->title }}</h2>
            <p class="card-text text-muted small">
                <span class="badge bg-primary me-2">{{ $post->category->name ?? 'Tanpa Kategori' }}</span>
                <i class="bi bi-calendar"></i> Dipublikasi: {{ $post->created_at ? $post->created_at->translatedFormat('d F Y H:i') : '-' }} |
                <i class="bi bi-person"></i> Oleh: {{ $post->author->name ?? 'Admin' }}
            </p>
            <hr>

            @if($post->featured_image_url)
                <div class="text-center mb-4">
                    {{-- <img src="{{ asset($post->featured_image_url) }}" class="img-fluid rounded" alt="{{ $post->title }}" loading="lazy" style="width: auto; object-fit: contain;"> --}}
                    <img src="{{ asset('storage/' . $post->featured_image_url) }}" class="img-fluid rounded" alt="{{ $post->title }}" loading="lazy" style="width: auto; object-fit: contain;">
                </div>
            @endif

            <div class="post-content mb-4">
                {!! $post->content_html !!} {{-- Konten sudah HTML, gunakan {!! !!} --}}
            </div>

            @if($post->meta_description)
                <p class="text-muted small mt-4">Meta Deskripsi: {{ $post->meta_description }}</p>
            @endif
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('berita.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Berita</a>
    </div>
</div>
@endsection