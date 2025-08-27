@extends('layouts.public_app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
        </ol>
    </nav>
    <h2 class="mb-4">Hasil Pencarian untuk "{{ $query }}"</h2>

    @php
        $totalResults = $results->sum(fn($group) => $group['items']->count());
    @endphp

    @if ($totalResults > 0)
        @foreach ($results as $group)
            @if ($group['items']->isNotEmpty())
                {{-- Judul Grup (e.g., Berita, Dokumen) --}}
                <h3 class="mt-5 mb-3">{{ $group['label'] }} ({{ $group['items']->count() }})</h3>
                <div class="row">
                    @foreach ($group['items'] as $item)
                        <div class="col-md-4 mb-4">
                            {{-- INI KODE KUNCINYA --}}
                            {{-- Memilih partial view yang tepat berdasarkan tipe model --}}
                            @php
                                $itemType = match (get_class($item)) {
                                    App\Models\Post::class => 'post',
                                    App\Models\Dokumen::class => 'dokumen',
                                    App\Models\InformasiPublik::class => 'informasi_publik',
                                    App\Models\Bidang::class => 'bidang',
                                    App\Models\Seksi::class => 'seksi',
                                    App\Models\Pejabat::class => 'pejabat',
                                    default => ''
                                };
                            @endphp
                            
                            @if ($itemType)
                                {{-- Memanggil file dari folder partials --}}
                                @include('search.partials.' . $itemType, ['item' => $item, 'query' => $query])
                            @endif
                        </div>
                    @endforeach
                </div>
                <hr>
            @endif
        @endforeach
    @else
        <div class="alert alert-info text-center" role="alert">
            Tidak ada hasil yang ditemukan untuk "{{ $query }}".
        </div>
    @endif

    {{-- Modal Pejabat --}}
    <div class="modal fade" id="pejabatModal" tabindex="-1" aria-labelledby="pejabatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
</div>
@endsection