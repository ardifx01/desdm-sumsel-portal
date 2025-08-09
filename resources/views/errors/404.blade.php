@extends('layouts.public_app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-1 fw-bold text-primary">404</h1>
            <h2 class="display-4 fw-bold">Halaman Tidak Ditemukan</h2>
            <p class="lead mt-4 mb-4">
                Oops! Sepertinya Anda tersesat. <br>
                Halaman yang Anda cari mungkin telah dipindahkan, diubah, atau tidak pernah ada.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection