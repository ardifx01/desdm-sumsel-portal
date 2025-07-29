@extends('layouts.public_app')

@section('title', 'Kebijakan Privasi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kebijakan Privasi</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Kebijakan Privasi Portal Web Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p>Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan berkomitmen untuk melindungi privasi pengguna portal web kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.</p>

            <h3>1. Informasi yang Kami Kumpulkan</h3>
            <p>Kami mengumpulkan informasi yang Anda berikan secara sukarela, seperti nama, alamat email, nomor telepon, dan rincian permohonan saat Anda menggunakan formulir kontak atau formulir permohonan informasi.</p>
            <p>Kami juga mengumpulkan data non-pribadi seperti alamat IP, jenis browser, waktu akses, dan halaman yang dikunjungi untuk analisis statistik dan peningkatan layanan.</p>

            <h3>2. Penggunaan Informasi</h3>
            <p>Informasi yang kami kumpulkan digunakan untuk:</p>
            <ul>
                <li>Menanggapi pertanyaan dan permohonan Anda.</li>
                <li>Meningkatkan kualitas pelayanan dan fungsionalitas portal web.</li>
                <li>Melakukan analisis statistik penggunaan website.</li>
                <li>Memenuhi kewajiban hukum dan regulasi.</li>
            </ul>

            <h3>3. Perlindungan Informasi</h3>
            <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi informasi pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran.</p>
            <p>Informasi pribadi Anda tidak akan dijual, diperdagangkan, atau disewakan kepada pihak ketiga tanpa persetujuan Anda, kecuali jika diwajibkan oleh hukum.</p>

            <h3>4. Tautan Eksternal</h3>
            <p>Portal web ini mungkin berisi tautan ke situs web lain. Kami tidak bertanggung jawab atas praktik privasi atau konten situs web pihak ketiga tersebut. Kami menganjurkan Anda untuk membaca kebijakan privasi setiap situs yang Anda kunjungi.</p>

            <h3>5. Perubahan Kebijakan Privasi</h3>
            <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan akan dipublikasikan di halaman ini. Dengan terus menggunakan portal web kami, Anda dianggap menyetujui perubahan tersebut.</p>

            <p class="text-muted small mt-4">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </div>
</div>
@endsection