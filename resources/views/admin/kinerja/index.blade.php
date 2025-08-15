@extends('layouts.public_app')

@section('title', 'Capaian Kinerja')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Capaian Kinerja</li>
        </ol>
    </nav>
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h2 class="mb-3 mb-md-0">Capaian Kinerja Dinas ESDM Provinsi Sumatera Selatan</h2>
        <form action="{{ route('kinerja.publik') }}" method="GET" class="d-flex align-items-center">
            <label for="tahun" class="form-label me-2 mb-0">Tahun:</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select" style="width: 120px;">
                @forelse ($availableYears as $yearOption)
                    <option value="{{ $yearOption }}" {{ $yearOption == $tahun ? 'selected' : '' }}>{{ $yearOption }}</option>
                @empty
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforelse
            </select>
        </form>
    </div>

    @if($sasaranStrategis->isEmpty() || $sasaranStrategis->every(fn($s) => $s->indikatorKinerja->isEmpty()))
        <div class="alert alert-warning text-center">Data kinerja untuk tahun {{ $tahun }} belum tersedia.</div>
    @else
        <div class="vstack gap-5">
            @foreach($sasaranStrategis as $sasaran)
                <div>
                    <h3 class="mb-4">{{ $loop->iteration }}. {{ $sasaran->sasaran }}</h3>
                    <div class="row g-4">
                        @foreach($sasaran->indikatorKinerja as $indikator)
                            @php
                                $kinerja = $indikator->kinerja->first();
                                $target = $kinerja->target_tahunan ?? 0;
                                $realisasi = $kinerja->total_realisasi ?? 0;
                            @endphp
                            {{-- Hanya tampilkan kartu jika ada data target atau realisasi --}}
                            @if($target > 0 || $realisasi > 0)
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title small">{{ $indikator->nama_indikator }} ({{ $indikator->satuan }})</h5>
                                        {{-- Canvas diletakkan di dalam div dengan tinggi tetap --}}
                                        <div style="height: 250px;">
                                            <canvas id="chart-{{ $indikator->id }}"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        function formatNumber(num) {
            if (num === null || num === undefined) return '0';
            // Cek jika angka adalah bilangan bulat (atau desimalnya .00)
            if (num % 1 === 0) {
                return new Intl.NumberFormat('id-ID').format(num);
            }
            // Default 2 desimal jika bukan bilangan bulat
            return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
        }

        // Loop melalui data yang sudah dikirim dari controller
        @foreach($sasaranStrategis as $sasaran)
            @foreach($sasaran->indikatorKinerja as $indikator)
                @php
                    $kinerja = $indikator->kinerja->first();
                    $target = (float)($kinerja->target_tahunan ?? 0);
                    $realisasi = (float)($kinerja->total_realisasi ?? 0);
                    $capaian = (float)number_format($kinerja->persentase_capaian ?? 0, 2, '.', '');
                @endphp

                {{-- Hanya inisialisasi chart jika ada data --}}
                @if($target > 0 || $realisasi > 0)
                    const ctx{{$indikator->id}} = document.getElementById('chart-{{ $indikator->id }}');
                    if (ctx{{$indikator->id}}) {
                        new Chart(ctx{{$indikator->id}}, {
                            type: 'bar',
                            data: {
                                labels: ['Target', 'Realisasi'],
                                datasets: [{
                                    data: [{{ $target }}, {{ $realisasi }}],
                                    backgroundColor: ['rgba(255, 193, 7, 0.5)', 'rgba(13, 110, 253, 0.5)'],
                                    borderColor: ['rgba(255, 193, 7, 1)', 'rgba(13, 110, 253, 1)'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    title: {
                                        display: true,
                                        text: `Capaian: {{ number_format($capaian, 2, ',', '.') }}%`,
                                        position: 'bottom',
                                        font: { weight: 'bold' }
                                    },
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'end',
                                        formatter: (value) => formatNumber(value),
                                        font: { weight: 'bold' }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        suggestedMax: Math.max({{ $target }}, {{ $realisasi }}) * 1.2,
                                        ticks: {
                                            callback: (value) => formatNumber(value)
                                        }
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    }
                @endif
            @endforeach
        @endforeach
    });
</script>
@endpush