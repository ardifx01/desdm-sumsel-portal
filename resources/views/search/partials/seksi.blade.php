{{-- resources/views/search/partials/seksi.blade.php --}}
<div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        {{-- Judul --}}
        <h5 class="card-title fw-bold">{!! highlight($item->nama_seksi, $query) !!}</h5>

        {{-- Meta: Induk Bidang --}}
        @if ($item->bidang)
            <small class="d-block text-muted mb-2 fst-italic">Bagian dari: {{ $item->bidang->nama }}</small>
        @endif
        
        {{-- Konten --}}
        <p class="card-text">{!! highlight(generate_excerpt($item->tugas, $query), $query) !!}</p>
        
        {{-- Tombol --}}
        <div class="mt-auto">
            @if ($item->bidang)
                <a href="{{ route('bidang-sektoral.show', $item->bidang->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Bidang Induk</a>
            @endif
        </div>
    </div>
</div>