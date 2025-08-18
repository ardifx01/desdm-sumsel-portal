@extends('layouts.public_app')

@section('title', $dokumen->judul)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('publikasi.index') }}">Publikasi & Dokumen</a></li>
                @if($dokumen->category)
                    <li class="breadcrumb-item"><a href="{{ route('publikasi.index', ['kategori' => $dokumen->category->slug]) }}">{{ $dokumen->category->nama }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($dokumen->judul, 30) }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $dokumen->judul }}</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        {{-- Kolom Konten Utama (Kiri) --}}
        <div class="col-lg-8">
            <div class="content-body">
                {!! nl2br(e($dokumen->deskripsi)) !!}
            </div>
        </div>

        {{-- Kolom Sidebar (Kanan) --}}
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pt-3">
                        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-info-circle-fill me-2"></i>Detail Dokumen</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-3">
                            <li>
                                <strong class="d-block">Kategori:</strong>
                                @if($dokumen->category)
                                    <span class="badge {{ $dokumen->category->frontend_badge_class }} fs-6">
                                        {{ $dokumen->category->nama }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">Tanpa Kategori</span>
                                @endif
                            </li>
                            <li>
                                <strong class="d-block">Dipublikasi:</strong>
                                <span>{{ $dokumen->tanggal_publikasi ? $dokumen->tanggal_publikasi->translatedFormat('d F Y') : '-' }}</span>
                            </li>
                            <li>
                                <strong class="d-block">Dilihat:</strong>
                                <span>{{ $dokumen->hits }} kali</span>
                            </li>

                            @if($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path))
                            <li>
                                <strong class="d-block">Format File:</strong>
                                <span class="text-uppercase">{{ $dokumen->file_tipe }}</span>
                            </li>
                            <li>
                                <strong class="d-block">Ukuran File:</strong>
                                <span>{{ number_format(Storage::disk('public')->size($dokumen->file_path) / 1024, 1) }} KB</span>
                            </li>
                            @endif

                        </ul>
                    </div>
                    @if($dokumen->file_path)
                        <div class="card-footer p-3">
                            {{-- PERUBAHAN: Teks tombol disederhanakan --}}
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-download me-2"></i> Unduh Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection