@extends('layouts.public_app')

@section('title', 'Beranda')

@section('content')
<div class="container text-center py-5">
    <h2 class="display-4">Selamat Datang di Portal Resmi</h2>
    <h1 class="display-2 text-primary fw-bold mb-4">{{ config('app.name', 'DESDM Sumsel') }}</h1>
    <p class="lead">
        Sumber informasi terpercaya mengenai energi dan sumber daya mineral di Provinsi Sumatera Selatan.
    </p>
    <hr class="my-4">
    <p>
        Temukan informasi publik, berita terkini, dan layanan kami.
    </p>
    <a href="{{ url('/informasi-publik') }}" class="btn btn-primary btn-lg me-2">Akses Informasi Publik</a>
    <a href="{{ url('/tentang-kami') }}" class="btn btn-outline-secondary btn-lg">Pelajari Lebih Lanjut</a>
</div>

{{-- Contoh bagian lain di beranda --}}
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Berita Terkini</h5>
                    <p class="card-text">Lihat berita dan pengumuman terbaru dari Dinas ESDM Sumsel.</p>
                    <a href="{{ url('/berita') }}" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Publikasi Resmi</h5>
                    <p class="card-text">Akses dokumen perencanaan, regulasi, dan laporan kinerja.</p>
                    <a href="{{ url('/publikasi') }}" class="btn btn-sm btn-outline-primary">Lihat Publikasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection