@extends('layouts.public_app')

@section('title', 'Profil Bidang, UPTD & Cabang Dinas Regional')

@section('content')
{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bidang</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Profil Bidang, UPTD & Cabang Dinas Regional</h1>
    </div>
</div>

<div class="container py-5">
    {{-- Mengelompokkan berdasarkan tipe --}}
    @php
        $groupedBidangs = $bidangs->groupBy('tipe');
        $tipeMapping = [
            'bidang' => ['title' => 'Sekretariat dan Bidang Teknis', 'icon' => 'bi-briefcase-fill',
                        'desc'=>        'Sesuai Peraturan Gubernur Sumatera Selatan Nomor 79 Tahun 2016 </br>
                                        tentang Susunan Organisasi, Uraian Tugas dan Fungsi Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan'
                        ],
            'UPTD' => ['title' => 'Unit Pelaksana Teknis Dinas (UPTD)', 'icon' => 'bi-building-gear',
                                'desc'=>    'Sesuai Peraturan Gubernur Sumatera Selatan Nomor 11 Tahun 2018 </br>
                                            tentang tentang Pembentukan, Uraian Tugas dan Fungsi Unit Pelaksana Teknis Dinas Geologi dan Laboratorium </br>
                                            pada Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan'

                        ],
            'cabang_dinas' => ['title' => 'Cabang Dinas Regional', 'icon' => 'bi-geo-alt-fill',
                                'desc'=>    'Sesuai Peraturan Gubernur Sumatera Selatan Nomor 14 Tahun 2018 </br>
                                            tentang tentang Pembentukan, Uraian Tugas dan Fungsi Cabang Dinas </br>
                                            pada Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan'
                                ],
        ];
    @endphp

    @foreach ($tipeMapping as $tipe => $details)
        @if(isset($groupedBidangs[$tipe]) && $groupedBidangs[$tipe]->isNotEmpty())
            {{-- PERBAIKAN: Tambahkan div pembungkus dengan margin atas kondisional --}}
            <div class="{{ !$loop->first ? 'mt-5 pt-4 border-top' : '' }}">
            
                <h2 class="text-center">{{ $details['title'] }}</h2>
                <h6 class="text-center mb-4"><i>{!! $details['desc'] !!}</i></h6>
                <div class="row g-4 justify-content-center"> {{-- Menambahkan justify-content-center --}}
                    @foreach($groupedBidangs[$tipe] as $bidang)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 bidang-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title fw-bold mb-0">
                                        <a href="{{ route('bidang-sektoral.show', $bidang->slug) }}">{{ $bidang->nama }}</a>
                                    </h5>
                                    <i class="bi {{ $details['icon'] }} card-icon"></i>
                                </div>
                                
                                @if($bidang->tupoksi)
                                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit(strip_tags($bidang->tupoksi), 120) }}</p>
                                @else
                                    <p class="card-text text-muted small flex-grow-1">Belum ada deskripsi singkat tersedia.</p>
                                @endif
                                
                                <div class="mt-auto pt-3 border-top">
                                    @if($bidang->kepala)
                                        <p class="kepala-bidang mb-2">
                                            <strong>Kepala:</strong> {{ $bidang->kepala->nama }}
                                        </p>
                                    @else
                                        <p class="kepala-bidang mb-2">Kepala: -</p> {{-- Dibuat lebih ringkas --}}
                                    @endif
                                    <a href="{{ route('bidang-sektoral.show', $bidang->slug) }}" class="btn btn-sm btn-primary">Lihat Profil Lengkap</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div> {{-- Penutup div pembungkus --}}
        @endif
    @endforeach

    @if($bidangs->isEmpty())
        <div class="col-12 mt-5">
            <div class="alert alert-info text-center" role="alert">
                Belum ada Bidang, UPTD, atau Cabang Dinas yang aktif untuk ditampilkan.
            </div>
        </div>
    @endif
    <hr class="my-5">

    <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>
@endsection