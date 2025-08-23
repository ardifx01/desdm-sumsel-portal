@extends('layouts.public_app')

@section('title', $page->title)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $page->title }}</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card content-card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="row g-5">
                        {{-- Kolom Konten Utama (Kiri) --}}
                        <div class="col-lg-8">
                            <div class="content-body">
                                {!! $page->content !!}
                            </div>
                        </div>

                        {{-- Kolom Sidebar (Kanan) --}}
                        <div class="col-lg-4">
                            <div class="sidebar-widget">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h5 class="fw-bold"><i class="bi bi-clock-history me-2"></i>Informasi Halaman</h5>
                                        <hr>
                                        <p class="mb-0"><strong>Terakhir diperbarui:</strong></p>
                                        <p class="text-muted">{{ $page->updated_at->translatedFormat('d F Y, H:i') }}</p>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>
@endsection