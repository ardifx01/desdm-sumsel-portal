@extends('layouts.public_app')

@section('title', 'Dasbor Saya')

@section('content')
<div class="bg-light">
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h2 class="mb-1 fw-bold">Dasbor Saya</h2>
                <p class="text-muted">Selamat Datang Kembali, {{ $user->name }}!</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="{{ route('informasi-publik.permohonan.form') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-plus-fill me-1"></i> Ajukan Permohonan
                </a>
                <a href="{{ route('profile.edit.public') }}" class="btn btn-secondary">
                    <i class="bi bi-person-fill-gear me-1"></i> Pengaturan Akun
                </a>
            </div>
        </div>

        {{-- Riwayat Permohonan Informasi --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-journal-text me-2 text-primary"></i>Riwayat Permohonan Informasi Anda</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No. Registrasi</th>
                                <th>Rincian Informasi</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permohonan as $item)
                            <tr>
                                <td><span class="fw-bold font-monospace">{{ $item->nomor_registrasi }}</span></td>
                                <td>{{ Str::limit($item->rincian_informasi, 60) }}</td>
                                <td class="text-center text-muted small">{{ $item->tanggal_permohonan->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill 
                                        @if($item->status == 'Diterima' || $item->status == 'Selesai') bg-success
                                        @elseif($item->status == 'Ditolak') bg-danger
                                        @elseif($item->status == 'Diproses') bg-primary
                                        @else bg-warning text-dark @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('user-dashboard.permohonan.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Anda belum pernah mengajukan permohonan informasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $permohonan->links() }}
                </div>
            </div>
        </div>

        {{-- Riwayat Pengajuan Keberatan --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-shield-exclamation me-2 text-danger"></i>Riwayat Pengajuan Keberatan Anda</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No. Reg Permohonan</th>
                                <th>Alasan Keberatan</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keberatan as $item)
                            <tr>
                                <td><span class="fw-bold font-monospace">{{ $item->nomor_registrasi_permohonan }}</span></td>
                                <td>{{ Str::limit($item->alasan_keberatan, 60) }}</td>
                                <td class="text-center text-muted small">{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill 
                                        @if($item->status == 'Diterima' || $item->status == 'Selesai') bg-success
                                        @elseif($item->status == 'Ditolak') bg-danger
                                        @elseif($item->status == 'Diproses') bg-primary
                                        @else bg-warning text-dark @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('user-dashboard.keberatan.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Anda belum pernah mengajukan keberatan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $keberatan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection