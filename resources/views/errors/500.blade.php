@extends('layouts.public_app')

@section('title', 'Kesalahan Server')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="display-1 fw-bold text-warning opacity-25">500</div>
            <h1 class="display-4 fw-bold mt-4">Terjadi Kesalahan Server</h1>
            <p class="lead text-muted my-3">
                Maaf, terjadi masalah pada server kami. Tim kami telah diberitahu dan sedang menanganinya. Silakan coba lagi nanti.
            </p>

            @if(app()->bound('debug') && config('app.debug'))
                <div class="alert alert-warning text-start small">
                    <strong>Pesan Error (Debug Mode):</strong><br>
                    {{ $exception->getMessage() ?: 'Tidak ada pesan error spesifik.' }}
                </div>
            @endif

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection