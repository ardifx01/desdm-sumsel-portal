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
            <p>Sekretariat Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan merupakan unsur pelayanan staf yang mempunyai tugas pokok membantu Kepala Dinas dalam melaksanakan tugas dan fungsi dinas. Sekretariat membawahi beberapa sub-bagian yang mengelola administrasi umum, kepegawaian, keuangan, serta hukum dan kehumasan.</p>

            <h3>Tugas Pokok</h3>
            <ul>
                <li>Mengkoordinasikan perumusan kebijakan teknis di lingkungan dinas.</li>
                <li>Melaksanakan pelayanan administrasi umum, kepegawaian, dan keuangan.</li>
                <li>Menyelenggarakan kegiatan kehumasan dan keprotokolan dinas.</li>
                <li>Melaksanakan pengelolaan barang milik negara/daerah.</li>
                <li>Melaksanakan pengelolaan kearsipan dan perpustakaan.</li>
            </ul>

            <h3>Struktur Pejabat</h3>
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <img src="{{ asset('images/default_avatar.png') }}" alt="Sekretaris Dinas" class="img-fluid rounded-circle mb-2" style="width: 120px; height: 120px; object-fit: cover;">
                    <h6>Nama Sekretaris</h6>
                    <p class="text-muted small">Sekretaris Dinas</p>
                </div>
                {{-- Tambahkan pejabat lain seperti Kasubbag Umum, Kasubbag Keuangan, dll. --}}
            </div>

            <h3>Nomor Kontak & Alamat</h3>
            <p><strong>Telepon:</strong> (0711) XXX-XXXX</p>
            <p><strong>Email:</strong> sekretariat@desdm.sumselprov.go.id</p>
            <p><strong>Alamat:</strong> Jl. Kapten A. Rivai No.19, Palembang</p>
            <div class="ratio ratio-16x9 mb-3">
                 {{-- Ganti dengan embed kode Google Maps yang akurat untuk kantor dinas --}}
                <iframe src="http://googleusercontent.com/maps.google.com/5" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <h3>Grafik Capaian Kinerja (Contoh Statis)</h3>
            <p>Berikut adalah ilustrasi capaian kinerja Sekretariat (misalnya, efisiensi administrasi).</p>
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
    <div class="text-center mt-4">
        <a href="{{ route('bidang-sektoral.index') }}" class="btn btn-secondary">Kembali ke Daftar Bidang</a>
    </div>
</div>
@endsection