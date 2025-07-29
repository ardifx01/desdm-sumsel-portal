@extends('layouts.public_app')

@section('title', 'Tugas & Fungsi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tugas & Fungsi</li>
        </ol>
    </nav>
    <h2 class="mb-4">Tugas & Fungsi Dinas ESDM Provinsi Sumatera Selatan</h2>

    <h3>Tugas Pokok</h3>
    <p>Kepala Dinas mempunyai tugas membantu Gubernur menyelenggarakan urusan pemerintahan yang menjadi kewenangan Pemerintah Provinsi 
        di bidang energi dan sumber daya mineral serta tugas pembantuan yang ditugaskan kepada Pemerintah Provinsi.
    </p>

    <h3>Fungsi</h3>
        <ol>
            <li>perumusan kebijakan di bidang energi dan sumber daya mineral;</li>
            <li>pelaksanaan kebijakan di bidang energi dan sumber daya mineral;</li>
            <li>pelaksanaan evaluasi dan pelaporan di bidang energi dan sumber daya mineral;</li>
            <li>pembinaan administrasi dan kepegawaian pada Dinas Energi dan Sumber Daya Mineral;</li>
            <li>pengkoordinasian, penatausahaan, pemanfaatan dan pengamanan barang milik negara/daerah; dan</li>
            <li>pelaksanaan tugas kedinasan lainnya yang diberikan oleh pimpinan.</li>
        </ol>

    <a href="{{ route('tentang-kami.index') }}" class="btn btn-secondary mt-4">Kembali ke Tentang Kami</a>
</div>
@endsection