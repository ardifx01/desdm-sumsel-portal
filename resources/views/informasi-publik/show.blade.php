@extends('layouts.public_app')

@section('title', $informasi->judul)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index', ['kategori' => $informasi->category->slug]) }}">{{ $informasi->category->nama }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($informasi->judul, 50) }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="card-title mb-3">{{ $informasi->judul }}</h2>
            <p class="card-text text-muted small">
                <span class="badge bg-info me-2">{{ $informasi->category->nama }}</span>
                <i class="bi bi-calendar"></i> Dipublikasi: {{ $informasi->tanggal_publikasi ? $informasi->tanggal_publikasi->translatedFormat('d F Y H:i') : '-' }} |
                <i class="bi bi-eye"></i> Dilihat: {{ $informasi->hits }}
            </p>
            <hr>

            @if($informasi->thumbnail)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/thumbnails/' . $informasi->thumbnail) }}" class="img-fluid rounded" alt="{{ $informasi->judul }}" style="max-height: 400px; object-fit: contain;">
                </div>
            @endif

            <div class="informasi-konten mb-4">
                {!! $informasi->konten !!} {{-- Konten sudah HTML, gunakan {!! !!} --}}
            </div>

            @if($informasi->file_path)
                <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                    <div>
                        <i class="bi bi-file-earmark-arrow-down-fill me-2"></i> File Terkait: {{ $informasi->file_nama ?: 'Dokumen' }} ({{ strtoupper($informasi->file_tipe) }})
                    </div>
                    <a href="{{ asset('storage/' . $informasi->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="bi bi-download"></i> Unduh Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('informasi-publik.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Informasi Publik</a>
    </div>
</div>

{{-- Pastikan Bootstrap Icons terinstal atau tambahkan CDN di layout utama --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection