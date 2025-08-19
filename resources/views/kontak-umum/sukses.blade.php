@extends('layouts.public_app')

@section('title', 'Pesan Terkirim')

@section('content')
<div class="success-page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card success-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="success-icon">
                                <i class="bi bi-envelope-check-fill"></i>
                            </div>
                        </div>
                        <h1 class="display-6 fw-bold mb-3">Pesan Berhasil Terkirim!</h1>
                        <p class="lead text-muted">
                            @if(session('success'))
                                {{ session('success') }}
                            @else
                                Terima kasih, pesan Anda telah berhasil kami terima.
                            @endif
                        </p>
                        
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-5">
                            <a href="{{ route('kontak.index') }}" class="btn btn-primary btn-lg px-4 gap-3">Kirim Pesan Lain</a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg px-4">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection