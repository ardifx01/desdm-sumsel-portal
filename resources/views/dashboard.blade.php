<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(Auth::user()->role === 'super_admin')
                        {{-- Dashboard untuk Super Admin --}}
                        <h3 class="fw-bold mb-4">Ringkasan Statistik Global</h3>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Pengunjung</p>
                                    <h1 class="display-4 fw-bold">{{ $settings['visitors'] ?? 0 }}</h1>
                                    @can('manage-users')
                                    <form action="{{ route('admin.settings.reset-counter') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset counter pengunjung?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger mt-3">Reset Counter</button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Berita</p>
                                    <h1 class="display-4 fw-bold">{{ $totalPosts ?? 0 }}</h1>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Dokumen</p>
                                    <h1 class="display-4 fw-bold">{{ $totalDokumen ?? 0 }}</h1>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Komentar Menunggu</p>
                                    <h1 class="display-4 fw-bold">{{ $totalCommentsPending ?? 0 }}</h1>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Permohonan</p>
                                    <h1 class="display-4 fw-bold">{{ $totalPermohonan ?? 0 }}</h1>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Keberatan</p>
                                    <h1 class="display-4 fw-bold">{{ $totalKeberatan ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <h3 class="fw-bold mb-4">Aktivitas Terkini</h3>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">Komentar Menunggu Moderasi ({{ $totalCommentsPending ?? 0 }})</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($recentComments as $comment)
                                            <li class="list-group-item">
                                                <a href="{{ route('admin.comments.show', $comment->id) }}" class="text-decoration-none text-dark d-block">
                                                    {{ Str::limit($comment->content, 50) }}
                                                    <small class="d-block text-muted">di post: "{{ Str::limit($comment->post->title, 25) }}"</small>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada komentar pending.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">Permohonan Informasi Terbaru ({{ $totalPermohonan ?? 0 }})</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($recentPermohonan as $permohonan)
                                            <li class="list-group-item">
                                                <a href="{{ route('admin.permohonan.show', $permohonan->id) }}" class="text-decoration-none text-dark d-block">
                                                    {{ $permohonan->nama_pemohon }}
                                                    <small class="d-block text-muted">No. Reg: {{ $permohonan->no_register }}</small>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada permohonan baru.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">Pengajuan Keberatan Terbaru ({{ $totalKeberatan ?? 0 }})</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($recentKeberatan as $keberatan)
                                            <li class="list-group-item">
                                                <a href="{{ route('admin.keberatan.show', $keberatan->id) }}" class="text-decoration-none text-dark d-block">
                                                    {{ $keberatan->nama_pemohon }}
                                                    <small class="d-block text-muted">No. Reg: {{ $keberatan->no_register }}</small>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada keberatan baru.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <h3 class="fw-bold mb-4">Konten Populer</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">5 Berita Terpopuler</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($popularPosts as $post)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="{{ route('berita.show', $post->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($post->title, 50) }}
                                                </a>
                                                <span class="badge bg-primary rounded-pill">{{ $post->hits }} Views</span>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada berita.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">5 Dokumen Terpopuler</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($popularDokumen as $dokumen)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="{{ route('publikasi.show', $dokumen->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($dokumen->judul, 50) }}
                                                </a>
                                                <span class="badge bg-primary rounded-pill">{{ $dokumen->hits }} Views</span>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada dokumen.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                    @elseif(Auth::user()->role === 'ppid_admin')
                        {{-- Dashboard untuk PPID Admin --}}
                        <h3 class="fw-bold mb-4">Ringkasan Statistik PPID</h3>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Permohonan</p>
                                    <h1 class="display-4 fw-bold">{{ $totalPermohonan ?? 0 }}</h1>
                                    <p class="text-muted mt-2">Ditolak: {{ $permohonanStatus['Ditolak'] ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Keberatan</p>
                                    <h1 class="display-4 fw-bold">{{ $totalKeberatan ?? 0 }}</h1>
                                    <p class="text-muted mt-2">Ditolak: {{ $keberatanStatus['Ditolak'] ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Informasi Publik</p>
                                    <h1 class="display-4 fw-bold">{{ $totalInformasiPublik ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <h3 class="fw-bold mb-4">Aktivitas Terkini</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header fw-bold">Permohonan Informasi Terbaru</div>
                                        <ul class="list-group list-group-flush">
                                            @forelse($recentPermohonan as $permohonan)
                                                <li class="list-group-item">
                                                    <a href="{{ route('admin.permohonan.show', $permohonan->id) }}" class="text-decoration-none text-dark d-block">
                                                        {{ $permohonan->nama_pemohon }}
                                                        <small class="d-block text-muted">No. Reg: {{ $permohonan->no_register }}</small>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">Tidak ada permohonan baru.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header fw-bold">Pengajuan Keberatan Terbaru</div>
                                        <ul class="list-group list-group-flush">
                                            @forelse($recentKeberatan as $keberatan)
                                                <li class="list-group-item">
                                                    <a href="{{ route('admin.keberatan.show', $keberatan->id) }}" class="text-decoration-none text-dark d-block">
                                                        {{ $keberatan->nama_pemohon }}
                                                        <small class="d-block text-muted">No. Reg: {{ $keberatan->no_register }}</small>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">Tidak ada keberatan baru.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif(Auth::user()->role === 'editor')
                        {{-- Dashboard untuk Editor --}}
                        <h3 class="fw-bold mb-4">Ringkasan Konten</h3>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Berita</p>
                                    <h1 class="display-4 fw-bold">{{ $totalPosts ?? 0 }}</h1>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Dokumen</p>
                                    <h1 class="display-4 fw-bold">{{ $totalDokumen ?? 0 }}</h1>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card p-4 h-100 shadow-sm">
                                    <p class="text-muted mb-2">Total Album</p>
                                    <h1 class="display-4 fw-bold">{{ $totalAlbums ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-5">

                        <h3 class="fw-bold mb-4">Konten Populer & Aktivitas</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">5 Berita Terpopuler</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($popularPosts as $post)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="{{ route('berita.show', $post->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($post->title, 50) }}
                                                </a>
                                                <span class="badge bg-primary rounded-pill">{{ $post->hits }} Views</span>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada berita.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold">5 Komentar Menunggu Moderasi ({{ count($pendingComments ?? []) }})</div>
                                    <ul class="list-group list-group-flush">
                                        @forelse($pendingComments as $comment)
                                            <li class="list-group-item">
                                                <a href="{{ route('admin.comments.show', $comment->id) }}" class="text-decoration-none text-dark d-block">
                                                    {{ Str::limit($comment->content, 50) }}
                                                    <small class="d-block text-muted">di post: "{{ Str::limit($comment->post->title, 25) }}"</small>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">Tidak ada komentar pending.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Dashboard Default untuk role 'user' --}}
                        <div class="alert alert-info" role="alert">
                            Anda masuk sebagai pengguna biasa. Dashboard ini hanya menampilkan data dasar.
                        </div>
                        <h3 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-muted">Anda berhasil masuk ke sistem.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>