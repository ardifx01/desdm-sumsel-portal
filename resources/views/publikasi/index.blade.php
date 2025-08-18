@extends('layouts.public_app')

@section('title', 'Publikasi & Dokumen Resmi')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Publikasi & Dokumen</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Publikasi & Dokumen Resmi</h1>
        <p class="lead text-muted">Akses dokumen perencanaan, regulasi, dan laporan kinerja dari Dinas ESDM Sumsel.</p>
    </div>
</div>

<div class="container py-5">
    {{-- Form Pencarian yang Ditingkatkan --}}
    <div class="row mb-5">
        <div class="col-md-10 mx-auto">
            <div class="card border-0 shadow-sm p-2">
                <form action="{{ route('publikasi.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-lg border-0" placeholder="Ketik nama dokumen..." value="{{ request('q') }}">
                    <select name="kategori" class="form-select form-select-lg border-0" style="width: auto;">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->nama }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-search"></i></button>
                    @if(request('q') || request('kategori') != 'all')
                        <a href="{{ route('publikasi.index') }}" class="btn btn-light btn-lg">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($dokumen as $doc)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0 info-card">
                <a href="{{ route('publikasi.show', $doc->slug) }}" class="text-decoration-none">
                    <div class="card-img-top-wrapper">
                        {{-- Placeholder Ikon berdasarkan Tipe File --}}
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            @php
                                $iconClass = 'bi-file-earmark-text'; // default
                                if (Str::contains($doc->file_tipe, 'pdf')) $iconClass = 'bi-file-earmark-pdf';
                                elseif (Str::contains($doc->file_tipe, ['word', 'doc'])) $iconClass = 'bi-file-earmark-word';
                                elseif (Str::contains($doc->file_tipe, ['excel', 'xls'])) $iconClass = 'bi-file-earmark-excel';
                            @endphp
                            <i class="bi {{ $iconClass }} fs-1 text-muted"></i>
                        </div>
                    </div>
                </a>
                <div class="card-body d-flex flex-column">
                    <div>
                        @if($doc->category)
                        <span class="badge {{ $doc->category->frontend_badge_class }} mb-2">
                            {{ $doc->category->nama }}
                        </span>
                        @endif
                        <h5 class="card-title fw-bold">
                            <a href="{{ route('publikasi.show', $doc->slug) }}" class="card-title">{{ Str::limit($doc->judul, 60) }}</a>
                        </h5>
                        <p class="card-text text-muted small mb-2">
                            <i class="bi bi-calendar3"></i> {{ $doc->tanggal_publikasi ? $doc->tanggal_publikasi->translatedFormat('d M Y') : '-' }} &nbsp;
                            <i class="bi bi-eye-fill"></i> {{ $doc->hits }} Dilihat
                        </p>
                    </div>
                    <div class="mt-auto pt-2">
                        <a href="{{ route('publikasi.show', $doc->slug) }}" class="btn btn-sm btn-outline-primary">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <h4 class="mt-3">Dokumen Tidak Ditemukan</h4>
            <p class="text-muted">Maaf, tidak ada dokumen publikasi yang cocok dengan kriteria pencarian Anda.</p>
            <a href="{{ route('publikasi.index') }}" class="btn btn-primary">Kembali ke Semua Publikasi</a>
        </div>
        @endforelse
    </div>

    @if ($dokumen->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $dokumen->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection