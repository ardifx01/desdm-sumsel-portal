@extends('layouts.public_app')

@section('title', $post->title)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index', ['kategori' => $post->category->slug ?? 'all']) }}">{{ $post->category->name ?? 'Tanpa Kategori' }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
        </ol>
    </nav>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            <h1 class="card-title mb-3">{{ $post->title }}</h1>
            <div class="row align-items-center mb-4">
                <div class="col-md-6 text-muted small">
                    <i class="bi bi-calendar"></i> Dipublikasi: {{ $post->created_at ? $post->created_at->translatedFormat('d F Y H:i') : '-' }} |
                    <i class="bi bi-person"></i> Oleh: {{ $post->author->name ?? 'Admin' }} |
                    <i class="bi bi-eye"></i> Dibaca: {{ $post->hits }} kali |
                    <i class="bi bi-share"></i> Dibagikan: <span id="share-count">{{ $post->share_count }}</span> kali
                </div>

                <div class="col-md-6 text-end d-flex align-items-center justify-content-end">
                    <span class="me-2 fw-bold">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                    target="_blank" rel="noopener noreferrer" class="share-btn btn btn-primary me-2 rounded-circle" data-platform="facebook" data-post-id="{{ $post->id }}" style="width: 40px; height: 40px; line-height: 25px;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ url()->current() }}"
                    target="_blank" rel="noopener noreferrer" class="share-btn btn btn-info me-2 rounded-circle" data-platform="twitter" data-post-id="{{ $post->id }}" style="width: 40px; height: 40px; line-height: 25px;">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title) }} - {{ url()->current() }}"
                    target="_blank" rel="noopener noreferrer" class="share-btn btn btn-success me-2 rounded-circle" data-platform="whatsapp" data-post-id="{{ $post->id }}" style="width: 40px; height: 40px; line-height: 25px;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
            <hr>

            @php
                $media = $post->getFirstMedia('featured_image');
                $imageExists = $media && Storage::disk($media->disk)->exists($media->getPath());
                $fallbackImageExists = $post->featured_image_url && Storage::disk('public')->exists($post->featured_image_url);
            @endphp

            @if ($imageExists)
                <div class="text-center mb-4">
                    <picture>
                        <source
                            srcset="{{ $media->getSrcset('webp-responsive') }}"
                            type="image/webp"
                        >
                        <img
                            src="{{ $media->getUrl() }}"
                            class="img-fluid rounded"
                            alt="{{ $post->title }}"
                            loading="lazy"
                        >
                    </picture>
                </div>
            @elseif($fallbackImageExists)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $post->featured_image_url) }}" 
                        class="img-fluid rounded" 
                        alt="{{ $post->title }}" 
                        loading="lazy">
                </div>
            @endif

            <div class="post-content mb-4">
                {!! $post->content_html !!}
            </div>

            @if($post->meta_description)
                <p class="text-muted small mt-4">Meta Deskripsi: {{ $post->meta_description }}</p>
            @endif

            {{-- Bagian Komentar --}}
            <div class="mt-5">
                <h3>Komentar ({{ $approvedComments->count() }})</h3>
                <hr>
                
                {{-- Pesan dari Controller --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                {{-- Formulir Komentar Universal --}}
                <div class="card p-4 mb-4" id="comment-form-container">
                    <h5 class="mb-3" id="form-title">Tambahkan Komentar</h5>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" id="parent-id">
                        
                        {{-- Honeypot field: sembunyikan dari manusia --}}
                        <div style="display:none;">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        {{-- Input Nama dan Email (untuk pengguna non-login) --}}
                        @if(!auth()->check())
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Anda <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @endif

                        <div class="mb-3">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3" placeholder="Tulis komentar Anda di sini..." required>{{ old('content') }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                </div>

                {{-- Daftar Komentar --}}
                @forelse ($approvedComments as $comment)
                    @include('berita.partials.comment', ['comment' => $comment, 'depth' => 0])
                @empty
                    <p>Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.share-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const postId = this.getAttribute('data-post-id');
                const shareUrl = this.getAttribute('href');
                
                fetch(`/berita/${postId}/share-count`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ post_id: postId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('share-count').textContent = data.share_count;
                        window.open(shareUrl, '_blank');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.open(shareUrl, '_blank');
                });
            });
        });
    });
</script>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.reply-form').forEach(form => {
            form.style.display = 'none';
        });

        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const commentId = this.getAttribute('data-comment-id');
                const form = document.getElementById('reply-form-' + commentId);
                
                if (form.style.display === 'none') {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush