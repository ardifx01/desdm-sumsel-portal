@extends('layouts.public_app')

@section('title', 'Profil Pimpinan')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('tentang-kami.index') }}">Tentang Kami</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">Profil Pimpinan</li>
        </ol>
    </nav>
    <h2 class="mb-4 text-center">Profil Pimpinan Dinas ESDM Provinsi Sumatera Selatan</h2>

    <div class="row">
        @forelse($pejabat as $p)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 pejabat-card">
                    <div class="card-body text-center">
                        @php
                            $media = $p->getFirstMedia('foto_pejabat');
                            $imageExists = false;
                            if ($media) {
                                // Dapatkan path absolut file fisik
                                $mediaPath = $media->getPath();
                                // Cek apakah file fisik ada di server
                                if (file_exists($mediaPath)) {
                                    $imageExists = true;
                                }
                            }
                        @endphp

                        @if($imageExists)
                            <img
                                src="{{ $media->getUrl('thumb') }}"
                                alt="Foto {{ $p->nama }}"
                                class="img-fluid rounded-circle mx-auto d-block mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;"
                                loading="lazy"
                            />
                        @else
                            <img
                                src="https://placehold.co/150x150/E5E7EB/6B7280?text=No+Photo"
                                alt="No Photo"
                                class="img-fluid rounded-circle mx-auto d-block mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;"
                            />
                        @endif
                        <h5 class="card-title">{{ $p->nama }}</h5>
                        <p class="card-text text-muted mb-2">{{ $p->jabatan }}</p>
                        @if($p->nip)
                            <p class="card-text small text-secondary">NIP: {{ $p->nip }}</p>
                        @endif
                        {{-- <a href="{{ route('tentang-kami.detail-pimpinan', $p->id) }}" class="btn btn-sm btn-primary mt-3">Lihat Detail</a> --}}
                        {{-- Ganti tautan Lihat Detail menjadi pemicu modal --}}
                        <a href="#" class="btn btn-sm btn-primary mt-3"
                            data-bs-toggle="modal"
                            data-bs-target="#pejabatModal"
                            data-pejabat-id="{{ $p->id }}">
                            Lihat Detail
                        </a>                        
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada data pimpinan yang tersedia.</p>
            </div>
        @endforelse
    </div>
    <div class="text-center mt-4">
                <button onclick="history.back()" class="btn btn-secondary btn-lg">Kembali</button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Kembali ke Beranda</a>
    </div>

</div>

<div class="modal fade" id="pejabatModal" tabindex="-1" aria-labelledby="pejabatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="pejabat-loading text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var pejabatModal = document.getElementById('pejabatModal');
        pejabatModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var pejabatId = button.getAttribute('data-pejabat-id');
            
            var modalContent = pejabatModal.querySelector('.modal-content');
            modalContent.innerHTML = `
                <div class="modal-body text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            // Lakukan permintaan AJAX
            fetch(`{{ route('pejabat.showModal', ['pejabat' => ':pejabatId']) }}`.replace(':pejabatId', pejabatId))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    pejabatModal.querySelector('.modal-content').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = `
                        <div class="modal-header">
                            <h5 class="modal-title">Error</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p>Terjadi kesalahan saat memuat data profil.</p>
                        </div>
                    `;
                });
        });
    });
</script>
@endpush
@endsection