@extends('layouts.public_app')

@section('title', 'Daftar Informasi Publik (DIP)')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Informasi Publik</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Daftar Informasi Publik (DIP)</h1>
        <p class="lead text-muted">Akses informasi yang wajib disediakan dan diumumkan secara berkala oleh Dinas ESDM Sumsel.</p>
    </div>
</div>

<div class="container py-5">
    {{-- Form Pencarian yang Ditingkatkan --}}
    <div class="row mb-5">
        <div class="col-md-10 mx-auto">
            <div class="card border-0 shadow-sm p-2">
                <form action="{{ route('informasi-publik.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-lg border-0" placeholder="Ketik kata kunci informasi..." value="{{ request('q') }}">
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
                        <a href="{{ route('informasi-publik.index') }}" class="btn btn-light btn-lg">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($informasiPublik as $info)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0 info-card"> {{-- Menggunakan kelas info-card baru --}}
                <a href="{{ route('informasi-publik.show', $info->slug) }}" class="text-decoration-none">
                    <div class="card-img-top-wrapper">
                        @if($info->thumbnail && Storage::disk('public')->exists('thumbnails/' . $info->thumbnail))
                            <img src="{{ asset('storage/thumbnails/' . $info->thumbnail) }}" class="card-img-top" alt="{{ $info->judul }}" loading="lazy" style="height: 100%; width: 100%; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                <i class="bi bi-card-text fs-1 text-muted"></i>
                            </div>
                        @endif
                    </div>
                </a>
                <div class="card-body d-flex flex-column">
                    <div>
                        @if($info->category)
                        <span class="badge {{ $info->category->frontend_badge_class }} mb-2">
                            {{ $info->category->nama }}
                        </span>
                        @endif
                        <h5 class="card-title fw-bold">
                            <a href="{{ route('informasi-publik.show', $info->slug) }}" class="card-title">{{ Str::limit($info->judul, 60) }}</a>
                        </h5>
                        <p class="card-text text-muted small mb-2">
                            <i class="bi bi-calendar3"></i> {{ $info->updated_at ? $info->updated_at->translatedFormat('d M Y') : '-' }} &nbsp;
                            <i class="bi bi-eye-fill"></i> {{ $info->hits }} Dilihat
                        </p>
                    </div>
                    <div class="mt-auto pt-2">
                        <a href="{{ route('informasi-publik.show', $info->slug) }}" class="btn btn-sm btn-outline-primary">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <h4 class="mt-3">Informasi Tidak Ditemukan</h4>
            <p class="text-muted">Maaf, tidak ada informasi publik yang cocok dengan kriteria pencarian Anda.</p>
            <a href="{{ route('informasi-publik.index') }}" class="btn btn-primary">Kembali ke Semua Informasi</a>
        </div>
        @endforelse
    </div>

    @if ($informasiPublik->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $informasiPublik->links('pagination::bootstrap-5') }}
    </div>
    @endif
    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>    
</div>
@endsection