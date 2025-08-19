@extends('layouts.public_app')

@section('title', 'Kontak Dinas')

@section('content')

{{-- Hero Section --}}
<div class="page-hero py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kontak</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold">Hubungi Kami</h1>
        <p class="lead text-muted">Kami siap menerima pertanyaan, masukan, atau informasi lainnya dari Anda.</p>
    </div>
</div>

<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-lg-5">
            <div class="row g-5">
                {{-- Kolom Kiri: Informasi Kontak & Peta --}}
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                    <div class="vstack gap-4">
                        {{-- Alamat --}}
                        <div class="contact-item">
                            <i class="bi bi-geo-alt-fill contact-icon"></i>
                            <div class="contact-info">
                                <h5>Alamat Kantor</h5>
                                <p>{{ $settings['alamat_kantor'] ?? 'Alamat belum diatur' }}</p>
                            </div>
                        </div>
                        {{-- Telepon --}}
                        <div class="contact-item">
                            <i class="bi bi-telephone-fill contact-icon"></i>
                            <div class="contact-info">
                                <h5>Telepon</h5>
                                <p><a href="tel:{{ $settings['telp_kontak'] ?? '' }}">{{ $settings['telp_kontak'] ?? 'Telepon belum diatur' }}</a></p>
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="contact-item">
                            <i class="bi bi-envelope-fill contact-icon"></i>
                            <div class="contact-info">
                                <h5>Email</h5>
                                <p><a href="mailto:{{ $settings['email_kontak'] ?? '' }}">{{ $settings['email_kontak'] ?? 'Email belum diatur' }}</a></p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-clock-fill contact-icon"></i>
                            <div class="contact-info">
                                <h5>Jam Operasional Kantor</h5>
                                <table class="table table-sm table-borderless text-muted">
                                    <tbody>
                                        <tr><td style="width: 120px;">Senin - Kamis</td><td>: 08.00 - 16.00 WIB</td></tr>
                                        <tr><td>Jumat</td><td>: 08.00 - 16.30 WIB</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>
                    
                    <hr class="my-4">

                    <div class="map-container rounded shadow-sm">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d996.1097973197593!2d104.743526!3d-2.975541!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75dd77fa7bad%3A0x7c3787e83297c183!2sOffice%20of%20Energy%20and%20Mineral%20Resources!5e0!3m2!1sen!2sus!4v1753513285615!5m2!1sen!2sus" 
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                {{-- Kolom Kanan: Formulir Kontak --}}
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-4">Kirim Pesan Kepada Kami</h3>
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kontak.send-mail') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_pengirim" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_pengirim" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email_pengirim" name="email_pengirim" value="{{ old('email_pengirim') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="subjek" class="form-label">Subjek Pesan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="subjek" name="subjek" value="{{ old('subjek') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan Anda <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="5" required>{{ old('pesan') }}</textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection