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
                @php
                    $filteredIndikators = $sasaran->indikatorKinerja->filter(function($indikator) {
                        $kinerja = $indikator->kinerja->first();
                        return ($kinerja->target_tahunan ?? 0) > 0 || ($kinerja->total_realisasi ?? 0) > 0;
                    });
                @endphp

                @if($filteredIndikators->isNotEmpty())
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="mb-0">{{ $loop->iteration }}. {{ $sasaran->sasaran }}</h3>
                    </div>
                    <div class="card-body">
                        <div style="height: {{ $filteredIndikators->count() * 70 }}px;">
                            <canvas id="chart-sasaran-{{ $sasaran->id }}"></canvas>
                        </div>
                    </div>
                </div>
                @endif
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
            if (num % 1 === 0) {
                return new Intl.NumberFormat('id-ID').format(num);
            }
            return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
        }

        const targetLinePlugin = {
            id: 'targetLine',
            afterDatasetsDraw(chart, args, options) {
                const { ctx, chartArea: { top, bottom }, scales: { x, y } } = chart;
                
                ctx.save();
                ctx.beginPath();
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'rgba(255, 0, 0, 0.5)'; // merah untuk target 100%
                ctx.setLineDash([6, 6]);
                
                const xPos = x.getPixelForValue(100); // Garis target selalu di 100%
                ctx.moveTo(xPos, top);
                ctx.lineTo(xPos, bottom);
                ctx.stroke();
                
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(25, 135, 84, 1)';
                ctx.font = '9px Arial';
                ctx.fillText('100%', xPos, top - 3);

                ctx.restore();
            }
        };

        @foreach($sasaranStrategis as $sasaran)
            @php
                $chartData = $sasaran->indikatorKinerja->filter(function($indikator) {
                    $kinerja = $indikator->kinerja->first();
                    return ($kinerja->target_tahunan ?? 0) > 0 || ($kinerja->total_realisasi ?? 0) > 0;
                })->map(function($indikator) {
                    $kinerja = $indikator->kinerja->first();
                    return [
                        'label' => $indikator->nama_indikator . ' (' . $indikator->satuan . ')',
                        'target' => (float)($kinerja->target_tahunan ?? 0),
                        'realisasi' => (float)($kinerja->total_realisasi ?? 0),
                        'capaian' => (float)number_format($kinerja->persentase_capaian ?? 0, 2, '.', ''),
                    ];
                })->values();
            @endphp

            @if($chartData->isNotEmpty())
                const ctxSasaran{{$sasaran->id}} = document.getElementById('chart-sasaran-{{ $sasaran->id }}');
                if (ctxSasaran{{$sasaran->id}}) {
                    new Chart(ctxSasaran{{$sasaran->id}}, {
                        type: 'bar',
                        data: {
                            labels: @json($chartData->pluck('label')),
                            datasets: [
                                {
                                    label: 'Capaian',
                                    data: @json($chartData->pluck('capaian')),
                                    backgroundColor: (context) => {
                                        const capaian = context.raw;
                                        return capaian >= 100 ? 'rgba(25, 135, 84, 0.7)' : 'rgba(13, 110, 253, 0.7)';
                                    },
                                    borderColor: (context) => {
                                        const capaian = context.raw;
                                        return capaian >= 100 ? 'rgba(25, 135, 84, 1)' : 'rgba(13, 110, 253, 1)';
                                    },
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                title: { display: false },
                                tooltip: {
                                    callbacks: {
                                        // Tooltip sekarang akan menampilkan semua info
                                        label: function(context) {
                                            const index = context.dataIndex;
                                            const target = @json($chartData->pluck('target'))[index];
                                            const realisasi = @json($chartData->pluck('realisasi'))[index];
                                            const capaian = context.raw;
                                            
                                            return [
                                                `Target: ${formatNumber(target)}`,
                                                `Realisasi: ${formatNumber(realisasi)}`,
                                                `Capaian: ${capaian.toLocaleString('id-ID')}%`
                                            ];
                                        }
                                    }
                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'end',
                                    formatter: (value) => `${value.toLocaleString('id-ID')}%`,
                                    font: { weight: 'bold' }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    display: false,
                                    // Skala maksimum sedikit di atas nilai capaian tertinggi atau 100
                                    suggestedMax: Math.max(...(@json($chartData->pluck('capaian'))), 100) * 1.1,
                                    ticks: {
                                        callback: (value) => value + '%' // Tambahkan simbol %
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels, targetLinePlugin]
                    });
                }
            @endif
        @endforeach
    });
</script>
@endpush