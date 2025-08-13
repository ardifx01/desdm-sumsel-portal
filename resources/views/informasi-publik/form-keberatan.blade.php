@extends('layouts.public_app')

@section('title', 'Formulir Pengajuan Keberatan')

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
        <div class="card-body p-4 p-md-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Terjadi Kesalahan!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-info">
                Anda mengajukan keberatan sebagai <strong>{{ Auth::user()->name }}</strong>.
            </div>

            <form action="{{ route('informasi-publik.keberatan.store') }}" method="POST" class="mt-4">
                @csrf

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Data Permohonan yang Dikeberatan</legend>
                    <div class="mb-3">
                        <label for="nomor_registrasi_permohonan" class="form-label">Nomor Registrasi Permohonan Informasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nomor_registrasi_permohonan') is-invalid @enderror" id="nomor_registrasi_permohonan" name="nomor_registrasi_permohonan" value="{{ old('nomor_registrasi_permohonan', request('no_reg')) }}" placeholder="Contoh: 20250814001" required>
                        <div class="form-text">Masukkan nomor registrasi dari permohonan yang ingin Anda ajukan keberatan. Pastikan permohonan tersebut diajukan oleh akun Anda.</div>
                        @error('nomor_registrasi_permohonan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning btn-lg">Kirim Pengajuan Keberatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection