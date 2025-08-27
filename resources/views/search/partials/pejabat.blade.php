{{-- resources/views/search/partials/pejabat.blade.php --}}
<div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        {{-- Judul (Nama Pejabat) --}}
        <h5 class="card-title fw-bold">{!! highlight($item->nama, $query) !!}</h5>
        
        {{-- Konten (Jabatan) --}}
        <p class="card-text">
            {{-- Menggunakan helper baru untuk menampilkan potongan jabatan yang relevan --}}
            {!! highlight(generate_excerpt($item->jabatan, $query), $query) !!}
        </p>
        
        {{-- Tombol (Pemicu Modal) --}}
        <div class="mt-auto">
            <button type="button" class="btn btn-sm btn-primary mt-2 link-pejabat"
                    data-bs-toggle="modal"
                    data-bs-target="#pejabatModal"
                    data-pejabat-id="{{ $item->id }}">
                Lihat Detail
            </button>
        </div>
    </div>
</div>