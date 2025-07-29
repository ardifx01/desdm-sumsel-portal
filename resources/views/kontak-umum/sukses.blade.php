@extends('layouts.public_app')

@section('title', 'Pesan Terkirim')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm mb-4">
        <div class="card-body py-5">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            <h2 class="mt-4 mb-3 text-success">Pesan Berhasil Dikirim!</h2>
            @if(session('success'))
                <p class="lead">{{ session('success') }}</p>
            @else
                <p class="lead">Terima kasih, pesan Anda telah berhasil kami terima.</p>
            @endif
            <p>Kami akan meninjau pesan Anda dan akan menghubungi kembali jika diperlukan.</p>
            <hr class="my-4">
            <a href="{{ route('kontak.index') }}" class="btn btn-primary me-2">Kembali ke Halaman Kontak</a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection