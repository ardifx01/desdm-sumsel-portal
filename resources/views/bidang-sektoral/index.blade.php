@extends('layouts.public_app')

@section('title', 'Bidang & Data Sektoral')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bidang & Data Sektoral</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Bidang, Unit Pelaksana Teknis Dinas, & Cabang Dinas Regional</h2>

    <p class="lead text-center mb-5">Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan memiliki struktur organisasi yang terdiri dari Sekretariat, 
        Bidang Teknis, UPTD, dan Cabang Dinas Regional untuk melayani masyarakat secara komprehensif.</p>

    <div class="row">
        @foreach($bidangUnits as $unit)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $unit['nama'] }}</h5>
                    <p class="card-text">{{ Str::limit($unit['deskripsi'], 120) }}</p>
                    <a href="{{ route('bidang-sektoral.show', $unit['slug']) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Profil</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <hr class="my-5">

    <div class="text-center">
        <h3 class="mb-4">Data dan Statistik Sektoral Umum</h3>
        <p class="lead">Akses data dan statistik penting terkait sektor ESDM di Sumatera Selatan.</p>
        <a href="{{ route('bidang-sektoral.data-statistik') }}" class="btn btn-lg btn-success">Lihat Data & Statistik Sektoral</a>
    </div>

</div>
@endsection