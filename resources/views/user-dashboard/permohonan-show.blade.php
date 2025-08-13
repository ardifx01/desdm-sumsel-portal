@extends('layouts.public_app')

@section('title', 'Detail Permohonan Informasi')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Permohonan</li>
        </ol>
    </nav>
    <h2 class="mb-2">Detail Permohonan Informasi</h2>
    <p class="lead text-muted mb-4">Nomor Registrasi: {{ $permohonan->nomor_registrasi }}</p>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Data Permohonan</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th style="width: 40%;">Tanggal Permohonan</th>
                            <td>{{ $permohonan->tanggal_permohonan->isoFormat('dddd, D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge 
                                    @if($permohonan->status == 'Diterima' || $permohonan->status == 'Selesai') bg-success
                                    @elseif($permohonan->status == 'Ditolak') bg-danger
                                    @elseif($permohonan->status == 'Diproses') bg-primary
                                    @else bg-warning text-dark @endif">
                                    {{ $permohonan->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Mengajukan Atas Nama</th>
                            <td>{{ $permohonan->jenis_pemohon }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $permohonan->pekerjaan_pemohon ?: '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Rincian & Tujuan</h5>
                    <p class="fw-bold mb-1">Rincian Informasi yang Diminta:</p>
                    <p class="text-muted">{{ $permohonan->rincian_informasi }}</p>
                    <p class="fw-bold mb-1 mt-3">Tujuan Penggunaan Informasi:</p>
                    <p class="text-muted">{{ $permohonan->tujuan_penggunaan_informasi ?: '-' }}</p>
                </div>
            </div>

            @if($permohonan->catatan_admin)
            <hr class="my-4">
            <div>
                <h5 class="mb-3"><i class="bi bi-chat-left-text-fill me-2 text-primary"></i>Tanggapan / Catatan dari Admin</h5>
                <div class="alert alert-primary mb-0">
                    {{ $permohonan->catatan_admin }}
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dasbor</a>
            
            <div>
                <small class="text-muted me-2">Tidak puas dengan hasil ini?</small>
                <a href="{{ route('informasi-publik.keberatan.form', ['no_reg' => $permohonan->nomor_registrasi]) }}" class="btn btn-warning">
                    <i class="bi bi-shield-exclamation me-1"></i> Ajukan Keberatan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection