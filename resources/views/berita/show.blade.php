@extends('layouts.public_app')

@section('title', $post->title)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                @if($post->category)
                <li class="breadcrumb-item"><a href="{{ route('berita.index', ['kategori' => $post->category->slug]) }}">{{ $post->category->name }}</a></li>
                @endif
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <article>
                <header class="post-header mb-4">
                    <h1 class="post-title mb-3">{{ $post->title }}</h1>
                    
                    <div class="post-meta d-flex flex-wrap align-items-center gap-3">
                        <span><i class="bi bi-person-fill me-1"></i> {{ $post->author->name ?? 'Admin' }}</span>
                        <span><i class="bi bi-calendar3 me-1"></i> {{ $post->created_at ? $post->created_at->translatedFormat('d F Y') : '-' }}</span>
                        <span><i class="bi bi-eye-fill me-1"></i> {{ $post->hits }} kali</span>
                        <span><i class="bi bi-chat-dots-fill me-1"></i> {{ $approvedComments->count() }} Komentar</span>
                    </div>
                </header>

                @if($post->universal_preview_url)
                    <div class="text-center mb-4">
                        <img src="{{ $post->universal_preview_url }}" class="img-fluid rounded shadow-sm" alt="{{ $post->title }}" loading="lazy">
                    </div>
                @endif

                <div class="post-content mb-5">
                    {!! $post->content_html !!}
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Bagikan Artikel Ini:</span>
                    <div class="post-share-buttons d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="share-btn btn btn-primary rounded-circle" data-post-id="{{ $post->id }}"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ url()->current() }}" target="_blank" class="share-btn btn btn-info rounded-circle text-white" data-post-id="{{ $post->id }}"><i class="bi bi-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title) }} - {{ url()->current() }}" target="_blank" class="share-btn btn btn-success rounded-circle" data-post-id="{{ $post->id }}"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </article>

            {{-- Bagian Komentar --}}
            <section class="comment-section mt-5">
                <h3>Komentar ({{ $approvedComments->count() }})</h3>
                <hr>

                {{-- Pesan dari Controller --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                {{-- Formulir Komentar Utama --}}
                <div class="card p-4 mb-4" id="comment-form-container">
                    <h5 class="mb-3">Tambahkan Komentar</h5>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        
                        @guest
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Anda <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        @endguest

                        <div class="mb-3">
                            <label for="content" class="form-label visually-hidden">Komentar</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="4" placeholder="Tulis komentar Anda di sini..." required>{{ old('content') }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                </div>

                @forelse ($approvedComments as $comment)
                    {{-- Menambahkan 'depth' => 0 untuk komentar tingkat pertama --}}
                    @include('berita.partials.comment', ['comment' => $comment, 'depth' => 0])
                @empty
                    <p class="text-muted">Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </section>
        </div>
    </div>
</div>
@endsection