@extends('layouts.public_app')

@section('title', 'Tentang Kami')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tentang kami</li>
        </ol>
    </nav>    
    <h2 class="text-center mb-4">Tentang Dinas ESDM Provinsi Sumatera Selatan</h2>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 pejabat-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Visi, Misi & Tujuan</h5>
                    <p class="card-text">Pahami arah dan tujuan strategis Dinas ESDM Sumsel.</p>
                    <a href="{{ route('tentang-kami.visi-misi') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 pejabat-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Struktur Organisasi</h5>
                    <p class="card-text">Pelajari bagan dan susunan organisasi kami.</p>
                    <a href="{{ route('tentang-kami.struktur-organisasi') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 pejabat-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Tugas & Fungsi</h5>
                    <p class="card-text">Ketahui peran dan tanggung jawab Dinas ESDM Sumsel.</p>
                    <a href="{{ route('tentang-kami.tugas-fungsi') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 pejabat-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Profil Pimpinan</h5>
                    <p class="card-text">Kenali para pemimpin dan pejabat di lingkungan dinas kami.</p>
                    <a href="{{ route('tentang-kami.profil-pimpinan') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection