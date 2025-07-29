@extends('layouts.public_app')

@section('title', $dokumen->judul)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('publikasi.index') }}">Publikasi & Dokumen Resmi</a></li>
            <li class="breadcrumb-item"><a href="{{ route('publikasi.index', ['kategori' => $dokumen->category->slug]) }}">{{ $dokumen->category->nama }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($dokumen->judul, 50) }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="card-title mb-3">{{ $dokumen->judul }}</h2>
            <p class="card-text text-muted small">
                <span class="badge bg-secondary me-2">{{ $dokumen->category->nama }}</span>
                <i class="bi bi-calendar"></i> Dipublikasi: {{ $dokumen->tanggal_publikasi ? $dokumen->tanggal_publikasi->translatedFormat('d F Y') : '-' }} |
                <i class="bi bi-eye"></i> Dilihat: {{ $dokumen->hits }}
            </p>
            <hr>

            <div class="dokumen-deskripsi mb-4">
                {!! nl2br(e($dokumen->deskripsi)) !!} {{-- Menggunakan nl2br dan e untuk keamanan --}}
            </div>

            @if($dokumen->file_path)
                <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                    <div>
                        <i class="bi bi-file-earmark-arrow-down-fill me-2"></i> File Dokumen: {{ $dokumen->file_nama ?: 'Dokumen' }} ({{ strtoupper($dokumen->file_tipe) }})
                    </div>
                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="bi bi-download"></i> Unduh Dokumen
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('publikasi.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Publikasi</a>
    </div>
</div>
@endsection