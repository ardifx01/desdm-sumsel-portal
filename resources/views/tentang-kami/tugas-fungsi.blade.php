@extends('layouts.public_app')

@section('title', 'Tugas & Fungsi')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tugas & Fungsi</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Tugas Pokok & Fungsi</h1>
        <p class="lead text-muted">Landasan operasional Dinas ESDM Provinsi Sumatera Selatan.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="vstack gap-5">

                {{-- Card 1: Tugas Pokok dengan Gaya Floating Image --}}
                <div class="card vision-card-showcase">
                    <img src="{{ asset('storage/images/tugas-pokok-bg.webp') }}" alt="Ilustrasi Tugas Pokok" class="vision-image mx-auto d-block">
                    
                    <div class="card-body p-5">
                        <h2 class="display-6 vision-text my-3"><i class="bi bi-bullseye me-2"></i>Tugas Pokok</h2>
                        <p class="lead text-muted mx-auto" style="max-width: 800px;">
                            <i>Sesuai Peraturan Gubernur Sumatera Selatan Nomor 79 Tahun 2016 </br>
            tentang Susunan Organisasi, Uraian Tugas dan Fungsi Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</i><br>
                            Kepala Dinas mempunyai tugas membantu Gubernur menyelenggarakan urusan pemerintahan yang menjadi kewenangan Pemerintah Provinsi 
                            di bidang energi dan sumber daya mineral serta tugas pembantuan yang ditugaskan kepada Pemerintah Provinsi.
                        </p>
                    </div>
                </div>
                
                {{-- Card 2: Fungsi dengan Gaya Floating Image --}}
                <div class="card vision-card-showcase">
                    <img src="{{ asset('storage/images/fungsi-bg.webp') }}" alt="Ilustrasi Fungsi Operasional" class="vision-image mx-auto d-block">
                    
                    <div class="card-body p-5">
                        <h2 class="display-6 vision-text my-3"><i class="bi bi-gear-wide-connected me-2"></i>Fungsi</h2>
                        <div class="content-body text-start w-100" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                            <ol class="styled-ol">
                                <li>Perumusan kebijakan di bidang energi dan sumber daya mineral.</li>
                                <li>Pelaksanaan kebijakan di bidang energi dan sumber daya mineral.</li>
                                <li>Pelaksanaan evaluasi dan pelaporan di bidang energi dan sumber daya mineral.</li>
                                <li>Pembinaan administrasi dan kepegawaian pada Dinas Energi dan Sumber Daya Mineral.</li>
                                <li>Pengkoordinasian, penatausahaan, pemanfaatan dan pengamanan barang milik negara/daerah.</li>
                                <li>Pelaksanaan tugas kedinasan lainnya yang diberikan oleh pimpinan.</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="text-center mt-5">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
            </div>

        </div>
    </div>
</div>
@endsection