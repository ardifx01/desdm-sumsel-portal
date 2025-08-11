{{-- Judul Bagian --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Statistik Global</h3>

{{-- Grid untuk Kartu Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Kartu Total Pengunjung -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pengunjung</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $settings['visitors'] ?? 0 }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="bi bi-people-fill text-2xl text-purple-600"></i>
            </div>
        </div>
        @can('manage-users')
        <form action="{{ route('admin.settings.reset-counter') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset counter pengunjung?');" class="mt-4">
            @csrf
            <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition">Reset Counter</button>
        </form>
        @endcan
    </div>

    <!-- Kartu Total Berita -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Berita</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalPosts ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-newspaper text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Kartu Total Dokumen -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Dokumen</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalDokumen ?? 0 }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-file-earmark-text-fill text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Kartu Komentar Menunggu -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Komentar Menunggu</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalCommentsPending ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="bi bi-chat-left-quote-fill text-2xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <!-- Kartu Total Permohonan -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Permohonan</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalPermohonan ?? 0 }}</p>
            </div>
            <div class="bg-red-100 p-3 rounded-full">
                <i class="bi bi-file-earmark-check-fill text-2xl text-red-600"></i>
            </div>
        </div>
    </div>

    <!-- Kartu Total Keberatan -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-gray-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Keberatan</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalKeberatan ?? 0 }}</p>
            </div>
            <div class="bg-gray-200 p-3 rounded-full">
                <i class="bi bi-file-earmark-excel-fill text-2xl text-gray-600"></i>
            </div>
        </div>
    </div>
</div>

<hr class="my-8 border-gray-200">

{{-- Grid untuk Aktivitas & Konten Populer --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Aktivitas & Konten Terkini</h3>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Aktivitas Terkini (Gabungan) -->
    <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Aktivitas Terbaru</h4>
        <div class="space-y-4">
            <!-- Komentar -->
            @forelse($recentComments as $comment)
                <a href="{{ route('admin.comments.show', $comment->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition">
                    <p class="font-semibold text-sm text-gray-800 flex items-center">
                        <i class="bi bi-chat-left-quote-fill text-yellow-500 mr-2"></i> Komentar Baru
                    </p>
                    <p class="text-xs text-gray-600 truncate">{{ $comment->content }}</p>
                    <p class="text-xs text-gray-400 mt-1">di: {{ Str::limit($comment->post->title, 30) }}</p>
                </a>
            @empty
                <p class="text-sm text-gray-500">Tidak ada komentar baru.</p>
            @endforelse

            <!-- Permohonan -->
            @forelse($recentPermohonan as $permohonan)
                <a href="{{ route('admin.permohonan.show', $permohonan->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition">
                    <p class="font-semibold text-sm text-gray-800 flex items-center">
                        <i class="bi bi-file-earmark-check-fill text-red-500 mr-2"></i> Permohonan Baru
                    </p>
                    <p class="text-xs text-gray-600">Oleh: {{ $permohonan->nama_pemohon }}</p>
                    <p class="text-xs text-gray-400 mt-1">No. Reg: {{ $permohonan->no_register }}</p>
                </a>
            @empty
                <p class="text-sm text-gray-500">Tidak ada permohonan baru.</p>
            @endforelse
            
            <!-- Keberatan -->
            @forelse($recentKeberatan as $keberatan)
                <a href="{{ route('admin.keberatan.show', $keberatan->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition">
                    <p class="font-semibold text-sm text-gray-800 flex items-center">
                        <i class="bi bi-file-earmark-excel-fill text-gray-500 mr-2"></i> Keberatan Baru
                    </p>
                    <p class="text-xs text-gray-600">Oleh: {{ $keberatan->nama_pemohon }}</p>
                    <p class="text-xs text-gray-400 mt-1">No. Reg: {{ $keberatan->no_register }}</p>
                </a>
            @empty
                <p class="text-sm text-gray-500">Tidak ada keberatan baru.</p>
            @endforelse
        </div>
    </div>

    <!-- Kolom Konten Populer (Gabungan) -->
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Konten Terpopuler</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h5 class="font-semibold mb-3">Berita</h5>
                <ul class="space-y-3">
                    @forelse($popularPosts as $post)
                        <li class="flex items-center justify-between text-sm">
                            <a href="{{ route('berita.show', $post->slug) }}" target="_blank" class="text-gray-700 hover:text-blue-600 transition truncate pr-4">
                                {{ $post->title }}
                            </a>
                            <span class="flex-shrink-0 font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ $post->hits }} <span class="hidden sm:inline">views</span></span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-3">Dokumen</h5>
                <ul class="space-y-3">
                    @forelse($popularDokumen as $dokumen)
                        <li class="flex items-center justify-between text-sm">
                            <a href="{{ route('publikasi.show', $dokumen->slug) }}" target="_blank" class="text-gray-700 hover:text-blue-600 transition truncate pr-4">
                                {{ $dokumen->judul }}
                            </a>
                            <span class="flex-shrink-0 font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ $dokumen->hits }} <span class="hidden sm:inline">views</span></span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>