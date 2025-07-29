@extends('layouts.public_app')

@section('title', 'Formulir Permohonan Informasi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informasi-publik.permohonan.prosedur') }}">Alur Permohonan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Formulir Permohonan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Formulir Permohonan Informasi Publik</h2>

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

            <form action="{{ route('informasi-publik.permohonan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Data Pemohon</legend>
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
                            <label for="pekerjaan_pemohon" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control @error('pekerjaan_pemohon') is-invalid @enderror" id="pekerjaan_pemohon" name="pekerjaan_pemohon" value="{{ old('pekerjaan_pemohon') }}">
                            @error('pekerjaan_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="alamat_pemohon" class="form-label">Alamat Lengkap Pemohon <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_pemohon') is-invalid @enderror" id="alamat_pemohon" name="alamat_pemohon" rows="3" required>{{ old('alamat_pemohon') }}</textarea>
                            @error('alamat_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_pemohon" class="form-label">Jenis Pemohon <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_pemohon') is-invalid @enderror" id="jenis_pemohon" name="jenis_pemohon" required>
                                <option value="">-- Pilih Jenis Pemohon --</option>
                                <option value="Perorangan" {{ old('jenis_pemohon') == 'Perorangan' ? 'selected' : '' }}>Perorangan</option>
                                <option value="Badan Hukum" {{ old('jenis_pemohon') == 'Badan Hukum' ? 'selected' : '' }}>Badan Hukum</option>
                                <option value="Kelompok Masyarakat" {{ old('jenis_pemohon') == 'Kelompok Masyarakat' ? 'selected' : '' }}>Kelompok Masyarakat</option>
                            </select>
                            @error('jenis_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="identitas_pemohon" class="form-label">Upload Identitas (KTP/Akta Pendirian) <small>(JPG/PNG/PDF, Max 2MB)</small></label>
                            <input type="file" class="form-control @error('identitas_pemohon') is-invalid @enderror" id="identitas_pemohon" name="identitas_pemohon" accept=".jpg,.jpeg,.png,.pdf">
                            @error('identitas_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Rincian Informasi yang Dimohon</legend>
                    <div class="mb-3">
                        <label for="rincian_informasi" class="form-label">Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('rincian_informasi') is-invalid @enderror" id="rincian_informasi" name="rincian_informasi" rows="5" required>{{ old('rincian_informasi') }}</textarea>
                        @error('rincian_informasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tujuan_penggunaan_informasi" class="form-label">Tujuan Penggunaan Informasi</label>
                        <textarea class="form-control @error('tujuan_penggunaan_informasi') is-invalid @enderror" id="tujuan_penggunaan_informasi" name="tujuan_penggunaan_informasi" rows="3">{{ old('tujuan_penggunaan_informasi') }}</textarea>
                        @error('tujuan_penggunaan_informasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </fieldset>

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Cara Memperoleh Informasi</legend>
                    <div class="mb-3">
                        <label class="form-label">Cara Memperoleh Informasi <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_informasi" id="caraMelihat" value="Melihat" {{ old('cara_mendapatkan_informasi') == 'Melihat' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="caraMelihat">Melihat/Membaca/Mendengar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_informasi" id="caraSalinanSoftcopy" value="Mendapatkan Salinan Softcopy" {{ old('cara_mendapatkan_informasi') == 'Mendapatkan Salinan Softcopy' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="caraSalinanSoftcopy">Mendapatkan Salinan Softcopy</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_informasi" id="caraSalinanHardcopy" value="Mendapatkan Salinan Hardcopy" {{ old('cara_mendapatkan_informasi') == 'Mendapatkan Salinan Hardcopy' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="caraSalinanHardcopy">Mendapatkan Salinan Hardcopy</label>
                            </div>
                        </div>
                        @error('cara_mendapatkan_informasi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3" id="caraSalinanOptions" style="display: {{ old('cara_mendapatkan_informasi') && (old('cara_mendapatkan_informasi') == 'Mendapatkan Salinan Softcopy' || old('cara_mendapatkan_informasi') == 'Mendapatkan Salinan Hardcopy') ? 'block' : 'none' }};">
                        <label class="form-label">Cara Mendapatkan Salinan</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_salinan" id="salinanAmbil" value="Mengambil Langsung" {{ old('cara_mendapatkan_salinan') == 'Mengambil Langsung' ? 'checked' : '' }}>
                                <label class="form-check-label" for="salinanAmbil">Mengambil Langsung</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_salinan" id="salinanPos" value="Pos" {{ old('cara_mendapatkan_salinan') == 'Pos' ? 'checked' : '' }}>
                                <label class="form-check-label" for="salinanPos">Dikirim Lewat Pos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_salinan" id="salinanEmail" value="Email" {{ old('cara_mendapatkan_salinan') == 'Email' ? 'checked' : '' }}>
                                <label class="form-check-label" for="salinanEmail">Dikirim Lewat Email</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cara_mendapatkan_salinan" id="salinanFax" value="Fax" {{ old('cara_mendapatkan_salinan') == 'Fax' ? 'checked' : '' }}>
                                <label class="form-check-label" for="salinanFax">Dikirim Lewat Fax</label>
                            </div>
                        </div>
                        @error('cara_mendapatkan_salinan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </fieldset>

                {{-- ReCAPTCHA (Jika diimplementasikan) --}}
                {{-- <div class="mb-3">
                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                    @error('g-recaptcha-response') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div> --}}

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg">Kirim Permohonan</button>
                    <a href="{{ route('informasi-publik.permohonan.prosedur') }}" class="btn btn-outline-secondary">Kembali ke Prosedur</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const caraMendapatkanInformasiRadios = document.querySelectorAll('input[name="cara_mendapatkan_informasi"]');
        const caraSalinanOptions = document.getElementById('caraSalinanOptions');

        function toggleCaraSalinanOptions() {
            const selectedValue = document.querySelector('input[name="cara_mendapatkan_informasi"]:checked');
            if (selectedValue && (selectedValue.value === 'Mendapatkan Salinan Softcopy' || selectedValue.value === 'Mendapatkan Salinan Hardcopy')) {
                caraSalinanOptions.style.display = 'block';
                caraSalinanOptions.querySelectorAll('input[type="radio"]').forEach(radio => radio.required = true);
            } else {
                caraSalinanOptions.style.display = 'none';
                caraSalinanOptions.querySelectorAll('input[type="radio"]').forEach(radio => radio.required = false);
                caraSalinanOptions.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false); // Clear selection if hidden
            }
        }

        caraMendapatkanInformasiRadios.forEach(radio => {
            radio.addEventListener('change', toggleCaraSalinanOptions);
        });

        // Initial check on page load
        toggleCaraSalinanOptions();
    });
</script>

{{-- Script for reCAPTCHA if implemented --}}
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}

@endsection