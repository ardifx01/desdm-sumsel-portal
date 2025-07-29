@extends('layouts.public_app')

@section('title', 'Permohonan Berhasil')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm mb-4">
        <div class="card-body py-5">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            <h2 class="mt-4 mb-3 text-success">Permohonan Informasi Berhasil Diajukan!</h2>
            @if(session('success'))
                <p class="lead">{{ session('success') }}</p>
            @else
                <p class="lead">Terima kasih, permohonan informasi Anda telah berhasil kami terima.</p>
            @endif
            <p>Petugas kami akan segera memproses permohonan Anda. Mohon tunggu konfirmasi lebih lanjut melalui email yang Anda daftarkan.</p>
            <hr class="my-4">
            <a href="{{ route('informasi-publik.index') }}" class="btn btn-primary me-2">Kembali ke Informasi Publik</a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection