@extends('layouts.public_app')

@section('title', 'Publikasi & Dokumen Resmi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Publikasi & Dokumen Resmi</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Publikasi & Dokumen Resmi Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('publikasi.index') }}" method="GET" class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari dokumen..." value="{{ request('q') }}">
                <select name="kategori" class="form-select">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->nama }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Cari / Filter</button>
                @if(request('q') || request('kategori') != 'all')
                    <a href="{{ route('publikasi.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($dokumen as $doc)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    @if($doc->category)
                        @php
                            $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
                            $colorIndex = ($doc->category->id ?? 0) % count($colors);
                            $badgeClass = 'badge-' . $colors[$colorIndex];
                        @endphp
                        <span class="badge {{ $badgeClass }} mb-2">
                            {{ $doc->category->nama }}
                        </span>
                    @else
                        <span class="badge badge-secondary mb-2">Tanpa Kategori</span>
                    @endif
                    <h5 class="card-title">{{ Str::limit($doc->judul, 60) }}</h5>
                    <p class="card-text text-muted small">
                        <i class="bi bi-calendar"></i> {{ $doc->tanggal_publikasi ? $doc->tanggal_publikasi->translatedFormat('d M Y') : '-' }} |
                        <i class="bi bi-eye"></i> {{ $doc->hits }} Dilihat
                    </p>
                    <p class="card-text">{{ Str::limit(strip_tags($doc->deskripsi), 100) }}</p>
                    <a href="{{ route('publikasi.show', $doc->slug) }}" class="btn btn-sm btn-primary">Baca Detail</a>
                    @if($doc->file_path)
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success ms-2">
                            <i class="bi bi-download"></i> Unduh File
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="lead text-muted">Tidak ada dokumen yang ditemukan.</p>
            <p>Coba sesuaikan pencarian atau filter Anda.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $dokumen->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Pastikan Bootstrap Icons terinstal atau tambahkan CDN di layout utama --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection