@extends('layouts.public_app')

@section('title', 'Daftar Informasi Publik (DIP)')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Informasi Publik (PPID)</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Daftar Informasi Publik (DIP) Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('informasi-publik.index') }}" method="GET" class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari informasi publik..." value="{{ request('q') }}">
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
                    <a href="{{ route('informasi-publik.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($informasiPublik as $info)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                @if($info->thumbnail)
                    <img src="{{ asset('storage/thumbnails/' . $info->thumbnail) }}" class="card-img-top" alt="{{ $info->judul }}" style="height: 180px; object-fit: cover;">
                @else
                    <img src="https://placehold.co/400x180?text=No+Thumbnail" class="card-img-top" alt="No Thumbnail" style="height: 180px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <span class="badge bg-info mb-2">{{ $info->category->nama }}</span>
                    <h5 class="card-title">{{ Str::limit($info->judul, 60) }}</h5>
                    <p class="card-text text-muted small">
                        <i class="bi bi-calendar"></i> {{ $info->tanggal_publikasi ? $info->tanggal_publikasi->translatedFormat('d M Y') : '-' }} |
                        <i class="bi bi-eye"></i> {{ $info->hits }} Dilihat
                    </p>
                    <p class="card-text">{{ Str::limit(strip_tags($info->konten), 100) }}</p>
                    <a href="{{ route('informasi-publik.show', $info->slug) }}" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                    @if($info->file_path)
                        <a href="{{ asset('storage/' . $info->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success ms-2">
                            <i class="bi bi-download"></i> Unduh File
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="lead text-muted">Tidak ada informasi publik yang ditemukan.</p>
            <p>Coba sesuaikan pencarian atau filter Anda.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $informasiPublik->links('pagination::bootstrap-5') }} {{-- Menggunakan pagination Bootstrap --}}
    </div>
</div>

{{-- Font Awesome untuk ikon unduh, jika belum diinstal di layout --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{-- Bootstrap Icons juga bisa digunakan jika prefer --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection