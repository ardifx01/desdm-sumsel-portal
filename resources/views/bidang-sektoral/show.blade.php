@extends('layouts.public_app') {{-- Pastikan layout ini sesuai dengan layout frontend Anda --}}

@section('title', 'Profil ' . $bidang->nama)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bidang-sektoral.index') }}">Bidang & Data Sektoral</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $bidang->nama }}</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Profil {{ $bidang->nama }} Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            {{-- Bagian Struktur Pejabat (Jika ada kepala bidang/UPTD/cabang dinas) --}}
            @if($bidang->kepala || $bidang->seksis->isNotEmpty()) {{-- Tampilkan jika ada kepala bidang atau seksi --}}
                <h3>Struktur Pejabat</h3>
                <div class="row justify-content-center">
                    {{-- Pejabat Kepala Bidang/UPTD/Cabang Dinas --}}
                    @if($bidang->kepala)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('storage/' . $bidang->kepala->foto) }}" onerror="this.onerror=null;this.src='{{ asset('images/default_avatar.png') }}';" alt="{{ $bidang->kepala->nama }}" class="card-img-top" style="height: auto; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">{{ $bidang->kepala->nama }}</h5>
                                    <p class="card-text text-muted small">{{ $bidang->kepala->jabatan }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Pejabat Seksi --}}
                    @foreach($bidang->seksis->whereNotNull('pejabat_kepala_id')->sortBy('urutan') as $seksi)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('storage/' . $seksi->kepala->foto) }}" onerror="this.onerror=null;this.src='{{ asset('images/default_avatar.png') }}';" alt="{{ $seksi->kepala->nama }}" class="card-img-top" style="height: auto; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">{{ $seksi->kepala->nama }}</h5>
                                    <p class="card-text text-muted small">Kepala {{ $seksi->nama_seksi }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr class="my-4">
            @endif


            {{-- Bagian Tupoksi --}}
            @if($bidang->tupoksi)
                <h3>Tugas Pokok & Fungsi</h3>
                <div>{!! $bidang->tupoksi !!}</div> {{-- Gunakan {!! !!} untuk merender HTML dari TinyMCE --}}
                <hr class="my-4">
            @endif

            {{-- Bagian Seksi-seksi (Accordion) --}}
            @if($bidang->seksis->isNotEmpty())
                <h3>Unit dibawah {{ $bidang->nama }}</h3>
                <div class="accordion mb-3" id="seksiAccordion">
                    @foreach($bidang->seksis->sortBy('urutan') as $seksi)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $seksi->id }}">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $seksi->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $seksi->id }}">
                                    {{ $seksi->nama_seksi }}
                                </button>
                            </h2>
                            <div id="collapse{{ $seksi->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $seksi->id }}" data-bs-parent="#seksiAccordion">
                                <div class="accordion-body">
                                    @if($seksi->tugas)
                                        <div>{!! $seksi->tugas !!}</div> {{-- Render HTML tugas --}}
                                    @else
                                        <p>Belum ada tugas yang ditetapkan untuk seksi ini.</p>
                                    @endif
{{--                                     @if($seksi->kepala)
                                        <p class="mt-2 text-muted">Kepala Seksi: {{ $seksi->kepala->nama }}</p>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr class="my-4">
            @endif



            {{-- Bagian Khusus untuk Cabang Dinas dan UPTD --}}
            @if($bidang->tipe === 'cabang_dinas' || $bidang->tipe === 'UPTD')
                @if($bidang->tipe === 'cabang_dinas' && $bidang->wilayah_kerja)
                    <h3>Wilayah Kerja</h3>
                    <div>{!! $bidang->wilayah_kerja !!}</div>
                    <hr class="my-4">
                @endif

                @if($bidang->alamat)
                    <h3>Alamat</h3>
                    <div>{!! $bidang->alamat !!}</div>
                    <hr class="my-4">
                @endif

                @if($bidang->map)
                    <h3>Peta Lokasi</h3>
                    <div class="embed-responsive embed-responsive-16by9" style="height: 400px; width: 100%;">
                        {!! $bidang->map !!}
                    </div>
                    <hr class="my-4">
                @endif
            @endif

            {{-- Bagian Grafik Kinerja (Opsional) --}}
            @if($bidang->grafik_kinerja)
                <h3>Grafik Capaian Kinerja</h3>
                <div>{!! $bidang->grafik_kinerja !!}</div>
                <hr class="my-4">
            @endif

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('bidang-sektoral.index') }}" class="btn btn-secondary">Kembali ke Daftar Bidang</a>
    </div>
</div>
@endsection

@push('scripts')
{{-- Anda mungkin perlu memuat Chart.js di public_app.blade.php jika belum ada --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- Atau tambahkan script untuk Chart.js yang disesuaikan dengan data grafik_kinerja jika perlu --}}
@endpush