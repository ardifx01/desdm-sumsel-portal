@extends('layouts.public_app')

@section('title', 'Laporan & Statistik PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan & Statistik</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Laporan & Statistik Pelayanan Informasi Publik</h2>

    {{-- Statistik Ringkasan --}}
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-file-earmark-text me-2"></i>Total Permohonan Informasi</h5>
                    <p class="display-4 text-center fw-bold">{{ $totalPermohonan }}</p>
                    <hr>
                    <h6>Permohonan Berdasarkan Status:</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($permohonanPerStatus as $status)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $status->status }}
                                <span class="badge bg-primary rounded-pill">{{ $status->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning"><i class="bi bi-exclamation-triangle me-2"></i>Total Pengajuan Keberatan</h5>
                    <p class="display-4 text-center fw-bold">{{ $totalKeberatan }}</p>
                    <hr>
                    <h6>Keberatan Berdasarkan Jenis:</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($keberatanPerJenis as $jenis)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $jenis->jenis_keberatan }}
                                <span class="badge bg-warning rounded-pill">{{ $jenis->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Permohonan Informasi Per Bulan --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Statistik Permohonan Informasi per Bulan (Tahun {{ date('Y') }})</h5>
        </div>
        <div class="card-body">
            <canvas id="permohonanChart"></canvas>
        </div>
    </div>

    {{-- Grafik Pengajuan Keberatan Per Bulan --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Statistik Pengajuan Keberatan per Bulan (Tahun {{ date('Y') }})</h5>
        </div>
        <div class="card-body">
            <canvas id="keberatanChart"></canvas>
        </div>
    </div>

    {{-- Daftar Laporan Tahunan PPID --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Laporan Akses Informasi Publik Tahunan</h5>
        </div>
        <div class="card-body">
            @if($laporanTahunanPPID->isNotEmpty())
                <ul class="list-group list-group-flush">
                    @foreach($laporanTahunanPPID as $laporan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                <a href="{{ route('informasi-publik.show', $laporan->slug) }}" class="text-decoration-none">{{ $laporan->judul }}</a>
                                <small class="text-muted ms-2">({{ $laporan->tanggal_publikasi ? $laporan->tanggal_publikasi->translatedFormat('d M Y') : '-' }})</small>
                            </div>
                            @if($laporan->file_path)
                                <a href="{{ asset('storage/' . $laporan->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted text-center">Belum ada laporan tahunan PPID yang tersedia.</p>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('informasi-publik.index') }}" class="btn btn-secondary me-2">Kembali ke Informasi Publik</a>
    </div>
</div>

{{-- Script untuk Chart.js --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data Permohonan
        const permohonanLabels = @json($permohonanLabels);
        const permohonanData = @json($permohonanData);
        const permohonanCtx = document.getElementById('permohonanChart').getContext('2d');
        new Chart(permohonanCtx, {
            type: 'bar', // Atau 'line'
            data: {
                labels: permohonanLabels,
                datasets: [{
                    label: 'Jumlah Permohonan',
                    data: permohonanData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Permohonan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan - Tahun'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });

        // Data Keberatan
        const keberatanLabels = @json($keberatanLabels);
        const keberatanData = @json($keberatanData);
        const keberatanCtx = document.getElementById('keberatanChart').getContext('2d');
        new Chart(keberatanCtx, {
            type: 'line', // Atau 'bar'
            data: {
                labels: keberatanLabels,
                datasets: [{
                    label: 'Jumlah Pengajuan Keberatan',
                    data: keberatanData,
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Keberatan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan - Tahun'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    });
</script>

{{-- Pastikan Bootstrap Icons terinstal atau tambahkan CDN di layout utama --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection