@extends('layouts.public_app')

@section('title', 'Disclaimer')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Disclaimer</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Disclaimer Portal Web Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p class="lead">Informasi yang disajikan di portal web Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan ini bertujuan untuk memberikan informasi umum dan transparan kepada masyarakat.</p>

            <h3>1. Keakuratan Informasi</h3>
            <p>Kami berupaya keras untuk memastikan bahwa informasi yang dimuat di portal web ini adalah akurat dan terkini. Namun, kami tidak memberikan jaminan, baik tersurat maupun tersirat, mengenai kelengkapan, keakuratan, keandalan, kesesuaian, atau ketersediaan informasi tersebut untuk tujuan apapun. Segala ketergantungan yang Anda berikan pada informasi tersebut sepenuhnya menjadi risiko Anda sendiri.</p>

            <h3>2. Perubahan Informasi</h3>
            <p>Informasi yang ditampilkan di portal web ini dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya. Kami tidak berkewajiban untuk memperbarui informasi yang sudah usang.</p>

            <h3>3. Tautan Eksternal</h3>
            <p>Portal web ini mungkin berisi tautan ke situs web lain yang tidak berada di bawah kendali Dinas ESDM Provinsi Sumatera Selatan. Penyediaan tautan ini tidak menyiratkan rekomendasi atau dukungan atas pandangan yang diungkapkan di dalamnya. Kami tidak memiliki kendali atas sifat, konten, dan ketersediaan situs-situs tersebut.</p>

            <h3>4. Tanggung Jawab Penggunaan</h3>
            <p>Dalam keadaan apapun, Dinas ESDM Provinsi Sumatera Selatan tidak bertanggung jawab atas kerugian atau kerusakan apapun, termasuk namun tidak terbatas pada kerugian atau kerusakan tidak langsung atau konsekuensial, atau kerugian atau kerusakan apapun yang timbul dari hilangnya data atau keuntungan yang timbul dari, atau sehubungan dengan, penggunaan portal web ini.</p>

            <p class="text-muted small mt-4">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </div>
</div>
@endsection