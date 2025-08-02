@extends('layouts.public_app')

@section('title', 'Detail Profil ' . $pejabat->nama)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tentang-kami.profil-pimpinan') }}">Profil Pimpinan</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pejabat->nama }}</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">

               
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if ($pejabat->hasMedia('foto_pejabat'))
                                <picture>
                                    <source
                                        srcset="{{ $pejabat->getFirstMedia('foto_pejabat')->getSrcset('webp-responsive') }}"
                                        type="image/webp"
                                    >
                                    <img
                                        src="{{ $pejabat->getFirstMediaUrl('foto_pejabat', 'thumb') }}"
                                        alt="Foto {{ $pejabat->nama }}"
                                        class="img-fluid rounded-start"
                                        width=auto
                                        loading="lazy"
                                    >
                                </picture>
                            @else
                                <img src="https://placehold.co/400x400/E5E7EB/6B7280?text=No+Photo" 
                                    alt="No Photo"
                                    class="img-fluid rounded-start"
                                    width=auto
                                    loading="lazy"
                                >
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body h-100 d-flex flex-column justify-content-center">
                                <h3 class="card-title">{{ $pejabat->nama }}</h3>
                                <h5 class="text-muted">{{ $pejabat->jabatan }}</h5>
                                    <div class="p-2">
                                        @if($pejabat->deskripsi_singkat)
                                            <div class="pejabat-deskripsi">
                                                {!! ($pejabat->deskripsi_singkat) !!}
                                            </div>
                                        @else
                                            <p class="text-muted text-center">Deskripsi singkat belum tersedia untuk pejabat ini.</p>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                

            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('tentang-kami.profil-pimpinan') }}" class="btn btn-secondary me-2">Kembali ke Daftar Pimpinan</a>
        <a href="{{ route('tentang-kami.index') }}" class="btn btn-outline-secondary">Kembali ke Tentang Kami</a>
    </div>
</div>
@endsection