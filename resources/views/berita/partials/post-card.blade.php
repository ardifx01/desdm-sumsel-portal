{{-- resources/views/berita/partials/post-card.blade.php --}}

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
                <span class="badge {{ $post->category->frontend_badge_class }} mb-2">{{ $post->category->name }}</span>
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