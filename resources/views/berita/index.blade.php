@extends('layouts.public_app')

@section('title', $title)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Berita</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $title }}</h1>
        <p class="lead text-muted">Temukan informasi dan perkembangan terbaru dari Dinas ESDM Sumsel.</p>
    </div>
</div>

<div class="container py-5">
   
    <div class="row my-4">
        <div class="col-md-10 mx-auto">
            <div class="card border-0 shadow-sm p-2">
                <form action="{{ route('berita.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-lg border-0" placeholder="Ketik kata kunci berita..." value="{{ request('q') }}">
                    <select name="kategori" class="form-select form-select-lg border-0" style="width: auto;">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-search"></i></button>
                    @if(request('q') || request('kategori') != 'all')
                        <a href="{{ route('berita.index') }}" class="btn btn-light btn-lg">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0 berita-card">
                <a href="{{ route('berita.show', $post->slug) }}" class="text-decoration-none">
                    <div class="card-img-top-wrapper">
                        <img src="{{ $post->universal_thumb_url }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy" style="height: 100%; width: 100%; object-fit: cover;">
                    </div>
                </a>
                <div class="card-body d-flex flex-column">
                    <div>
                        @if($post->category)
                        <span class="badge {{ $post->category->frontend_badge_class }} mb-2">
                            {{ $post->category->name }}
                        </span>
                        @endif
                        <h5 class="card-title fw-bold">
                            <a href="{{ route('berita.show', $post->slug) }}" class="card-title">{{ Str::limit($post->title, 60) }}</a>
                        </h5>
                        <p class="card-text text-muted small mb-2">
                            <i class="bi bi-calendar3"></i> {{ $post->created_at ? $post->created_at->translatedFormat('d M Y') : '-' }} &nbsp;
                            <i class="bi bi-person-fill"></i> {{ $post->author->name ?? 'Admin' }}
                        </p>
                        <p class="card-text small">{{ Str::limit(strip_tags($post->excerpt ?: $post->content_html), 100) }}</p>
                    </div>
                    <div class="mt-auto pt-2">
                        <a href="{{ route('berita.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <h4 class="mt-3">Berita Tidak Ditemukan</h4>
            <p class="text-muted">Maaf, tidak ada berita yang cocok dengan kriteria pencarian Anda.</p>
            <a href="{{ route('berita.index') }}" class="btn btn-primary">Kembali ke Semua Berita</a>
        </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection