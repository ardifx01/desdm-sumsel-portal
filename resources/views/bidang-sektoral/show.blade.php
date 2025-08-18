@extends('layouts.public_app')

@section('title', 'Profil ' . $bidang->nama)

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bidang-sektoral.index') }}">Bidang</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $bidang->nama }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">{{ $bidang->nama }}</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="vstack gap-5">

                {{-- Bagian Struktur Pejabat --}}
                @if($bidang->kepala || $bidang->seksis->whereNotNull('pejabat_kepala_id')->isNotEmpty())
                <div class="content-card">
                    <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-people-fill me-3"></i>Struktur Pejabat</h3></div>
                    <div class="card-body p-4">
                        @if($bidang->kepala)
                            <div class="pejabat-utama-card mb-4">
                                <a href="#" class="link-pejabat flex-shrink-0" data-bs-toggle="modal" data-bs-target="#pejabatModal" data-pejabat-id="{{ $bidang->kepala->id }}">
                                    <img src="{{ $bidang->kepala->foto_url }}" alt="{{ $bidang->kepala->foto_alt_text }}" class="rounded-circle">
                                </a>
                                <div>
                                    <h4 class="pejabat-nama mb-1">{{ $bidang->kepala->nama }}</h4>
                                    <p class="pejabat-jabatan fs-5 mb-0">{{ $bidang->kepala->jabatan }}</p>
                                </div>
                            </div>
                        @endif

                        @if($bidang->seksis->whereNotNull('pejabat_kepala_id')->isNotEmpty())
                            <div class="row g-4">
                                @foreach($bidang->seksis->whereNotNull('pejabat_kepala_id')->sortBy('urutan') as $seksi)
                                    <div class="col-md-4">
                                        <div class="card h-100 shadow-sm border-0 pejabat-staff-card">
                                            <a href="#" class="link-pejabat" data-bs-toggle="modal" data-bs-target="#pejabatModal" data-pejabat-id="{{ $seksi->kepala->id }}">
                                                <img src="{{ $seksi->kepala->foto_url }}" alt="{{ $seksi->kepala->foto_alt_text }}" class="card-img-top">
                                            </a>
                                            <div class="card-body text-center">
                                                <h6 class="card-title fw-bold">{{ $seksi->kepala->nama }}</h6>
                                                <p class="card-text text-muted small">Kepala {{ $seksi->nama_seksi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Bagian Tupoksi --}}
                @if($bidang->tupoksi)
                <div class="content-card">
                    <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-journal-text me-3"></i>Tugas Pokok & Fungsi</h3></div>
                    <div class="card-body p-4 content-body">{!! $bidang->tupoksi !!}</div>
                </div>
                @endif

                {{-- Card 3: Unit di Bawahnya (Accordion) --}}
                @if($bidang->seksis->isNotEmpty())
                <div class="content-card">
                    <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-diagram-3-fill me-3"></i>Unit di Bawahnya</h3></div>
                    <div class="card-body p-4">
                        <div class="accordion" id="seksiAccordion">
                            @foreach($bidang->seksis->sortBy('urutan') as $seksi)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $seksi->id }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $seksi->id }}">
                                        {{ $seksi->nama_seksi }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $seksi->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#seksiAccordion">
                                    <div class="accordion-body content-body">
                                        {!! $seksi->tugas ?: '<p class="text-muted">Belum ada tugas yang ditetapkan.</p>' !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Card 4: Informasi Cabang Dinas / UPTD --}}
                @if(($bidang->tipe === 'cabang_dinas' && $bidang->wilayah_kerja) || (($bidang->tipe === 'cabang_dinas' || $bidang->tipe === 'UPTD') && ($bidang->alamat || $bidang->map)))
                <div class="content-card">
                    <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-info-circle-fill me-3"></i>Informasi Tambahan</h3></div>
                    <div class="card-body p-4 content-body">
                        @if($bidang->tipe === 'cabang_dinas' && $bidang->wilayah_kerja)
                            <h5 class="fw-bold">Wilayah Kerja</h5>
                            <div>{!! $bidang->wilayah_kerja !!}</div>
                            <hr class="my-4">
                        @endif
                        @if(($bidang->tipe === 'cabang_dinas' || $bidang->tipe === 'UPTD') && $bidang->alamat)
                            <h5 class="fw-bold">Alamat Kantor</h5>
                            <div>{!! $bidang->alamat !!}</div>
                        @endif
                        @if(($bidang->tipe === 'cabang_dinas' || $bidang->tipe === 'UPTD') && $bidang->map)
                            <div class="map-container mt-3">
                                {!! $bidang->map !!}
                            </div>
                        @endif
                    </div>
                </div>
                @endif
                
                {{-- Card 5: Grafik Kinerja --}}
                @if($bidang->grafik_kinerja)
                <div class="content-card">
                    <div class="card-header"><h3 class="d-flex align-items-center"><i class="bi bi-graph-up-arrow me-3"></i>Grafik Capaian Kinerja</h3></div>
                    <div class="card-body p-4 content-body">{!! $bidang->grafik_kinerja !!}</div>
                </div>
                @endif

            </div>
        </div>


    <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>


{{-- Modal ini akan berfungsi secara otomatis karena JS sudah dimuat global --}}
<div class="modal fade" id="pejabatModal" tabindex="-1" aria-labelledby="pejabatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {{-- Konten diisi oleh pejabat-modal.js --}}
        </div>
    </div>
</div>
@endsection
