@extends('layouts.public_app')
@section('title', 'Struktur Organisasi')
@section('content')
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Struktur Organisasi</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Struktur Organisasi</h1>
    </div>
</div>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1>Struktur Organisasi</h1>
        <h3>Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</h3>
        <h6 class="text-center mb-4"><i>Sesuai Peraturan Gubernur Sumatera Selatan Nomor 79 Tahun 2016 </br>
            tentang Susunan Organisasi, Uraian Tugas dan Fungsi Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</i></h6>
    </div>

    @if($kepalaDinas)
    <div class="row justify-content-center mb-3">
        <div class="col-md-4 text-center">
            <div class="card p-3 shadow-sm">
                <img src="{{ $kepalaDinas->foto_url }}" alt="{{ $kepalaDinas->foto_alt_text }}" 
                class="img-fluid rounded-circle mx-auto d-block mb-3" style="width: 150px; height: 150px; object-fit: cover;" loading="lazy">

                <h5>
                    <a href="#" class="link-pejabat"
                    data-bs-toggle="modal"
                    data-bs-target="#pejabatModal"
                    data-pejabat-id="{{ $kepalaDinas->id }}">
                        <h5 class="fw-bold fs-4 mb-0">{{ $kepalaDinas->nama }}</h5>
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
                                        <img src="{{ $bidang->kepala->foto_url }}" alt="{{ $bidang->kepala->foto_alt_text }}" 
                                        class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $bidang->kepala->nama }}">
                                            <a href="#" class="text-decoration-none text-dark card-title mb-1 text-nowrap text-truncate link-pejabat"
                                                data-bs-toggle="modal"
                                                data-bs-target="#pejabatModal"
                                                data-pejabat-id="{{ $bidang->kepala->id }}">
                                                {{ $bidang->kepala->nama }}
                                            </a>
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
                                                    <img src="{{ $seksi->kepala->foto_url }}" alt="{{ $seksi->kepala->foto_alt_text }}" class="img-fluid rounded-circle" 
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->nama }}">
                                                        {{-- <a href="{{ route('tentang-kami.detail-pejabat', $seksi->kepala->id) }}">{{ $seksi->kepala->nama }}</a> --}}
                                                        <a href="#" class="text-decoration-none text-dark card-title mb-1 text-nowrap text-truncate link-pejabat"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#pejabatModal"
                                                            data-pejabat-id="{{ $seksi->kepala->id }}">
                                                            {{ $seksi->kepala->nama }}
                                                        </a>



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
                                        <img src="{{ $uptd->kepala->foto_url }}" alt="{{ $uptd->kepala->foto_alt_text }}" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $uptd->kepala->nama }}">
                                            {{-- <a href="{{ route('tentang-kami.detail-pejabat', $uptd->kepala->id) }}">{{ $uptd->kepala->nama }}</a> --}}
                                            <a href="#" class="text-decoration-none text-dark card-title mb-1 text-nowrap text-truncate link-pejabat"
                                                data-bs-toggle="modal"
                                                data-bs-target="#pejabatModal"
                                                data-pejabat-id="{{ $uptd->kepala->id }}">
                                                {{ $uptd->kepala->nama }}
                                            </a>                                            
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
                                            <img src="{{ $seksi->kepala->foto_url }}" alt="{{ $seksi->kepala->foto_alt_text }}" class="img-fluid rounded-circle" 
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->nama }}">
                                                {{-- <a href="{{ route('tentang-kami.detail-pejabat', $seksi->kepala->id) }}">{{ $seksi->kepala->nama }}</a> --}}
                                                <a href="#" class="text-decoration-none text-dark card-title mb-1 text-nowrap text-truncate link-pejabat"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#pejabatModal"
                                                    data-pejabat-id="{{ $seksi->kepala->id }}">
                                                    {{ $seksi->kepala->nama }}
                                                </a>                                                
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
                                    <img src="{{ $cabang->kepala->foto_url }}" alt="{{ $cabang->kepala->foto_alt_text }}" class="img-fluid rounded-circle" 
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $cabang->kepala->nama }}">
                                        {{-- <a href="{{ route('tentang-kami.detail-pejabat', $cabang->kepala->id) }}">{{ $cabang->kepala->nama }}</a> --}}
                                        <a href="#" class="text-decoration-none text-dark card-title mb-1 text-nowrap text-truncate link-pejabat"
                                            data-bs-toggle="modal"
                                            data-bs-target="#pejabatModal"
                                            data-pejabat-id="{{ $cabang->kepala->id }}">
                                            {{ $cabang->kepala->nama }}
                                        </a>                                        
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
                                                <img src="{{ $seksi->kepala->foto_url }}" alt="{{ $seksi->kepala->foto_alt_text }}" class="img-fluid rounded-circle" 
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <small class="fw-bold d-block text-nowrap overflow-hidden text-truncate" title="{{ $seksi->kepala->nama }}">
                                                    {{-- <a href="{{ route('tentang-kami.detail-pejabat', $seksi->kepala->id) }}">{{ $seksi->kepala->nama }}</a> --}}
                                                    <a href="#" class="text-decoration-none text-dark card-title mb-1 text-nowrap text-truncate link-pejabat"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#pejabatModal"
                                                        data-pejabat-id="{{ $seksi->kepala->id }}">
                                                        {{ $seksi->kepala->nama }}
                                                    </a>                                                    
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
    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>

</div>


<div class="modal fade" id="pejabatModal" tabindex="-1" aria-labelledby="pejabatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {{-- Konten akan diisi oleh JavaScript --}}
        </div>
    </div>
</div>


@endsection