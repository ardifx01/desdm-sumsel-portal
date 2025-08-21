@extends('layouts.public_app')

@section('title', 'Capaian Kinerja')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Capaian Kinerja</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Visualisasi Capaian Kinerja</h1>
        <p class="lead text-muted">Berdasarkan Dokumen Renstra 2024-2026 Dinas ESDM Provinsi Sumatera Selatan.</p>
    </div>
</div>

<div class="container py-5">
    
    {{-- Filter Tahun --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6">
            <div class="card filter-card shadow-sm p-3">
                <form action="{{ route('kinerja.publik') }}" method="GET" class="d-flex align-items-center justify-content-center">
                    <label for="tahun" class="form-label fw-bold me-3 mb-0">Tampilkan Data Kinerja Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select" style="width: 150px;">
                        @forelse ($availableYears as $yearOption)
                            <option value="{{ $yearOption }}" {{ $yearOption == $tahun ? 'selected' : '' }}>{{ $yearOption }}</option>
                        @empty
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforelse
                    </select>
                </form>
            </div>
        </div>
    </div>

    @if($sasaranStrategis->isEmpty() || $sasaranStrategis->every(fn($s) => $s->indikatorKinerja->isEmpty()))
        <div class="col-12 text-center py-5">
            <i class="bi bi-bar-chart-line-fill fs-1 text-muted"></i>
            <h4 class="mt-3">Data Kinerja Belum Tersedia</h4>
            <p class="text-muted">Maaf, data untuk tahun {{ $tahun }} belum dapat ditampilkan. Silakan pilih tahun yang lain.</p>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="vstack gap-5">
                    @foreach($sasaranStrategis as $sasaran)
                        @php
                            $filteredIndikators = $sasaran->indikatorKinerja->filter(function($indikator) {
                                $kinerja = $indikator->kinerja->first();
                                return ($kinerja->target_tahunan ?? 0) > 0 || ($kinerja->total_realisasi ?? 0) > 0;
                            });
                        @endphp

                        @if($filteredIndikators->isNotEmpty())
                        {{-- Menambahkan kelas .content-section untuk animasi --}}
                        <div class="card chart-card content-section">
                            <div class="card-header">
                                <h3 class="mb-0">Sasaran Strategis {{ $loop->iteration }}: {{ $sasaran->sasaran }}</h3>
                            </div>
                            <div class="card-body p-4">
                                {{-- Menyesuaikan tinggi chart dinamis dengan padding --}}
                                <div style="height: {{ $filteredIndikators->count() * 60 + 20 }}px;">
                                    <canvas id="chart-sasaran-{{ $sasaran->id }}"></canvas>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="text-center mt-4">
        <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memuat library Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Logika untuk animasi "Reveal on Scroll"
        const sections = document.querySelectorAll('.content-section');
        if (sections.length > 0) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            sections.forEach(section => {
                observer.observe(section);
            });
        }
    
        // 2. Fungsi helper untuk memformat angka (tidak berubah)
        function formatNumber(num) {
            if (num === null || num === undefined) return '0';
            if (num % 1 === 0) {
                return new Intl.NumberFormat('id-ID').format(num);
            }
            return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
        }

        // 3. Plugin kustom untuk garis target 100% (tidak berubah)
        const targetLinePlugin = {
            id: 'targetLine',
            afterDatasetsDraw(chart, args, options) {
                const { ctx, chartArea: { top, bottom }, scales: { x } } = chart;
                if (!x) return;
                
                ctx.save();
                ctx.beginPath();
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'rgba(255, 99, 132, 0.7)'; // Warna merah yang lebih kontras
                ctx.setLineDash([6, 6]);
                
                const xPos = x.getPixelForValue(100);
                if (xPos >= 0) {
                    ctx.moveTo(xPos, top);
                    ctx.lineTo(xPos, bottom);
                    ctx.stroke();
                    
                    ctx.textAlign = 'center';
                    ctx.fillStyle = 'rgba(255, 99, 132, 1)';
                    ctx.font = '8px Arial';
                    ctx.fillText('TARGET 100%', xPos, top - 5);
                }

                ctx.restore();
            }
        };

        // 4. Loop untuk merender setiap chart dengan opsi visual baru
        @foreach($sasaranStrategis as $sasaran)
            @php
                // Logika pengambilan data dari PHP tidak diubah sama sekali
                $chartData = $sasaran->indikatorKinerja->filter(function($indikator) {
                    $kinerja = $indikator->kinerja->first();
                    return ($kinerja->target_tahunan ?? 0) > 0 || ($kinerja->total_realisasi ?? 0) > 0;
                })->map(function($indikator) {
                    $kinerja = $indikator->kinerja->first();
                    return [
                        'label' => $indikator->nama_indikator,
                        'target' => (float)($kinerja->target_tahunan ?? 0),
                        'realisasi' => (float)($kinerja->total_realisasi ?? 0),
                        'satuan' => $indikator->satuan,
                        'capaian' => (float)number_format($kinerja->persentase_capaian ?? 0, 2, '.', ''),
                    ];
                })->values();
            @endphp

            @if($chartData->isNotEmpty())
                const ctxSasaran{{$sasaran->id}} = document.getElementById('chart-sasaran-{{ $sasaran->id }}');
                if (ctxSasaran{{$sasaran->id}}) {
                    const chartData = @json($chartData);
                    const labels = chartData.map(item => item.label);
                    const capaianData = chartData.map(item => item.capaian);

                    new Chart(ctxSasaran{{$sasaran->id}}, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Capaian',
                                data: capaianData,
                                backgroundColor: (context) => (context.raw >= 100 ? 'rgba(25, 135, 84, 0.8)' : 'rgba(13, 110, 253, 0.8)'),
                                borderColor: (context) => (context.raw >= 100 ? '#198754' : '#0d6efd'),
                                borderWidth: 1,
                                borderRadius: 4,
                                barPercentage: 0.6,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            // === PERBAIKAN VISUAL FINAL DIMULAI DI SINI ===
                            layout: {
                                // 1. Beri ruang di kanan agar label target tidak terpotong
                                padding: { right: 80 } 
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            plugins: {
                                legend: { display: false },
                                title: { display: false },
                                tooltip: {
                                    enabled: true,
                                    backgroundColor: '#212529',
                                    titleFont: { size: 14, weight: 'bold' },
                                    bodyFont: { size: 12 },
                                    padding: 12,
                                    cornerRadius: 6,
                                    displayColors: false,
                                    // 2. Mengembalikan logika tooltip satuan seperti permintaan Anda
                                    callbacks: {
                                        title: (context) => chartData[context[0].dataIndex].label,
                                        label: function(context) {
                                            const index = context.dataIndex;
                                            const itemData = chartData[index];
                                            
                                            let target, realisasi;
                                            
                                            if (itemData.satuan === 'Rp') {
                                                target = `Rp ${formatNumber(itemData.target)}`;
                                                realisasi = `Rp ${formatNumber(itemData.realisasi)}`;
                                            } else if (itemData.satuan === 'Rp Milyar') {
                                                target = `Rp ${formatNumber(itemData.target)} Milyar`;
                                                realisasi = `Rp ${formatNumber(itemData.realisasi)} Milyar`;
                                            } else if (itemData.satuan === '%') {
                                                target = `${formatNumber(itemData.target)}%`;
                                                realisasi = `${formatNumber(itemData.realisasi)}%`;
                                            } else {
                                                target = `${formatNumber(itemData.target)} ${itemData.satuan}`;
                                                realisasi = `${formatNumber(itemData.realisasi)} ${itemData.satuan}`;
                                            }

                                            const capaian = itemData.capaian.toLocaleString('id-ID') + '%';

                                            return [
                                                `Target: ${target}`,
                                                `Realisasi: ${realisasi}`,
                                                `Capaian: ${capaian}`
                                            ];
                                        }
                                    }
                                },
                                // 3. Menonaktifkan label angka di ujung bar
                                datalabels: {
                                    display: false 
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    display: true, // Tampilkan sumbu X untuk referensi
                                    suggestedMax: Math.max(...capaianData, 100) * 1.1,
                                    ticks: {
                                        // 4. Menampilkan persentase di sumbu X
                                        callback: (value) => value + '%'
                                    }
                                },
                                y: {
                                    ticks: {
                                        font: {
                                            family: "'Titillium Web', sans-serif",
                                            size: 14,
                                        },
                                        // 5. Menggunakan autoSkip untuk menangani label panjang
                                        autoSkip: false,
                                        callback: function(value, index, values) {
                                            const label = this.getLabelForValue(value);
                                            // Potong label yang terlalu panjang
                                            if (label.length > 40) {
                                                return label.substring(0, 40) + '...';
                                            }
                                            return label;
                                        }
                                    },
                                    grid: { display: false }
                                }
                            }
                        },
                        plugins: [targetLinePlugin] // Plugin datalabels bisa dihapus dari sini, tapi biarkan saja tidak masalah
                    });
                }
            @endif
        @endforeach
    });
</script>
@endpush