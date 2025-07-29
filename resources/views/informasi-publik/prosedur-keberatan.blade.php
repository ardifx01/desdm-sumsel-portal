@extends('layouts.public_app')

@section('title', 'Alur Pengajuan Keberatan Informasi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alur Pengajuan Keberatan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Alur Pengajuan Keberatan Informasi Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p>Apabila Anda merasa keberatan dengan keputusan atau penanganan permohonan informasi Anda, Anda dapat mengajukan keberatan dengan mengikuti alur berikut:</p>
            <ol>
                <li>Pemohon keberatan mengisi formulir pengajuan keberatan secara online atau datang langsung ke Kantor PPID.</li>
                <li>Melengkapi nomor registrasi permohonan informasi sebelumnya dan alasan keberatan yang jelas.</li>
                <li>Petugas PPID menerima dan memverifikasi pengajuan keberatan.</li>
                <li>PPID akan memberikan tanggapan atas keberatan paling lambat 30 hari kerja sejak permohonan keberatan diterima.</li>
                <li>Jika keberatan diterima, informasi akan diberikan sesuai prosedur. Jika ditolak, PPID akan memberikan alasan penolakan dan menyampaikan hak pemohon untuk mengajukan sengketa informasi ke Komisi Informasi.</li>
            </ol>
            <p class="text-center mt-4">
                <a href="{{ route('informasi-publik.keberatan.form') }}" class="btn btn-primary btn-lg">Ajukan Keberatan Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection