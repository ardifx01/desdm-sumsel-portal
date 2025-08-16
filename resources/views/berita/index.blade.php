@extends('layouts.public_app')

@section('title', $title)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Berita</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">{{ $title }}</h2>

    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('berita.index') }}" method="GET" class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari berita..." value="{{ request('q') }}">
                <select name="kategori" class="form-select">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Cari / Filter</button>
                @if(request('q') || request('kategori') != 'all')
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0 pejabat-card">
                <a href="{{ route('berita.show', $post->slug) }}">
                    @if($post->hasMedia('featured_image'))
                        {{-- Tampilkan gambar dari Spatie Media Library jika ada --}}
                        <img src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') }}"
                            class="card-img-top"
                            alt="{{ $post->title }}"
                            loading="lazy"
                            style="height: 200px; object-fit: cover;">
                    @elseif($post->featured_image_url && Storage::disk('public')->exists($post->featured_image_url))
                        {{-- Fallback ke featured_image_url jika ada dan file fisiknya ada --}}
                        <img src="{{ asset('storage/' . $post->featured_image_url) }}"
                            class="card-img-top"
                            alt="{{ $post->title }}"
                            loading="lazy"
                            style="height: 200px; object-fit: cover;">
                    @else
                        {{-- Placeholder jika tidak ada gambar sama sekali --}}
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                </a>
                <div class="card-body d-flex flex-column">
                    <div>
                        <span class="badge {{ 'badge-category-' . Str::slug($post->category->name) }} mb-2">
                            {{ $post->category->name }}
                        </span>                    
                        <h5 class="card-title">{{ Str::limit($post->title, 60) }}</h5>
                        <p class="card-text text-muted small">
                            <i class="bi bi-calendar"></i> {{ $post->created_at ? $post->created_at->translatedFormat('d M Y') : '-' }} |
                            <i class="bi bi-person"></i> {{ $post->author->name ?? 'Admin' }}
                        </p>
                        <p class="card-text">{{ Str::limit(strip_tags($post->excerpt ?: $post->content_html), 100) }}</p>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('berita.show', $post->slug) }}" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="lead text-muted">Tidak ada berita atau pengumuman yang ditemukan.</p>
            <p>Coba sesuaikan pencarian atau filter Anda.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection