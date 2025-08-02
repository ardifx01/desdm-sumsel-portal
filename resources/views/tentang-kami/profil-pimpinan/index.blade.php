@extends('layouts.public_app')

@section('title', 'Profil Pimpinan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Pimpinan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Profil Pimpinan Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="row">
        @forelse($pejabat as $p)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 pejabat-card">
                <div class="card-body text-center">
                    @if($p->hasMedia('foto_pejabat'))
                        <img
                            src="{{ $p->getFirstMediaUrl('foto_pejabat', 'thumb') }}"
                            alt="Foto {{ $p->nama }}"
                            class="img-thumbnail mb-3"
                            style="width: 150px; height: 150px; object-fit: cover;"
                            loading="lazy"
                        />
                    @else
                        <img
                            src="https://placehold.co/150x150/E5E7EB/6B7280?text=No+Photo"
                            alt="No Photo"
                            class="img-thumbnail rounded mb-3"
                            style="width: 150px; height: 150px; object-fit: cover;"
                        />
                    @endif
                    <h5 class="card-title">{{ $p->nama }}</h5>
                    <p class="card-text text-muted mb-2">{{ $p->jabatan }}</p>
                    @if($p->nip)
                        <p class="card-text small text-secondary">NIP: {{ $p->nip }}</p>
                    @endif
                    <a href="{{ route('tentang-kami.detail-pimpinan', $p->id) }}" class="btn btn-sm btn-primary mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Belum ada data pimpinan yang tersedia.</p>
        </div>
        @endforelse
    </div>

    <a href="{{ route('tentang-kami.index') }}" class="btn btn-secondary mt-4">Kembali ke Tentang Kami</a>
</div>
@endsection