@extends('layouts.public_app')

@section('title', 'Profil PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil PPID</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Profil Pejabat Pengelola Informasi dan Dokumentasi (PPID)</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-bullseye me-2"></i>Visi, Misi & Maklumat</h5>
                    <p class="card-text">Pahami dasar filosofi dan komitmen pelayanan PPID kami.</p>
                    <a href="{{ route('informasi-publik.profil-ppid.visi-misi-maklumat') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-diagram-3 me-2"></i>Struktur Organisasi PPID</h5>
                    <p class="card-text">Kenali susunan dan tim PPID yang siap melayani Anda.</p>
                    <a href="{{ route('informasi-publik.profil-ppid.struktur-organisasi') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-journal-richtext me-2"></i>Tugas & Fungsi PPID</h5>
                    <p class="card-text">Ketahui peran dan tanggung jawab utama PPID kami.</p>
                    <a href="{{ route('informasi-publik.profil-ppid.tugas-fungsi') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-gavel me-2"></i>Dasar Hukum PPID</h5>
                    <p class="card-text">Pelajari landasan hukum pembentukan dan operasional PPID.</p>
                    <a href="{{ route('informasi-publik.profil-ppid.dasar-hukum') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection