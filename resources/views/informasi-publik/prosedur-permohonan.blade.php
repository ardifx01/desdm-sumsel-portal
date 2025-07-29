@extends('layouts.public_app')

@section('title', 'Alur Permohonan Informasi Publik')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alur Permohonan Informasi</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Alur Permohonan Informasi Publik Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p>Masyarakat dapat mengajukan permohonan informasi publik kepada Dinas ESDM Provinsi Sumatera Selatan dengan mengikuti alur berikut:</p>
            <ol>
                <li>Pemohon mengisi formulir permohonan informasi secara online atau datang langsung ke Kantor PPID.</li>
                <li>Melengkapi persyaratan identitas (KTP untuk perorangan, Akta Pendirian untuk Badan Hukum, dll).</li>
                <li>Petugas PPID menerima dan memverifikasi permohonan.</li>
                <li>Jika permohonan lengkap, petugas mencatat dalam register permohonan dan memberikan tanda bukti penerimaan.</li>
                <li>PPID melakukan proses klasifikasi informasi dan berkoordinasi dengan unit terkait.</li>
                <li>Informasi diberikan paling lambat 10 hari kerja sejak permohonan diterima. Jangka waktu dapat diperpanjang 7 hari kerja jika informasi memerlukan waktu lama untuk dikumpulkan.</li>
                <li>Apabila permohonan ditolak, PPID harus memberikan alasan penolakan dan mekanisme keberatan.</li>
            </ol>
            <p class="text-center mt-4">
                <a href="{{ route('informasi-publik.permohonan.form') }}" class="btn btn-primary btn-lg">Ajukan Permohonan Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection