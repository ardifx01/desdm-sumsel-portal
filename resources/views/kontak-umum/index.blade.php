@extends('layouts.public_app')

@section('title', 'Kontak Dinas')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kontak</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Hubungi Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <p class="lead text-center mb-4">Untuk pertanyaan umum, kolaborasi, atau keperluan lain yang tidak terkait dengan layanan PPID spesifik, silakan gunakan informasi kontak di bawah ini atau kirimkan pesan melalui formulir.</p>

                    <div class="row mb-5">
                        <div class="col-md-6 mb-4">
                            <h5><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Alamat Kantor:</h5>
                            <p class="mb-0">Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</p>
                            <p class="mb-0">Jl. Kapten A. Rivai No.19, 26 Ilir, Kec. Ilir Bar. I,</p>
                            <p class="mb-0">Kota Palembang, Sumatera Selatan 30121</p>
                            {{-- Ganti dengan alamat resmi Dinas ESDM Sumsel --}}

                            <h5 class="mt-4"><i class="bi bi-telephone-fill me-2 text-primary"></i>Telepon & Faksimile:</h5>
                            <p class="mb-0"><a href="tel:+62711xxxxxx" class="text-decoration-none">+62 711 XXXXXX (Telepon)</a></p>
                            <p class="mb-0"><a href="fax:+62711xxxxxx" class="text-decoration-none">+62 711 XXXXXX (Faksimile)</a></p>
                            {{-- Ganti dengan nomor telepon/fax resmi Dinas ESDM Sumsel --}}

                            <h5 class="mt-4"><i class="bi bi-envelope-fill me-2 text-primary"></i>Email Resmi:</h5>
                            <p class="mb-0"><a href="mailto:desdm.sumselprov@gmail.com" class="text-decoration-none">desdm.sumselprov@gmail.com</a></p>
                            {{-- Ganti dengan email resmi Dinas ESDM Sumsel --}}

                            <h5 class="mt-4"><i class="bi bi-clock-fill me-2 text-primary"></i>Jam Operasional Kantor:</h5>
                            <p class="mb-0">Senin - Kamis: 08.00 - 16.00 WIB</p>
                            <p class="mb-0">Jumat: 08.00 - 16.30 WIB</p>
                            {{-- Ganti dengan jam operasional resmi Dinas ESDM Sumsel --}}
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5><i class="bi bi-map-fill me-2 text-primary"></i>Peta Lokasi Kantor Pusat:</h5>
                            <div class="ratio ratio-16x9">
                                {{-- Ganti src dengan embed kode dari Google Maps untuk kantor pusat dinas --}}
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d996.1097973197593!2d104.743526!3d-2.975541!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75dd77fa7bad%3A0x7c3787e83297c183!2sOffice%20of%20Energy%20and%20Mineral%20Resources!5e0!3m2!1sen!2sus!4v1753513285615!5m2!1sen!2sus" 
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <h3 class="mb-4 text-center">Kirim Pesan Kepada Kami</h3>
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
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
                            <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}" required>
                            @error('nama_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email_pengirim" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email_pengirim') is-invalid @enderror" id="email_pengirim" name="email_pengirim" value="{{ old('email_pengirim') }}" required>
                            @error('email_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telp_pengirim" class="form-label">Nomor Telepon/HP (Opsional)</label>
                            <input type="tel" class="form-control @error('telp_pengirim') is-invalid @enderror" id="telp_pengirim" name="telp_pengirim" value="{{ old('telp_pengirim') }}">
                            @error('telp_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subjek" class="form-label">Subjek Pesan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subjek') is-invalid @enderror" id="subjek" name="subjek" value="{{ old('subjek') }}" required>
                            @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan Anda <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('pesan') is-invalid @enderror" id="pesan" name="pesan" rows="5" required>{{ old('pesan') }}</textarea>
                            @error('pesan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- ReCAPTCHA (Jika diimplementasikan) --}}
                        {{-- <div class="mb-3">
                            <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                            @error('g-recaptcha-response') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div> --}}

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