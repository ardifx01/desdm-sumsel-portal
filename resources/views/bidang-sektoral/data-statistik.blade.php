@extends('layouts.public_app')

@section('title', 'Data & Statistik Sektoral')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bidang-sektoral.index') }}">Bidang & Data Sektoral</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data & Statistik Sektoral</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Data dan Statistik Sektoral Dinas ESDM Provinsi Sumatera Selatan</h2>

    <p class="lead text-center mb-5">Berikut adalah ringkasan data dan statistik penting terkait sektor Energi, Ketenagalistrikan, dan Mineral & Batubara di Provinsi Sumatera Selatan.</p>

    {{-- Contoh Statistik Angka --}}
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-success">
                <div class="card-body">
                    <i class="bi bi-lightbulb-fill text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Rasio Elektrifikasi</h5>
                    <p class="display-4 fw-bold">98.5%</p>
                    <p class="text-muted">Per Desember 2024</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-danger">
                <div class="card-body">
                    <i class="bi bi-truck-flatbed text-danger" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Produksi Batubara</h5>
                    <p class="display-4 fw-bold">75 Juta Ton</p>
                    <p class="text-muted">Target Tahun 2025</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-info">
                <div class="card-body">
                    <i class="bi bi-sun-fill text-info" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Potensi PLTS</h5>
                    <p class="display-4 fw-bold">1500 MWp</p>
                    <p class="text-muted">Potensi di seluruh wilayah</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Contoh Grafik Statis --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Produksi Batubara Sumatera Selatan (Juta Ton)</h5>
        </div>
        <div class="card-body">
            <canvas id="batubaraChart"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('batubaraChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['2020', '2021', '2022', '2023', '2024'],
                            datasets: [{
                                label: 'Produksi Batubara (Juta Ton)',
                                data: [60, 65, 70, 72, 75],
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                });
            </script>
        </div>
    </div>

    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>
@endsection