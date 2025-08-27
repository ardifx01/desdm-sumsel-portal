{{-- resources/views/search/partials/bidang.blade.php --}}
<div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        {{-- Judul --}}
        <h5 class="card-title fw-bold">{!! highlight($item->nama, $query) !!}</h5>
        
        {{-- Konten --}}
        <p class="card-text">{!! highlight(generate_excerpt($item->tupoksi, $query), $query) !!}</p>
        
        {{-- Tombol --}}
        <div class="mt-auto">
            <a href="{{ route('bidang-sektoral.show', $item->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
        </div>
    </div>
</div>