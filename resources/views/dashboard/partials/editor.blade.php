{{-- Judul Bagian --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Konten</h3>

{{-- Grid untuk Kartu Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
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

    <!-- Kartu Total Album -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-pink-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Album</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalAlbums ?? 0 }}</p>
            </div>
            <div class="bg-pink-100 p-3 rounded-full">
                <i class="bi bi-images text-2xl text-pink-600"></i>
            </div>
        </div>
    </div>
</div>

<hr class="my-8 border-gray-200">

{{-- Grid untuk Konten Populer & Aktivitas --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Konten Populer & Aktivitas</h3>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Kolom Konten Populer (Gabungan) -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Konten Terpopuler</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h5 class="font-semibold mb-3 flex items-center"><i class="bi bi-newspaper mr-2"></i>Berita</h5>
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
                <h5 class="font-semibold mb-3 flex items-center"><i class="bi bi-file-earmark-text-fill mr-2"></i>Dokumen</h5>
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

    <!-- Kolom Komentar Menunggu -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Komentar Menunggu Moderasi</h4>
        <div class="space-y-4">
            @forelse($pendingComments as $comment)
                <a href="{{ route('admin.comments.show', $comment->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition">
                    <p class="font-semibold text-sm text-gray-800 truncate">{{ $comment->content }}</p>
                    <p class="text-xs text-gray-500 mt-1">di post: "{{ Str::limit($comment->post->title, 35) }}"</p>
                </a>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-check2-circle text-3xl text-gray-300"></i>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada komentar yang menunggu.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>