@extends('layouts.public_app')

@section('title', 'Tugas & Fungsi PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tugas & Fungsi</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Tugas & Fungsi Pejabat Pengelola Informasi dan Dokumentasi (PPID)</h2>

    <h3>Tugas Pokok PPID</h3>
    <p>Melaksanakan tugas dan fungsi sebagai Pejabat Pengelola Informasi dan Dokumentasi di lingkungan Dinas ESDM Provinsi Sumatera Selatan sesuai dengan peraturan perundang-undangan yang berlaku.</p>

    <h3>Fungsi PPID</h3>
    <p>Secara umum, PPID Dinas ESDM Provinsi Sumatera Selatan memiliki fungsi sebagai berikut:</p>
    <ol>
        <li>Penyimpanan, pendokumentasian, penyediaan, dan pelayanan informasi publik.</li>
        <li>Pengelolaan sistem informasi dan dokumentasi yang mudah diakses oleh masyarakat.</li>
        <li>Penetapan standar operasional prosedur (SOP) pelayanan informasi publik.</li>
        <li>Melakukan pengujian konsekuensi atas informasi yang dikecualikan.</li>
        <li>Melakukan klasifikasi informasi publik.</li>
        <li>Mengelola pengajuan keberatan dan proses sengketa informasi.</li>
        <li>Menyusun laporan layanan informasi publik secara berkala.</li>
        {{-- Ganti dengan tugas dan fungsi resmi PPID DESDM Sumsel --}}
    </ol>

    <a href="{{ route('informasi-publik.profil-ppid.index') }}" class="btn btn-secondary mt-4">Kembali ke Profil PPID</a>
</div>
@endsection