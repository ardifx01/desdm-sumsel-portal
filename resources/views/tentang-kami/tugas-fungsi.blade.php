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
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="vstack gap-5">

                {{-- Card 1: Tugas Pokok --}}
                <div class="card shadow-sm border-0 content-card">
                    <div class="card-header">
                        <h3 class="d-flex align-items-center"><i class="bi bi-bullseye me-3"></i>Tugas Pokok</h3>
                    </div>
                    <div class="card-body p-4 content-body">
                        <p class="lead">
                            Kepala Dinas mempunyai tugas membantu Gubernur menyelenggarakan urusan pemerintahan yang menjadi kewenangan Pemerintah Provinsi 
                            di bidang energi dan sumber daya mineral serta tugas pembantuan yang ditugaskan kepada Pemerintah Provinsi.
                        </p>
                    </div>
                </div>
                
                {{-- Card 2: Fungsi --}}
                <div class="card shadow-sm border-0 content-card">
                    <div class="card-header">
                        <h3 class="d-flex align-items-center"><i class="bi bi-gear-wide-connected me-3"></i>Fungsi</h3>
                    </div>
                    <div class="card-body p-4 content-body">
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
            
            <div class="text-center mt-5">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
            </div>

        </div>
    </div>
</div>
@endsection