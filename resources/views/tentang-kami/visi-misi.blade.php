@extends('layouts.public_app')

@section('title', 'Visi, Misi & Tujuan')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Visi, Misi & Tujuan</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Visi, Misi & Tujuan Strategis</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="vstack gap-5">
                
                {{-- Card Visi Utama dengan Gaya "Floating Image" --}}
                <div class="card vision-card-showcase">
                    {{-- Gambar ditempatkan di luar card-body --}}
                    <img src="{{ asset('storage/images/visi-misi.webp') }}" alt="Visi Pembangunan Sumatera Selatan" class="vision-image mx-auto d-block">
                    
                    <div class="card-body p-5">
                        <p class="lead text-muted">Visi Pembangunan Provinsi Sumatera Selatan Tahun 2025-2030</p>
                        <blockquote class="display-5 vision-text my-3">
                            "SUMATERA SELATAN <br>MAJU TERUS UNTUK SEMUA"
                        </blockquote>
                        <p class="text-muted mx-auto" style="max-width: 700px;">
                            Dengan mempertimbangkan kemajuan yang telah dicapai, isu strategis, prioritas pembangunan, serta tujuan nasional, 
                            visi ini menjadi landasan pembangunan daerah.
                        </p>
                    </div>
                </div>

                {{-- Pilar Strategis 1 --}}
                <div class="card shadow-sm border-0 strategic-pillar-card">
                    <div class="card-body p-4">
                        <h3 class="pillar-title mb-4"><i class="bi bi-1-circle-fill me-2"></i> MISI KESATU</h3>
                        <p class="lead">
                            Membangun Sumsel berbasis ekonomi kerakyatan, didukung sektor pertanian, industri, dan UMKM
                            yang tangguh untuk mengatasi pengangguran dan kemiskinan baik di perkotaan maupun di perdesaan.
                        </p>

                        <div class="vstack gap-4 mt-4">
                            {{-- Tujuan --}}
                            <div class="sub-pillar">
                                <h6><i class="bi bi-check-circle-fill text-success me-2"></i> Tujuan</h6>
                                <p>Meningkatnya peran sektor energi dan sumber daya mineral dengan baik dan berkelanjutan.</p>
                            </div>

                            {{-- Sasaran Strategis --}}
                            <div class="sub-pillar">
                                <h6><i class="bi bi-bullseye text-info me-2"></i> Sasaran Strategis</h6>
                                <p>Meningkatkan akses energi baik di pedesaan maupun perkotaan.</p>
                            </div>

                            {{-- Strategi --}}
                            <div class="sub-pillar">
                                <h6><i class="bi bi-flag-fill text-warning me-2"></i> Strategi</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><i class="bi bi-caret-right-fill text-primary me-2 mt-1"></i> Menyediakan dukungan penuh dan koordinasi intensif bersama Pertamina, PLN dan KESDM RI dalam rangka pemenuhan kebutuhan energi.</li>
                                    <li class="d-flex mb-2"><i class="bi bi-caret-right-fill text-primary me-2 mt-1"></i> Melaksanakan pengkajian, evaluasi dan pengawasan di daerah dalam rangka meningkatnya pengelolaan pertambangan minerba yang baik dan benar.</li>
                                    <li class="d-flex mb-2"><i class="bi bi-caret-right-fill text-primary me-2 mt-1"></i> Melakukan koordinasi secara komprehensif dan terpadu bersama instansi terkait dalam rangka meningkatnya penerimaan sektor ESDM.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- (Anda bisa menambahkan pilar-pilar misi lainnya di sini dengan format yang sama) --}}

            </div>

            <div class="text-center mt-5">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection