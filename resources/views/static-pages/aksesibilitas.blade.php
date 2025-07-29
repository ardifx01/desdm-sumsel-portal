@extends('layouts.public_app')

@section('title', 'Halaman Aksesibilitas')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Aksesibilitas</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Halaman Aksesibilitas Portal Web Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p class="lead">Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan berkomitmen untuk memastikan portal web kami dapat diakses oleh semua pengguna, termasuk penyandang disabilitas.</p>

            <h3>1. Standar Aksesibilitas</h3>
            <p>Kami berupaya untuk mematuhi standar aksesibilitas konten web, seperti Pedoman Aksesibilitas Konten Web (WCAG) 2.1 Level AA, untuk memastikan pengalaman yang inklusif bagi semua pengunjung.</p>

            <h3>2. Fitur Aksesibilitas yang Disediakan</h3>
            <p>Portal web kami telah dirancang dengan mempertimbangkan fitur-fitur aksesibilitas, antara lain:</p>
            <ul>
                <li>**Desain Responsif:** Tampilan website dapat menyesuaikan secara otomatis dengan berbagai ukuran layar perangkat (desktop, tablet, seluler).</li>
                <li>**Navigasi Keyboard:** Semua fungsi dapat diakses menggunakan keyboard tanpa mouse.</li>
                <li>**Teks Alternatif (Alt Text):** Gambar-gambar penting memiliki deskripsi teks alternatif yang dapat dibaca oleh pembaca layar.</li>
                <li>**Kontras Warna yang Baik:** Kombinasi warna teks dan latar belakang dioptimalkan untuk keterbacaan.</li>
                <li>**Ukuran Font yang Dapat Disesuaikan:** Pengguna dapat menyesuaikan ukuran font melalui pengaturan browser mereka.</li>
                <li>**Struktur Heading yang Jelas:** Penggunaan tag HTML heading (H1, H2, dll.) yang tepat untuk memudahkan navigasi dengan pembaca layar.</li>
                <li>**Transkrip/Takarir:** (Jika ada konten audio/video) Konten multimedia akan dilengkapi dengan transkrip atau takarir.</li>
            </ul>

            <h3>3. Saran dan Masukan</h3>
            <p>Kami terus berupaya untuk meningkatkan aksesibilitas portal web ini. Jika Anda menemukan hambatan aksesibilitas atau memiliki saran untuk perbaikan, silakan hubungi kami melalui halaman <a href="{{ route('kontak.index') }}">Kontak Umum</a>.</p>

            <p class="text-muted small mt-4">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </div>
</div>
@endsection