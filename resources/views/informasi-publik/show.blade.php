@extends('layouts.public_app')

@section('title', $informasi->judul)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik</a></li>
                @if($informasi->category)
                    <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index', ['kategori' => $informasi->category->slug]) }}">{{ $informasi->category->nama }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($informasi->judul, 30) }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $informasi->judul }}</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        {{-- Kolom Konten Utama (Kiri) --}}
        <div class="col-lg-8">
            <div class="content-body">
                @if($informasi->thumbnail && Storage::disk('public')->exists('thumbnails/' . $informasi->thumbnail))
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/thumbnails/' . $informasi->thumbnail) }}" class="img-fluid rounded shadow-sm" alt="{{ $informasi->judul }}" style="max-height: 400px; object-fit: contain;">
                    </div>
                @endif
                
                {!! $informasi->konten !!}
            </div>
        </div>

        {{-- Kolom Sidebar (Kanan) --}}
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pt-3">
                        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-info-circle-fill me-2"></i>Detail Informasi</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-3">
                            <li>
                                <strong class="d-block">Kategori:</strong>
                                @if($informasi->category)
                                    <span class="badge {{ $informasi->category->frontend_badge_class }} fs-6">
                                        {{ $informasi->category->nama }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">Tanpa Kategori</span>
                                @endif
                            </li>
                            <li>
                                <strong class="d-block">Dipublikasi:</strong>
                                <span>{{ $informasi->updated_at ? $informasi->updated_at->translatedFormat('d F Y, H:i') : '-' }}</span>
                            </li>
                            <li>
                                <strong class="d-block">Dilihat:</strong>
                                <span>{{ $informasi->hits }} kali</span>
                            </li>
                            @if($informasi->file_path && Storage::disk('public')->exists($informasi->file_path))
                            <li>
                                <strong class="d-block">Format File:</strong>
                                <span class="text-uppercase">{{ pathinfo($informasi->file_path, PATHINFO_EXTENSION) }}</span>
                            </li>
                            <li>
                                <strong class="d-block">Ukuran File:</strong>
                                <span>{{ number_format(Storage::disk('public')->size($informasi->file_path) / 1024, 1) }} KB</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @if($informasi->file_path)
                        <div class="card-footer p-3">
                            {{-- PERUBAHAN: Teks tombol disederhanakan --}}
                            <a href="{{ asset('storage/' . $informasi->file_path) }}" target="_blank" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-download me-2"></i> Unduh Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection