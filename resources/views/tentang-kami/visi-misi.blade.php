@extends('layouts.public_app')

@section('title', 'Visi, Misi & Tujuan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li>
            <li class="breadcrumb-item active" aria-current="page">Visi, Misi & Tujuan</li>
        </ol>
    </nav>
    <h2 class="mb-4">Visi, Misi & Tujuan Dinas ESDM Provinsi Sumatera Selatan</h2>

    <h3>Visi</h3>
    <p class="lead">
        "Terwujudnya Tata Kelola Energi dan Sumber Daya Mineral yang Berkeadilan, Berkelanjutan dan Berdaya Saing."
        {{-- Ganti dengan visi resmi DESDM Sumsel --}}
    </p>

    <h3>Misi</h3>
    <ol>
        <li>Meningkatkan kapasitas pengelolaan dan pemanfaatan energi dan sumber daya mineral secara optimal dan berkelanjutan.</li>
        <li>Mengembangkan sistem informasi dan data geologi, energi dan sumber daya mineral yang akurat dan mudah diakses.</li>
        <li>Mendorong investasi di sektor energi dan sumber daya mineral yang ramah lingkungan dan memberikan nilai tambah bagi daerah.</li>
        <li>Meningkatkan kualitas pelayanan publik di bidang energi dan sumber daya mineral.</li>
        {{-- Ganti dengan misi resmi DESDM Sumsel --}}
    </ol>

    <h3>Tujuan</h3>
    <ul>
        <li>Tercapainya peningkatan pendapatan asli daerah dari sektor energi dan sumber daya mineral.</li>
        <li>Terwujudnya ketersediaan dan aksesibilitas energi yang merata bagi masyarakat.</li>
        <li>Terkelolanya sumber daya mineral secara profesional dan berkelanjutan.</li>
        {{-- Ganti dengan tujuan resmi DESDM Sumsel --}}
    </ul>

    <a href="{{ route('tentang-kami.index') }}" class="btn btn-secondary mt-4">Kembali ke Tentang Kami</a>
</div>
@endsection