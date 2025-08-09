<div class="modal-header">
    <h5 class="modal-title" id="pejabatModalLabel">Profil Pejabat</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-0">
        <div class="col-md-4 d-flex justify-content-center align-items-center p-3" style="min-height: 250px;">
            @php
                $media = $pejabat->getFirstMedia('foto_pejabat');
                $imageExists = $media && file_exists($media->getPath());
            @endphp
            @if($imageExists)
                <img src="{{ $media->getUrl('thumb') }}" alt="Foto {{ $pejabat->nama }}" class="img-fluid rounded-start" width="auto" loading="lazy">
            @else
                <img src="https://placehold.co/400x400/E5E7EB/6B7280?text=No+Photo" alt="No Photo" class="img-fluid rounded-start" width="auto" loading="lazy">
            @endif
        </div>
        <div class="col-md-8">
            <div class="card-body h-100 d-flex flex-column justify-content-center">
                <h3 class="card-title">{{ $pejabat->nama }}</h3>
                <h5 class="text-muted">{{ $pejabat->jabatan }}</h5>
                <div class="p-2">
                    @if($pejabat->deskripsi_singkat)
                        <div class="pejabat-deskripsi">
                            {!! ($pejabat->deskripsi_singkat) !!}
                        </div>
                    @else
                        <p class="text-muted text-center">Profil belum tersedia untuk pejabat ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>