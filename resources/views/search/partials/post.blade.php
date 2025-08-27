{{-- resources/views/search/partials/post.blade.php --}}
<div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        {{-- Judul --}}
        <h5 class="card-title fw-bold">{!! highlight($item->title, $query) !!}</h5>

        {{-- Meta: Kategori & Tanggal --}}
        <div class="mb-2 d-flex align-items-center gap-2">
            @if($item->category)
                <span class="badge rounded-pill {{ $item->category->frontend_badge_class }}">{{ $item->category->name }}</span>
            @endif
            <small class="text-muted">{{ $item->created_at->translatedFormat('d M Y') }}</small>
        </div>
        
        {{-- Konten --}}
        <p class="card-text">{!! highlight(generate_excerpt($item->excerpt ?: $item->content_html, $query), $query) !!}</p>

        {{-- Tombol --}}
        <div class="mt-auto">
            <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
        </div>
    </div>
</div>