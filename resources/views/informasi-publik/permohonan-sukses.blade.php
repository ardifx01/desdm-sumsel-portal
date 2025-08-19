@extends('layouts.public_app')

@section('title', 'Permohonan Berhasil Diajukan')

@section('content')
<div class="success-page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card success-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="success-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                        </div>
                        <h1 class="display-6 fw-bold mb-3">Permohonan Berhasil Diajukan!</h1>
                        <p class="lead text-muted">
                            Terima kasih, permohonan informasi Anda telah berhasil kami terima dan sedang dalam antrian untuk diproses.
                        </p>
                        
                        @if(session('nomor_registrasi'))
                            <div class="alert alert-success mt-4 fs-5">
                                Nomor Registrasi Anda: <br>
                                <strong class="font-monospace user-select-all">{{ session('nomor_registrasi') }}</strong>
                                <br>
                                <small class="d-block mt-2">Simpan nomor ini untuk melacak status permohonan Anda.</small>
                            </div>
                        @endif
                        
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-5">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 gap-3">Ke Dasbor Saya</a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg px-4">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection