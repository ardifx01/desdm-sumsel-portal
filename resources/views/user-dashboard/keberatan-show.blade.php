@extends('layouts.public_app')

@section('title', 'Detail Pengajuan Keberatan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Keberatan</li>
        </ol>
    </nav>
    <h2 class="mb-2">Detail Pengajuan Keberatan</h2>
    <p class="lead text-muted mb-4">Untuk Permohonan No. Reg: {{ $keberatan->nomor_registrasi_permohonan }}</p>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Data Pengajuan</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th style="width: 40%;">Tanggal Pengajuan</th>
                            <td>{{ $keberatan->tanggal_pengajuan->isoFormat('dddd, D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge 
                                    @if($keberatan->status == 'Diterima' || $keberatan->status == 'Selesai') bg-success
                                    @elseif($keberatan->status == 'Ditolak') bg-danger
                                    @elseif($keberatan->status == 'Diproses') bg-primary
                                    @else bg-warning text-dark @endif">
                                    {{ $keberatan->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Jenis Keberatan</th>
                            <td>{{ $keberatan->jenis_keberatan }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Rincian Keberatan</h5>
                    <p class="fw-bold mb-1">Alasan Pengajuan:</p>
                    <p class="text-muted">{{ $keberatan->alasan_keberatan }}</p>
                    @if($keberatan->kasus_posisi)
                    <p class="fw-bold mb-1 mt-3">Kasus Posisi:</p>
                    <p class="text-muted">{{ $keberatan->kasus_posisi }}</p>
                    @endif
                </div>
            </div>

            @if($keberatan->catatan_admin)
            <hr class="my-4">
            <div>
                <h5 class="mb-3"><i class="bi bi-chat-left-text-fill me-2 text-primary"></i>Tanggapan / Catatan dari Admin</h5>
                <div class="alert alert-primary mb-0">
                    {{ $keberatan->catatan_admin }}
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dasbor</a>
        </div>
    </div>
</div>
@endsection