{{-- resources/views/search/partials/dokumen.blade.php --}}
<div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        {{-- Judul --}}
        <h5 class="card-title fw-bold">{!! highlight($item->judul, $query) !!}</h5>

        {{-- Meta: Kategori & Tanggal --}}
        <div class="mb-2 d-flex align-items-center gap-2">
            @if($item->category)
                {{-- PERBAIKAN KUNCI: Menggunakan ->nama --}}
                <span class="badge rounded-pill {{ $item->category->frontend_badge_class }}">{{ $item->category->nama }}</span>
            @endif
            @if ($item->tanggal_publikasi)
                <small class="text-muted">{{ $item->tanggal_publikasi->translatedFormat('d M Y') }}</small>
            @endif
        </div>
        
        {{-- Konten --}}
        <p class="card-text">{!! highlight(generate_excerpt($item->deskripsi, $query), $query) !!}</p>

        {{-- Tombol --}}
        <div class="mt-auto">
            <a href="{{ route('publikasi.show', $item->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
        </div>
    </div>
</div>