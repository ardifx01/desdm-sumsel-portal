@extends('layouts.public_app')

@section('title', 'Visi, Misi & Maklumat PPID')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID</a></li>
            <li class="breadcrumb-item active" aria-current="page">Visi, Misi & Maklumat</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Visi, Misi & Maklumat Pelayanan PPID Dinas ESDM Provinsi Sumatera Selatan</h2>

    <h3>Visi PPID</h3>
    <p class="lead">
        "Terwujudnya Pelayanan Informasi Publik yang Transparan, Akuntabel, dan Inklusif demi Terpenuhinya Hak Masyarakat atas Informasi."
        {{-- Ganti dengan visi resmi PPID DESDM Sumsel --}}
    </p>

    <h3>Misi PPID</h3>
    <ol>
        <li>Meningkatkan kualitas pengelolaan dan pelayanan informasi publik yang mudah diakses.</li>
        <li>Menyediakan informasi publik secara cepat, tepat waktu, akurat, dan biaya ringan.</li>
        <li>Membangun sistem dokumentasi dan pengarsipan informasi yang tertib dan modern.</li>
        <li>Meningkatkan kapasitas dan kompetensi petugas PPID dalam melayani masyarakat.</li>
        {{-- Ganti dengan misi resmi PPID DESDM Sumsel --}}
    </ol>

    <h3>Maklumat Pelayanan PPID</h3>
    <div class="alert alert-info" role="alert">
        <p class="mb-0">"Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan informasi publik sesuai standar operasional prosedur yang telah ditetapkan dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai peraturan perundang-undangan yang berlaku."</p>
        {{-- Ganti dengan maklumat pelayanan resmi PPID DESDM Sumsel --}}
    </div>

    <a href="{{ route('informasi-publik.profil-ppid.index') }}" class="btn btn-secondary mt-4">Kembali ke Profil PPID</a>
</div>
@endsection