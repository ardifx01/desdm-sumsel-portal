@extends('layouts.public_app')

@section('title', 'Formulir Pengajuan Keberatan Informasi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.keberatan.prosedur') }}">Alur Pengajuan Keberatan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Formulir Pengajuan Keberatan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Formulir Pengajuan Keberatan Informasi Publik</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('informasi-publik.keberatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Data Pemohon Keberatan</legend>
                    <div class="mb-3">
                        <label for="nomor_registrasi_permohonan" class="form-label">Nomor Registrasi Permohonan Informasi Sebelumnya <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nomor_registrasi_permohonan') is-invalid @enderror" id="nomor_registrasi_permohonan" name="nomor_registrasi_permohonan" value="{{ old('nomor_registrasi_permohonan') }}" placeholder="Contoh: PI/DESDM/2024/0001" required>
                        @error('nomor_registrasi_permohonan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pemohon" class="form-label">Nama Lengkap Pemohon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_pemohon') is-invalid @enderror" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required>
                            @error('nama_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_pemohon" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email_pemohon') is-invalid @enderror" id="email_pemohon" name="email_pemohon" value="{{ old('email_pemohon') }}" required>
                            @error('email_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telp_pemohon" class="form-label">Nomor Telepon/HP</label>
                            <input type="tel" class="form-control @error('telp_pemohon') is-invalid @enderror" id="telp_pemohon" name="telp_pemohon" value="{{ old('telp_pemohon') }}">
                            @error('telp_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="identitas_pemohon" class="form-label">Upload Identitas (KTP/Akta Pendirian) <small>(JPG/PNG/PDF, Max 2MB)</small></label>
                            <input type="file" class="form-control @error('identitas_pemohon') is-invalid @enderror" id="identitas_pemohon" name="identitas_pemohon" accept=".jpg,.jpeg,.png,.pdf">
                            @error('identitas_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="alamat_pemohon" class="form-label">Alamat Lengkap Pemohon <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_pemohon') is-invalid @enderror" id="alamat_pemohon" name="alamat_pemohon" rows="3" required>{{ old('alamat_pemohon') }}</textarea>
                            @error('alamat_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Rincian Keberatan</legend>
                    <div class="mb-3">
                        <label for="jenis_keberatan" class="form-label">Jenis Keberatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_keberatan') is-invalid @enderror" id="jenis_keberatan" name="jenis_keberatan" required>
                            <option value="">-- Pilih Jenis Keberatan --</option>
                            <option value="Info Ditolak" {{ old('jenis_keberatan') == 'Info Ditolak' ? 'selected' : '' }}>Permohonan Informasi Ditolak</option>
                            <option value="Info Tidak Disediakan" {{ old('jenis_keberatan') == 'Info Tidak Disediakan' ? 'selected' : '' }}>Informasi Tidak Disediakan</option>
                            <option value="Info Tidak Ditanggapi" {{ old('jenis_keberatan') == 'Info Tidak Ditanggapi' ? 'selected' : '' }}>Permohonan Informasi Tidak Ditanggapi</option>
                            <option value="Info Tidak Sesuai" {{ old('jenis_keberatan') == 'Info Tidak Sesuai' ? 'selected' : '' }}>Informasi yang Diberikan Tidak Sesuai</option>
                            <option value="Biaya Tidak Wajar" {{ old('jenis_keberatan') == 'Biaya Tidak Wajar' ? 'selected' : '' }}>Biaya yang Diminta Tidak Wajar</option>
                            <option value="Info Terlambat" {{ old('jenis_keberatan') == 'Info Terlambat' ? 'selected' : '' }}>Informasi yang Diminta Terlambat Diberikan</option>
                        </select>
                        @error('jenis_keberatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alasan_keberatan" class="form-label">Alasan Pengajuan Keberatan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan_keberatan') is-invalid @enderror" id="alasan_keberatan" name="alasan_keberatan" rows="5" required>{{ old('alasan_keberatan') }}</textarea>
                        @error('alasan_keberatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kasus_posisi" class="form-label">Kasus Posisi (Kronologi Singkat)</label>
                        <textarea class="form-control @error('kasus_posisi') is-invalid @enderror" id="kasus_posisi" name="kasus_posisi" rows="3">{{ old('kasus_posisi') }}</textarea>
                        @error('kasus_posisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </fieldset>

                {{-- ReCAPTCHA (Jika diimplementasikan) --}}
                {{-- <div class="mb-3">
                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                    @error('g-recaptcha-response') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div> --}}

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning btn-lg">Kirim Pengajuan Keberatan</button>
                    <a href="{{ route('informasi-publik.keberatan.prosedur') }}" class="btn btn-outline-secondary">Kembali ke Prosedur</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script for reCAPTCHA if implemented --}}
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}

@endsection