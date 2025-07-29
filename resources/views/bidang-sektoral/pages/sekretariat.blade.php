@extends('layouts.public_app')

@section('title', 'Profil Sekretariat')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bidang-sektoral.index') }}">Bidang & Data Sektoral</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sekretariat</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Profil Sekretariat Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p>Sekretariat mempunyai tugas melaksanakan koordinasi dengan bidang-bidang dan pelayanan teknis administrasi meliputi urusan kepegawaian, 
                keuangan, aset, hukum, perencanaan, umum dan rumah tangga.
            </p>

            <h3>Fungsi</h3>
            <ol>
                <li>pengelolaan urusan tata usaha, rumah tangga, perlengkapan, administrasi kepegawaian dan hukum;</li>
                <li>pengelolaan administrasi dan pertanggungjawaban keuangan serta aset;</li>
                <li>pengelolaan perencanaan kegiatan dan pelaporan tahunan;</li>
                <li>pengelolaan, penatausahaan, pemanfaatan dan pengamanan barang milik negara/daerah; dan</li>
                <li>pelaksanaan tugas kedinasan lainnya yang diberikan oleh pimpinan.</li>
            </ol>

            <div class="accordion mb-3" id="accordionPanelsStayOpenExample">
                {{-- Subbagian Umum dan Kepegawaian --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Subbagian Umum dan Kepegawaian
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                        <div class="accordion-body">
                            mempunyai tugas:
                            <ol class="space-y-2 mt-2">
                                <li>melaksanakan tata usaha, surat menyurat, arsip dan keperluan rumah tangga Dinas Energi dan Sumber Daya Mineral;</li>
                                <li>melaksanakan dan mengatur penggunaan dan pemeliharaan semua barang inventaris baik bergerak maupun tidak bergerak;</li>
                                <li>melaksanakan administrasi kepegawaian meliputi kenaikan pangkat, kenaikan gaji berkala, cuti, disiplin dan pensiun;</li>
                                <li>menyiapkan usulan pegawai yang akan mengikuti pendidikan dan pelatihan struktural/fungsional;</li>
                                <li>melakukan penyusunan Rencana Kebutuhan Barang Unit (RKBU) dan Rencana Pemeliharaan Barang Unit (RPBU); dan</li>
                                <li>melaksanakan tugas kedinasan lainnya yang diberikan oleh pimpinan.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Subbagian Keuangan --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            Subbagian Keuangan
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                        <div class="accordion-body">
                            mempunyai tugas:
                            <ol class="space-y-2 mt-2">
                                <li>menyusun Rencana Kerja Anggaran (RKA) belanja tidak langsung dan belanja langsung melalui aplikası SIMDA Keuangan;</li>
                                <li>melaksanakan penatausahaan keuangan dan aset melalui aplikasi SIMDA Barang Milik Daerah (BMD);</li>
                                <li>menyusun laporan pertanggungjawaban keuangan belanja langsung dan belanja tidak langsung;</li>
                                <li>membuat usulan rencana belanja pegawai dan mengurus realisasi belanja pegawai berupa gaji, tunjangan dan penghasilan pegawai lainnya;</li>
                                <li>melaksanakan pembukuan atas penerimaan dan pengeluaran anggaran belanja langsung dan belanja tidak langsung;</li>
                                <li>melakukan pembukuan atas penerimaan daerah di bidang energi dan sumber daya mineral; dan</li>
                                <li>melaksanakan tugas kedinasan lainnya yang diberikan oleh pimpinan.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Subbagian Perencanaan, Evaluasi dan Pelaporan --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            Subbagian Perencanaan, Evaluasi dan Pelaporan
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                        <div class="accordion-body">
                            mempunyai tugas:                
                            <ol class="space-y-2 mt-2">
                                <li>menyiapkan berdasarkan bahan rumusan perencanaan dan Rencana Strategis (Renstra) penetapan indikator kinerja;</li>
                                <li>mengumpulkan bahan Rencana Kerja Anggaran (RKA) berdasarkan Kerangka Acuan Kerja (KAK);</li>
                                <li>menyusun Rencana Kinerja Tahunan (RKT) sesuai pagu Prioritas dan Plafon Anggaran Sementara (PPAS) yang telah ditetapkan oleh Gubernur;</li>
                                <li>menyusun laporan realisasi fisik dan keuangan per triwulan, laporan kinerja tahunan dan laporan semester/tahunan;</li>
                                <li>menyusun dan mengolah data statistik energi dan sumber daya mineral;</li>
                                <li>menyusun dan mengevaluasi rancangan peraturan perundang-undangan di bidang energi dan sumber daya mineral;</li>
                                <li>menyiapkan bahan perencanaan strategis di bidang energi dan sumber daya mineral dengan berkoordinasi antar unit kerja</li>
                                <li>melakukan evaluasi seluruh kegiatan yang bersumber dari pendanaan APBD/APBN; dan</li>
                                <li>melaksanakan tugas kedinasan lainnya yang diberikan oleh pimpinan.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
                    
            <h3 class="mb-4">Struktur Pejabat</h3>
            <div class="row justify-content-center">

                {{-- Sekretaris Dinas Card --}}
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('images/default_avatar.png') }}" alt="Sekretaris Dinas" class="card-img-top"  style="height: auto; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Drs. Ahmad Gufran, M.Si</h5>
                            <p class="card-text text-muted small">Sekretaris Dinas</p>
                        </div>
                    </div>
                </div>

                {{-- Kepala Subbagian Umum & Kepegawaian Card --}}
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('images/hendri.png') }}" alt="Kepala Subbagian Umum & Kepegawaian" class="card-img-top"  style="height: auto; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Anton Sujarwo, ST, MH</h5>
                            <p class="card-text text-muted small">Kepala Subbagian<br> Umum & Kepegawaian</p>
                        </div>
                    </div>
                </div>

                {{-- Kepala Subbagian Keuangan Card --}}
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('images/hendri.png') }}" alt="Kepala Subbagian Keuangan" class="card-img-top"  style="height: auto; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Herna Nely, SE, MM</h5>
                            <p class="card-text text-muted small">Kepala Subbagian<br> Keuangan</p>
                        </div>
                    </div>
                </div>

                {{-- Kepala Subbagian Perencanaan, Evaluasi & Pelaporan Card --}}
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('images/default_avatar.png') }}" alt="Kepala Subbagian Perencanaan, Evaluasi & Pelaporan" class="card-img-top"  style="height: auto; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Ninuk Sri Handayani, ST</h5>
                            <p class="card-text text-muted small">Kepala Subbagian<br> Perencanaan, Evaluasi & Pelaporan</p>
                        </div>
                    </div>
                </div>

            </div>

            <h3>Grafik Capaian Kinerja (Contoh Statis)</h3>
            <p>Berikut adalah ilustrasi capaian kinerja Sekretariat (misalnya, efisiensi administrasi).</p>
            <div>
                <canvas id="sekretariatCapaianChart"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('sekretariatCapaianChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                                datasets: [{
                                    label: 'Efisiensi Administrasi (%)',
                                    data: [85, 90, 92, 95],
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: { y: { beginAtZero: true, max: 100 } }
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('bidang-sektoral.index') }}" class="btn btn-secondary">Kembali ke Daftar Bidang</a>
    </div>
</div>
@endsection