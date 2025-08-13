@extends('layouts.public_app')

@section('title', 'Pengajuan Keberatan Berhasil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm text-center border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        {{-- Ikon centang hijau --}}
                        <svg class="text-success mx-auto" style="width: 80px; height: 80px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h2 class="card-title h3 mb-3">Pengajuan Keberatan Berhasil Dikirim!</h2>
                    <p class="card-text text-muted">
                        Terima kasih, pengajuan keberatan Anda telah berhasil kami terima.
                    </p>
                    <p class="card-text text-muted mt-3">
                        Petugas kami akan segera menindaklanjuti pengajuan Anda. Anda dapat memantau statusnya di dasbor Anda.
                    </p>
                    
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        {{-- TOMBOL BARU DITAMBAHKAN DI SINI --}}
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="bi bi-speedometer2 me-1"></i> Kembali ke Dasbor Saya
                        </a>
                        <a href="{{ route('informasi-publik.index') }}" class="btn btn-outline-secondary">
                            Kembali ke Informasi Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection