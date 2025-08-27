@extends('layouts.public_app')

@section('title', 'Hasil Pencarian')

@section('content')

{{-- ========================================================== --}}
{{-- 1. BAGIAN HERO HALAMAN (Untuk Konsistensi Visual)       --}}
{{-- ========================================================== --}}
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Hasil Pencarian</h1>
        @if ($query)
            <p class="lead mb-0">Menampilkan hasil untuk: <strong>"{{ $query }}"</strong></p>
        @endif
    </div>
</div>



<div class="container py-5">

    {{-- ========================================================== --}}
    {{-- 2. FORM PENCARIAN ULANG (Untuk UX yang Lebih Baik)      --}}
    {{-- ========================================================== --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
             <form action="{{ route('search') }}" method="GET" class="input-group input-group-lg">
                <input type="search" name="q" class="form-control" placeholder="Cari berita, dokumen, atau informasi lainnya..." value="{{ $query }}" aria-label="Cari Ulang">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
    

    @php
        $totalResults = $results->sum(fn($group) => $group['items']->count());
    @endphp

    @if ($totalResults > 0)
        
        <div class="row">
            <div class="col-lg-12">
                 <p class="text-muted">Ditemukan total {{ $totalResults }} hasil yang relevan.</p>
                 <hr>
            </div>
        </div>

        @foreach ($results as $resultGroup)
            @if ($resultGroup['items']->isNotEmpty())
                {{-- Judul Grup (e.g., Berita, Dokumen) --}}
                <div class="search-result-group {{ !$loop->first ? 'mt-5' : '' }}">
                    <h3 class="mb-4">{{ $resultGroup['label'] }} ({{ $resultGroup['items']->count() }})</h3>
                    <div class="row">
                        @foreach ($resultGroup['items'] as $item)
                            <div class="col-md-4 mb-4">
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
                                    @include('search.partials.' . $itemType, ['item' => $item, 'query' => $query])
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @else
        {{-- ========================================================== --}}
        {{-- 3. TAMPILAN 'TIDAK ADA HASIL' YANG DISEMPURNAKAN         --}}
        {{-- ========================================================== --}}
        <div class="text-center py-5 my-5">
            <div class="display-4 text-muted mb-3">
                <i class="bi bi-folder-x"></i>
            </div>
            <h3 class="fw-normal">Tidak Ada Hasil Ditemukan</h3>
            <p class="lead text-muted">Kami tidak dapat menemukan apa pun untuk pencarian "{{ $query }}".<br>Silakan coba dengan kata kunci yang berbeda.</p>
        </div>
    @endif

    {{-- Modal Pejabat (Struktur tidak berubah) --}}
    <div class="modal fade" id="pejabatModal" tabindex="-1" aria-labelledby="pejabatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
</div>
@endsection