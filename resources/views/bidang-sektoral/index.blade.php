@extends('layouts.public_app')

@section('title', 'Bidang & Data Sektoral')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bidang</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Bidang, Unit Pelaksana Teknis Dinas, & Cabang Dinas Regional</h2>

    <p class="lead text-center mb-5">Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan memiliki struktur organisasi yang terdiri dari Sekretariat, 
        Bidang Teknis, UPTD, dan Cabang Dinas Regional untuk melayani masyarakat secara komprehensif.</p>

    <div class="row">
        @forelse($bidangs as $bidang) {{-- Menggunakan variabel $bidangs dari controller --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0 pejabat-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $bidang->nama }}</h5>
                    {{-- Menampilkan tipe bidang --}}
                    {{-- <p class="card-text text-muted small mb-2">Tipe: {{ Str::title(str_replace('_', ' ', $bidang->tipe)) }}</p>  --}}
                    
                    {{-- Menampilkan deskripsi singkat dari tupoksi, jika ada --}}
                    @if($bidang->tupoksi)
                        <p class="card-text">{{ Str::limit(strip_tags($bidang->tupoksi), 120) }}</p>
                    @else
                        <p class="card-text">Belum ada deskripsi singkat tersedia.</p>
                    @endif
                    
                    <a href="{{ route('bidang-sektoral.show', $bidang->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Profil</a>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    Belum ada Bidang, UPTD, atau Cabang Dinas yang aktif untuk ditampilkan.
                </div>
            </div>
        @endforelse
    </div>

    <hr class="my-5">

    <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>

</div>
@endsection