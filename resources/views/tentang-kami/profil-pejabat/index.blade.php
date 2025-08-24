@extends('layouts.public_app')

@section('title', 'Profil Pejabat')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil Pejabat</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Profil Pejabat Dinas ESDM</h1>
        <p class="lead text-muted">Mengenal para pejabat struktural di lingkungan Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @forelse($pejabat as $p)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="#" class="card leadership-card text-decoration-none"
                    data-bs-toggle="modal"
                    data-bs-target="#pejabatModal"
                    data-pejabat-id="{{ $p->id }}">
                    
                    <div class="card-img-wrapper">
                        {{-- Accessor yang sudah diperbaiki akan dipanggil di sini --}}
                        <img src="{{ $p->foto_url }}" alt="{{ $p->foto_alt_text }}" class="card-img" loading="lazy">
                    </div>

                    <div class="card-body-overlay">
                        <h5 class="card-title">{{ $p->nama }}</h5>
                        <p class="card-text mb-0">{{ $p->jabatan }}</p>
                        @if($p->nip)
                            <p class="card-text small">NIP: {{ $p->nip }}</p>
                        @endif
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-person-x fs-1 text-muted"></i>
                <h4 class="mt-3">Data Pejabat Belum Tersedia</h4>
                <p class="text-muted">Saat ini belum ada data pejabat yang dapat ditampilkan.</p>
            </div>
        @endforelse
    </div>
    <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>    
</div>

{{-- Modal (tidak berubah dan akan tetap berfungsi) --}}
<div class="modal fade" id="pejabatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

@endsection