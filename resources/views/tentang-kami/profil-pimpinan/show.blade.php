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
                <div class="card-body">
                    <div class="text-center mb-4">
                        <x-placeholder-image
                            :src="asset('storage/' . $pejabat->foto)"

                            alt="Foto {{ $pejabat->nama }}"
                            class="card-img-top"
                            style="width: auto; object-fit: cover;"
                        />                        
                        <h2 class="card-title mt-3">{{ $pejabat->nama }}</h2>
                        <h5 class="text-muted">{{ $pejabat->jabatan }}</h5>
                        @if($pejabat->nip)
                            <p class="text-secondary">NIP: {{ $pejabat->nip }}</p>
                        @endif
                    </div>
                    <hr>
                    @if($pejabat->deskripsi_singkat)
                        <div class="pejabat-deskripsi">
                            {!! nl2br(e($pejabat->deskripsi_singkat)) !!} {{-- Gunakan nl2br dan e untuk keamanan --}}
                        </div>
                    @else
                        <p class="text-muted text-center">Deskripsi singkat belum tersedia untuk pejabat ini.</p>
                    @endif
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