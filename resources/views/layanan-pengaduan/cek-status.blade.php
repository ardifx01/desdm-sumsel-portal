@extends('layouts.public_app') {{-- Menggunakan layout yang Anda sebutkan --}}

@section('title', 'Cek Status Layanan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cek Status Layanan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Cek Status Layanan / Pengaduan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <p class="lead mb-4">Untuk melacak status permohonan, pengaduan, atau layanan Anda, silakan masukkan nomor registrasi yang telah Anda terima.</p>

            {{-- Formulir Cek Status --}}
            <form action="{{ route('layanan-pengaduan.cek-status.process') }}" method="POST" class="col-md-6 mx-auto">
                @csrf {{-- Penting untuk keamanan Laravel --}}
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg @error('nomor_registrasi') is-invalid @enderror" 
                           placeholder="Masukkan Nomor Registrasi..." 
                           aria-label="Nomor Registrasi" 
                           name="nomor_registrasi" 
                           value="{{ old('nomor_registrasi', $nomorRegistrasi ?? '') }}">
                    <button class="btn btn-primary btn-lg" type="submit">Cek Status</button>
                    @error('nomor_registrasi')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </form>

            <p class="text-muted small mt-4">Catatan: Fitur cek status terintegrasi penuh akan dikembangkan pada fase berikutnya.</p>
        </div>
    </div>

    {{-- Bagian untuk Menampilkan Hasil --}}
    @if (isset($found) && $found) {{-- Tampilkan bagian ini jika ada data ditemukan --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Hasil Cek Status untuk Nomor Registrasi: {{ $nomorRegistrasi }}</h5>
            </div>
            <div class="card-body">
                {{-- Tampilkan Permohonan Informasi jika ada --}}
                @if ($permohonan)
                    <h6 class="mb-3">Detail Permohonan Informasi</h6>
                    <table class="table table-bordered table-striped mt-3">
                        <tbody>
                            <tr>
                                <th>Nama Pemohon</th>
                                <td>{{ $permohonan->nama_pemohon }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $permohonan->email_pemohon }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Registrasi</th>
                                <td>{{ $permohonan->nomor_registrasi }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <strong>{{ $permohonan->status }}</strong>
                                    @if ($permohonan->catatan_admin)
                                        <br><small class="text-muted">Catatan Admin: {{ $permohonan->catatan_admin }}</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Rincian Informasi</th>
                                <td>{{ $permohonan->rincian_informasi }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Permohonan</th>
                                <td>{{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d F Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif

                {{-- Tampilkan Pengajuan Keberatan jika ada --}}
                @if ($keberatan->isNotEmpty())
                    <h6 class="mt-4 mb-3">Detail Pengajuan Keberatan (Terkait)</h6>
                    @foreach ($keberatan as $item_keberatan)
                        <div class="card mb-3">
                            <div class="card-body">
                                <table class="table table-bordered table-striped mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Nama Pemohon</th>
                                            <td>{{ $item_keberatan->nama_pemohon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $item_keberatan->email_pemohon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Registrasi Permohonan</th>
                                            <td>{{ $item_keberatan->nomor_registrasi_permohonan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <strong>{{ $item_keberatan->status }}</strong>
                                                @if ($item_keberatan->catatan_admin)
                                                    <br><small class="text-muted">Catatan Admin: {{ $item_keberatan->catatan_admin }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Alasan Keberatan</th>
                                            <td>{{ $item_keberatan->alasan_keberatan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kasus Posisi</th>
                                            <td>{{ $item_keberatan->kasus_posisi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pengajuan</th>
                                            <td>{{ \Carbon\Carbon::parse($item_keberatan->tanggal_pengajuan)->format('d F Y H:i') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    @else
        {{-- Pesan jika tidak ada data ditemukan sama sekali --}}
        @if (isset($nomorRegistrasi) && $nomorRegistrasi !== '')
            <div class="alert alert-warning text-center mt-4" role="alert">
                Nomor registrasi <strong>{{ $nomorRegistrasi }}</strong> tidak ditemukan. Mohon periksa kembali.
            </div>
        @endif
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('layanan-pengaduan.index') }}" class="btn btn-secondary">Kembali ke Layanan & Pengaduan</a>
    </div>
</div>
@endsection