@extends('layouts.public_app')

@section('title', $title)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Berita</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $title }}</h1>
        <p class="lead text-muted">Temukan informasi dan perkembangan terbaru dari Dinas ESDM Sumsel.</p>
    </div>
</div>

<div class="container py-5">
   
    <div class="row my-4">
        <div class="col-md-10 mx-auto">
            <div class="card border-0 shadow-sm p-2">
                <form action="{{ route('berita.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-lg border-0" placeholder="Ketik kata kunci berita..." value="{{ request('q') }}">
                    <select name="kategori" class="form-select form-select-lg border-0" style="width: auto;">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-search"></i></button>
                    @if(request('q') || request('kategori') != 'all')
                        <a href="{{ route('berita.index') }}" class="btn btn-light btn-lg">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Container baru untuk menampung semua kartu berita --}}
    <div class="row" id="post-container">
        @forelse($posts as $post)
            {{-- Panggil partial untuk setiap post --}}
            @include('berita.partials.post-card', ['post' => $post])
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x fs-1 text-muted"></i>
                <h4 class="mt-3">Berita Tidak Ditemukan</h4>
                <p class="text-muted">Maaf, tidak ada berita yang cocok dengan kriteria pencarian Anda.</p>
                <a href="{{ route('berita.index') }}" class="btn btn-primary">Kembali ke Semua Berita</a>
            </div>
        @endforelse
    </div>

    {{-- Tombol "Muat Lebih Banyak" akan muncul di sini --}}
    <div class="text-center mt-4" id="load-more-container">
        @if ($posts->nextPageUrl())
            <a href="{{ $posts->nextPageUrl() }}" id="load-more-btn" class="btn btn-primary btn-lg">
                <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                Muat Lebih Banyak
            </a>
        @endif
    </div>

</div>
@endsection