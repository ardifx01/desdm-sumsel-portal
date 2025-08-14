{{-- Bagian 1: Statistik Konten Umum --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Konten & Interaksi</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    
    {{-- Kartu Total Pengunjung --}}
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
        <div class="mt-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-xs">
            {{-- PERBAIKAN DI SINI: Menggunakan warna standar --}}
            @php $colorIndex = 0; $colors = ['green', 'gray', 'yellow', 'red', 'blue', 'pink', 'orange']; @endphp
            @forelse($postCategories as $category => $total)
                @php $color = $colors[$colorIndex % count($colors)]; $colorIndex++; @endphp
                <span class="px-2 py-1 rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 font-semibold">{{ $category }}: {{ $total }}</span>
            @empty
                <span class="text-gray-400">Belum ada kategori.</span>
            @endforelse
        </div>
    </div>

    <!-- Kartu Total Dokumen Publikasi -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Dokumen Publikasi</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalDokumen ?? 0 }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-file-earmark-text-fill text-2xl text-green-600"></i>
            </div>
        </div>
        <div class="mt-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-xs">
            {{-- PERBAIKAN DI SINI: Menggunakan warna standar --}}
            @php $colorIndex = 0; $colors = ['green', 'gray', 'yellow', 'red', 'blue', 'indigo', 'purple']; @endphp
            @forelse($dokumenCategories as $category => $total)
                @php $color = $colors[$colorIndex % count($colors)]; $colorIndex++; @endphp
                <span class="px-2 py-1 rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 font-semibold">{{ $category }}: {{ $total }}</span>
            @empty
                <span class="text-gray-400">Belum ada kategori.</span>
            @endforelse
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
</div>

{{-- Bagian 2: Statistik Layanan PPID --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Layanan PPID</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Kartu Total Informasi Publik (BARU) -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-cyan-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Informasi Publik</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalInformasiPublik ?? 0 }}</p>
            </div>
            <div class="bg-cyan-100 p-3 rounded-full">
                <i class="bi bi-info-circle-fill text-2xl text-cyan-600"></i>
            </div>
        </div>
        <div class="mt-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-xs">
            {{-- PERBAIKAN DI SINI: Menggunakan warna standar --}}
            @php $colorIndex = 0; $colors = ['yellow', 'green', 'indigo']; @endphp
            @forelse($infoPublikCategories as $category => $total)
                @php $color = $colors[$colorIndex % count($colors)]; $colorIndex++; @endphp
                <span class="px-2 py-1 rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 font-semibold">{{ $category }}: {{ $total }}</span>
            @empty
                <span class="text-gray-400">Belum ada kategori.</span>
            @endforelse
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
        <div class="mt-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-xs">
            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">Menunggu: {{ $permohonanStatus['Menunggu Diproses'] ?? 0 }}</span>
            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">Diproses: {{ $permohonanStatus['Diproses'] ?? 0 }}</span>
            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold">Selesai: {{ $permohonanStatus['Selesai'] ?? 0 }}</span>
            <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 font-semibold">Ditolak: {{ $permohonanStatus['Ditolak'] ?? 0 }}</span>
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
        <div class="mt-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-xs">
            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">Menunggu: {{ $keberatanStatus['Menunggu Diproses'] ?? 0 }}</span>
            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">Diproses: {{ $keberatanStatus['Diproses'] ?? 0 }}</span>
            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold">Selesai: {{ $keberatanStatus['Selesai'] ?? 0 }}</span>
            <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 font-semibold">Ditolak: {{ $keberatanStatus['Ditolak'] ?? 0 }}</span>
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
                    {{-- PERBAIKAN DI SINI --}}
                    <p class="text-xs text-gray-600">Oleh: {{ $permohonan->user->name ?? '[N/A]' }}</p>
                    <p class="text-xs text-gray-400 mt-1">No. Reg: {{ $permohonan->nomor_registrasi }}</p>
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
                    {{-- PERBAIKAN DI SINI --}}
                    <p class="text-xs text-gray-600">Oleh: {{ $keberatan->user->name ?? '[N/A]' }}</p>
                    <p class="text-xs text-gray-400 mt-1">No. Reg Permohonan: {{ $keberatan->nomor_registrasi_permohonan }}</p>
                </a>
            @empty
                <p class="text-sm text-gray-500">Tidak ada keberatan baru.</p>
            @endforelse
        </div>
    </div>

    <!-- Kolom Konten Populer (Gabungan) -->
    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Konten Terpopuler</h4>
{{-- PERUBAHAN DI SINI: Menggunakan grid 3 baris --}}
        <div class="grid grid-cols-1 gap-y-6">
            
            {{-- Baris 1: Berita --}}
            <div>
                <h5 class="font-semibold mb-3 flex items-center text-gray-700"><i class="bi bi-newspaper mr-2"></i>Berita</h5>
                <ul class="space-y-3">
                    @forelse($popularPosts as $post)
                        <li class="flex items-center justify-between text-sm">
                            <a href="{{ route('berita.show', $post->slug) }}" target="_blank" class="text-gray-700 hover:text-blue-600 transition truncate pr-4" title="{{ $post->title }}">
                                {{ Str::limit($post->title, 50) }}
                            </a>
                            <span class="flex-shrink-0 font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ $post->hits }} views</span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Tidak ada data berita.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Baris 2: Dokumen Publikasi --}}
            <div>
                <h5 class="font-semibold mb-3 flex items-center text-gray-700"><i class="bi bi-file-earmark-text-fill mr-2"></i>Dokumen Publikasi</h5>
                <ul class="space-y-3">
                    @forelse($popularDokumen as $dokumen)
                        <li class="flex items-center justify-between text-sm">
                            <a href="{{ route('publikasi.show', $dokumen->slug) }}" target="_blank" class="text-gray-700 hover:text-blue-600 transition truncate pr-4" title="{{ $dokumen->judul }}">
                                {{ Str::limit($dokumen->judul, 50) }}
                            </a>
                            <span class="flex-shrink-0 font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ $dokumen->hits }} views</span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Tidak ada data dokumen.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Baris 3: Informasi Publik (PPID) --}}
            <div>
                <h5 class="font-semibold mb-3 flex items-center text-gray-700"><i class="bi bi-info-square-fill mr-2"></i>Informasi Publik (PPID)</h5>
                <ul class="space-y-3">
                    @forelse($popularInformasiPublik as $info)
                        <li class="flex items-center justify-between text-sm">
                            <a href="{{ route('informasi-publik.show', $info->slug) }}" target="_blank" class="text-gray-700 hover:text-blue-600 transition truncate pr-4" title="{{ $info->judul }}">
                                {{ Str::limit($info->judul, 50) }}
                            </a>
                            <span class="flex-shrink-0 font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ $info->hits }} views</span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Tidak ada data informasi publik.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</div>