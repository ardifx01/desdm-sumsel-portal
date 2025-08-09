@extends('layouts.public_app')

@section('title', 'Visi, Misi & Tujuan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">Visi, Misi & Tujuan</li>
        </ol>
    </nav>
    <h2 class="mb-4">Visi, Misi & Tujuan Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card mb-3" style="width: auto;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="https://lh3.googleusercontent.com/d/1DDh3h1mm0E_Bli1VAM1fBMufnBnzqhly=s1000?authuser=0" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body h-100 d-flex flex-column justify-content-center">
                    <h3 class="card-title text-center">Latar Belakang Visi Pembangunan</h3>
                    <div>
                        <p class="card-text text-center">Dengan mempertimbangkan kemajuan yang telah dicapai dan memperhatikan hasil analisis isu strategis;
                            mengacu visi dan misi Gubernur dan Wakil Gubernur yang terpilih untuk masa bakti 2025-2030; mengikuti prioritas pembangunan RPJPD Provinsi Sumatera Selatan;
                            memperhatikan prioritas pembangunan nasional; merujuk pada tujuan nasional yang tercantum dalam Pembukaan Undang-undang Dasar 1945;
                            serta memperhatikan tujuan pembangunan milenium, maka visi pembangunan Provinsi Sumatera Selatan Tahun 2025-2030 adalah:</p>
                        <p class="h3 fw-bold text-success my-0 text-center">
                            "SUMATERA SELATAN MAJU TERUS UNTUK SEMUA"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-group mb-3">
    <div class="card">
        <div class="card-body">
        <h3 class="card-title">MISI KESATU</h3>
        <p class="card-text">Membangun Sumsel berbasis ekonomi kerakyatan, didukung sektor pertanian, industri, dan UMKM
            yang tangguh untuk mengatasi pengangguran dan kemiskinan baik di perkotaan maupun di perdesaan.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <h3 class="card-title">TUJUAN</h3>
        <p class="card-text">meningkatnya peran sektor energi dan sumber daya mineral dengan baik dan berkelanjutan.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <h3 class="card-title">SASARAN STRATEGIS</h3>
        <p class="card-text">meningkatkan akses energi baik di pedesaan maupun perkotaan.</p>
        </div>
    </div>
    </div>

    <div class="card text-bg-primary mb-3" style="width: auto;">
    <div class="card-header">STRATEGI</div>
    <div class="card-body">
        <p class="card-text">
        <ul>
            <li>Menyediakan dukungan penuh dan koordinasi intensif bersama Pertamina, PLN dan KESDM RI dalam rangka pemenuhan kebutuhan energi bahan bakar dan listrik bagi masyarakat di Kabupaten/Kota.</li>
            <li>Melaksanakan pengkajian, evaluasi dan pengawasan di daerah dalam rangka meningkatnya pengelolaan pertambangan minerba yang baik dan benar (tata ruang, lingkungan dan sosial).</li>
            <li>Melakukan koordinasi secara komprehensif dan terpadu bersama instansi terkait dalam rangka meningkatnya penerimaan sektor ESDM.</li>
        </ul>
            
            </p>
    </div>
    </div>



    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>
@endsection