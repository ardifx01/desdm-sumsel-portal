@extends('layouts.public_app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Struktur Organisasi</li>
            </ol>
        </nav>
        <h1>Struktur Organisasi</h1>
        <h3>Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</h3>
        <h6 class="text-center mb-4"><i>Sesuai Peraturan Gubernur Sumatera Selatan Nomor 79 Tahun 2016 </br>
            tentang Susunan Organisasi, Uraian Tugas dan Fungsi Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</i></h6>
    </div>

    @if($kepalaDinas)
    <div class="row justify-content-center mb-3">
        <div class="col-md-4 text-center">
            <div class="card p-3 shadow-sm">
                @php
                    $imageUrl = null;
                    // Cek apakah ada media dan dapatkan URL-nya
                    if ($kepalaDinas->hasMedia('foto_pejabat')) {
                        $media = $kepalaDinas->getFirstMedia('foto_pejabat');
                        // Cek apakah file fisik media ada di disk
                        if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                            $imageUrl = $media->getUrl('thumb');
                        }
                    }
                @endphp

                @if ($imageUrl)
                    <img src="{{ $imageUrl }}" alt="Foto {{ $kepalaDinas->nama }}" class="img-fluid rounded-circle mx-auto d-block mb-3" style="width: 150px; height: 150px; object-fit: cover;" loading="lazy">
                @else
                    <img src="https://placehold.co/150x150/E5E7EB/6B7280?text=No+Photo" alt="No Photo" class="img-fluid rounded-circle mx-auto d-block mb-3" style="width: 150px; height: 150px; object-fit: cover;" loading="lazy">
                @endif

                <h5>
                    <a href="{{ route('tentang-kami.detail-pimpinan', $kepalaDinas->id) }}">
                        <b>{{ $kepalaDinas->nama }}</b>
                    </a>
                </h5>
                <p class="text-muted">{{ $kepalaDinas->jabatan }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Bagian Bidang dengan tata letak card hierarkis --}}

    <div class="row g-3 justify-content-center">
        @foreach($bidangs as $index => $bidang)
            <div class="col-md-4 d-flex">
                <div class="card p-3 shadow-sm w-100 h-100">
                    <h6 class="text-center mb-3 text-primary text-nowrap overflow-hidden text-truncate" title="{{ $bidang->nama }}">
                        <a href="{{ route('bidang-sektoral.show', $bidang->slug) }}" class="text-decoration-none text-primary">
                            {{ $bidang->nama }}
                        </a>
                    </h6>
                    
                    {{-- Card untuk Kepala Bidang --}}
                    @if($bidang->kepala)
                    <div class="row justify-content-center">
                        <div class="col-12 d-flex">
                            <div class="card p-2 h-100 shadow-sm w-100 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        @php
                                            $imageUrl = null;
                                            // Cek apakah ada media dan dapatkan URL-nya
                                            if ($bidang->kepala->hasMedia('foto_pejabat')) {
                                                $media = $bidang->kepala->getFirstMedia('foto_pejabat');
                                                // Cek apakah file fisik media ada di disk
                                                if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                                                    $imageUrl = $media->getUrl('thumb');
                                                }
                                            }
                                        @endphp

                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="Foto {{ $bidang->kepala->nama }}" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <img src="https://placehold.co/50x50/E5E7EB/6B7280?text=NP" alt="No Photo" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $bidang->kepala->nama }}">
                                            <a href="{{ route('tentang-kami.detail-pimpinan', $bidang->kepala->id) }}">{{ $bidang->kepala->nama }}</a>
                                        </small>
                                        <small class="text-muted d-block text-nowrap overflow-hidden text-truncate" title="{{ $bidang->kepala->jabatan }}">{{ $bidang->kepala->jabatan }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Seksi-seksi di bawah Bidang dengan garis penghubung --}}
                    @if($bidang->seksis->count() > 0)
                    <div class="mt-2 pt-2 border-top">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="child-card-container position-relative">
                                    @foreach($bidang->seksis as $seksi)
                                    <div class="child-card-item position-relative mb-2">
                                        <div class="card p-2 h-100 shadow-sm w-100">
                                            @if($seksi->kepala)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    @php
                                                        $imageUrl = null;
                                                        // Cek apakah ada media dan dapatkan URL-nya
                                                        if ($seksi->kepala->hasMedia('foto_pejabat')) {
                                                            $media = $seksi->kepala->getFirstMedia('foto_pejabat');
                                                            // Cek apakah file fisik media ada di disk
                                                            if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                                                                $imageUrl = $media->getUrl('thumb');
                                                            }
                                                        }
                                                    @endphp
                                                    @if ($imageUrl)
                                                        <img src="{{ $imageUrl }}" alt="Foto {{ $seksi->kepala->nama }}" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <img src="https://placehold.co/50x50/E5E7EB/6B7280?text=NP" alt="No Photo" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->nama }}">
                                                        <a href="{{ route('tentang-kami.detail-pimpinan', $seksi->kepala->id) }}">{{ $seksi->kepala->nama }}</a>
                                                    </small>
                                                    <small class="text-muted d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->jabatan }}">{{ $seksi->kepala->jabatan }}</small>
                                                </div>
                                            </div>
                                            @else
                                            <div class="text-center">
                                                <small class="fw-bold d-block">{{ $seksi->nama_seksi }}</small>
                                                <small class="text-muted d-block">Kepala Seksi (belum ditugaskan)</small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <hr class="my-5">

{{-- Bagian UPTD --}}

    <h3 class="text-center">Struktur Unit Pelaksana Teknis Dinas</h3>
    <h6 class="text-center mb-4"><i>Sesuai Peraturan Gubernur Sumatera Selatan Nomor 11 Tahun 2018 </br>
    tentang tentang Pembentukan, Uraian Tugas dan Fungsi Unit Pelaksana Teknis Dinas Geologi dan Laboratorium </br>
    pada Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</i></h6>
    <div class="row g-3 justify-content-center">
        @foreach($uptds as $uptd)
        <div class="col-md-9"> {{-- Main column for each UPTD unit, no d-flex here --}}
            <div class="card p-3 shadow-sm w-100 h-100"> {{-- Card for the entire UPTD block --}}
                
                <h6 class="text-center mb-3 text-primary text-nowrap overflow-hidden text-truncate" title="{{ $uptd->nama }}">
                        <a href="{{ route('bidang-sektoral.show', $uptd->slug) }}" class="text-decoration-none text-primary">
                            {{ $uptd->nama }}
                        </a>
                    </h6>
                    {{-- Card for Kepala UPTD, centered and styled like a section card --}}
                    @if($uptd->kepala)
                    <div class="row justify-content-center"> {{-- Row to center the head card --}}
                        <div class="col-md-4 col-sm-6 d-flex"> {{-- Column for the head card, same width as sections --}}
                            <div class="card p-1 h-100 shadow-sm w-100"> {{-- Small card style --}}
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        @php
                                            $imageUrl = null;
                                            // Cek apakah ada media dan dapatkan URL-nya
                                            if ($uptd->kepala->hasMedia('foto_pejabat')) {
                                                $media = $uptd->kepala->getFirstMedia('foto_pejabat');
                                                // Cek apakah file fisik media ada di disk
                                                if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                                                    $imageUrl = $media->getUrl('thumb');
                                                }
                                            }
                                        @endphp
                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="Foto {{ $uptd->kepala->nama }}" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                        @else
                                            <img src="https://placehold.co/30x30/E5E7EB/6B7280?text=NP" alt="No Photo" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $uptd->kepala->nama }}">
                                            <a href="{{ route('tentang-kami.detail-pimpinan', $uptd->kepala->id) }}">{{ $uptd->kepala->nama }}</a>
                                        </small>
                                        <small class="text-muted d-block text-nowrap overflow-hidden text-truncate" title="{{ $uptd->kepala->jabatan }}">{{ $uptd->kepala->jabatan }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mb-3 text-center">
                        <small class="fw-bold d-block">{{ $uptd->nama }}</small>
                        <small class="text-muted d-block">Kepala UPTD (belum ditugaskan)</small>
                    </div>
                    @endif

                    {{-- Seksi-seksi di bawah UPTD: 3 sejajar --}}
                    @if($uptd->seksis->count() > 0)
                    <div class="mt-3 border-top pt-3"> {{-- Padding top disesuaikan --}}
                        <div class="row g-2 justify-content-center"> {{-- Gunakan row untuk seksi sejajar --}}
                            @foreach($uptd->seksis as $seksi)
                            <div class="col-md-4 col-sm-8 d-flex"> {{-- Setiap seksi mengambil 1/3 lebar kolom UPTD, responsif --}}
                                <div class="card p-2 h-100 shadow-sm w-100"> {{-- Kartu kecil untuk setiap seksi --}}
                                    @if($seksi->kepala)
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            @php
                                                $imageUrl = null;
                                                // Cek apakah ada media dan dapatkan URL-nya
                                                if ($seksi->kepala->hasMedia('foto_pejabat')) {
                                                    $media = $seksi->kepala->getFirstMedia('foto_pejabat');
                                                    // Cek apakah file fisik media ada di disk
                                                    if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                                                        $imageUrl = $media->getUrl('thumb');
                                                    }
                                                }
                                            @endphp
                                            @if ($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="Foto {{ $seksi->kepala->nama }}" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <img src="https://placehold.co/30x30/E5E7EB/6B7280?text=NP" alt="No Photo" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->nama }}">
                                                <a href="{{ route('tentang-kami.detail-pimpinan', $seksi->kepala->id) }}">{{ $seksi->kepala->nama }}</a>
                                            </small>
                                            <small class="text-muted d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->jabatan }}">{{ $seksi->kepala->jabatan }}</small>
                                        </div>
                                    </div>
                                    @else
                                    <div class="text-center">
                                        <small class="fw-bold d-block">{{ $seksi->nama_seksi }}</small>
                                        <small class="text-muted d-block">Kasi (belum ditugaskan)</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
            </div>
        </div>
        @endforeach
    </div>
    
    <hr class="my-5">

    {{-- Bagian Cabang Dinas dengan tata letak card hierarkis --}}
    <h3 class="text-center">Struktur Cabang Dinas</h3>
    <h6 class="text-center mb-4"><i>Sesuai Peraturan Gubernur Sumatera Selatan Nomor 14 Tahun 2018 </br>
        tentang tentang Pembentukan, Uraian Tugas dan Fungsi Cabang Dinas </br>
        pada Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</i></h6>
    <div class="row g-3 justify-content-center">
        @foreach($cabangDinas as $cabang)
        <div class="col-md-3">
            <div class="card p-3 shadow-sm w-100 h-100">
                
                <h6 class="text-center mb-3 text-primary text-nowrap overflow-hidden text-truncate" title="{{ $cabang->nama }}">
                    <a href="{{ route('bidang-sektoral.show', $cabang->slug) }}" class="text-decoration-none text-primary">
                        {{ $cabang->nama }}
                    </a>
                </h6>
                {{-- Card for Kepala cabang --}}
                @if($cabang->kepala)
                <div class="row justify-content-center">
                    <div class="col-md-12 col-sm-4 d-flex">
                        <div class="card p-2 h-100 shadow-sm w-100 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    @php
                                        $imageUrl = null;
                                        // Cek apakah ada media dan dapatkan URL-nya
                                        if ($cabang->kepala->hasMedia('foto_pejabat')) {
                                            $media = $cabang->kepala->getFirstMedia('foto_pejabat');
                                            // Cek apakah file fisik media ada di disk
                                            if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                                                $imageUrl = $media->getUrl('thumb');
                                            }
                                        }
                                    @endphp
                                    @if ($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="Foto {{ $cabang->kepala->nama }}" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                    @else
                                        <img src="https://placehold.co/30x30/E5E7EB/6B7280?text=NP" alt="No Photo" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $cabang->kepala->nama }}">
                                        <a href="{{ route('tentang-kami.detail-pimpinan', $cabang->kepala->id) }}">{{ $cabang->kepala->nama }}</a>
                                    </small>
                                    <small class="text-muted d-block text-nowrap overflow-hidden text-truncate" title="{{ $cabang->kepala->jabatan }}">{{ $cabang->kepala->jabatan }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-3 text-center">
                    <small class="fw-bold d-block">{{ $cabang->nama }}</small>
                    <small class="text-muted d-block">Kepala Cabang (belum ditugaskan)</small>
                </div>
                @endif

                {{-- Seksi-seksi di bawah Cabang Dinas dengan garis penghubung --}}
                @if($cabang->seksis->count() > 0)
                <div class="mt-3 border-top pt-3">
                    <div class="row g-2 justify-content-center">
                        <div class="col-12">
                            <div class="child-card-container position-relative" style="padding-left: 20px;">
                                @foreach($cabang->seksis as $seksi)
                                <div class="child-card-item position-relative mb-2">
                                    <div class="card p-2 h-100 shadow-sm w-100">
                                        @if($seksi->kepala)
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                @php
                                                    $imageUrl = null;
                                                    // Cek apakah ada media dan dapatkan URL-nya
                                                    if ($seksi->kepala->hasMedia('foto_pejabat')) {
                                                        $media = $seksi->kepala->getFirstMedia('foto_pejabat');
                                                        // Cek apakah file fisik media ada di disk
                                                        if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
                                                            $imageUrl = $media->getUrl('thumb');
                                                        }
                                                    }
                                                @endphp
                                                @if ($imageUrl)
                                                    <img src="{{ $imageUrl }}" alt="Foto {{ $seksi->kepala->nama }}" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                                @else
                                                    <img src="https://placehold.co/30x30/E5E7EB/6B7280?text=NP" alt="No Photo" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->nama }}">
                                                    <a href="{{ route('tentang-kami.detail-pimpinan', $seksi->kepala->id) }}">{{ $seksi->kepala->nama }}</a>
                                                </small>
                                                <small class="text-muted d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->jabatan }}">{{ $seksi->kepala->jabatan }}</small>
                                            </div>
                                        </div>
                                        @else
                                        <div class="text-center">
                                            <small class="fw-bold d-block">{{ $seksi->nama_seksi }}</small>
                                            <small class="text-muted d-block">Kasi (belum ditugaskan)</small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.child-card-container {
    padding-left: 20px; /* Jarak untuk garis vertikal */
}

.child-card-item {
    padding-left: 20px; /* Jarak untuk garis horizontal */
}

.child-card-container::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 10px; /* Posisi garis vertikal */
    width: 2px;
    background-color: #aeb3b8; /* Warna garis */
    z-index: 1;
}

.child-card-item::before {
    content: '';
    position: absolute;
    top: 50%;
    left: -10px; /* Posisi garis horizontal */
    width: 20px;
    height: 2px;
    background-color: #aeb3b8; /* Warna garis */
    z-index: 2;
}

.child-card-item:last-child::before {
    height: 2px;
}

</style>
@endsection