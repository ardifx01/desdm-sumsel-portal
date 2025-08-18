{{-- Judul Bagian --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Konten & Aktivitas</h3>

{{-- Grid untuk Kartu Statistik & Aktivitas --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

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
            {{-- KODE DIPERBAIKI: Menggunakan key-value pair dan mencari model kategori --}}
            @forelse(
                $postCategories as $categoryName => $total)
                @php
                    // Cari model Category berdasarkan nama untuk mendapatkan badge_class
                    $category = \App\Models\Category::where('name', $categoryName)->first();
                    // Jika model ditemukan, gunakan badge_class. Jika tidak, gunakan default.
                    $badgeClass = $category ? $category->badge_class : 'px-2 py-1 rounded-full bg-gray-100 text-gray-800 font-semibold';
                @endphp
                <span class="{{ $badgeClass }}">{{ $categoryName }}: {{ $total }}</span>
            @empty
                <span class="text-gray-400">Belum ada kategori.</span>
            @endforelse
        </div>
    </div>

    <!-- Kolom Konten Populer & Komentar (Kolom Gabungan) -->
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Sub-kolom Berita Terpopuler -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg mb-4 flex items-center"><i class="bi bi-graph-up-arrow mr-2"></i>5 Berita Terpopuler</h4>
            <ul class="space-y-3">
                @forelse($popularPosts as $post)
                    <li class="flex items-center justify-between text-sm">
                        <a href="{{ route('berita.show', $post->slug) }}" target="_blank" class="text-gray-700 hover:text-blue-600 transition truncate pr-4" title="{{ $post->title }}">
                            {{ Str::limit($post->title, 40) }}
                        </a>
                        <span class="flex-shrink-0 font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ $post->hits }} views</span>
                    </li>
                @empty
                    <li class="text-sm text-gray-500">Tidak ada data berita.</li>
                @endforelse
            </ul>
        </div>

        <!-- Sub-kolom Komentar Menunggu -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg mb-4">Komentar Menunggu Moderasi</h4>
            <div class="space-y-4">
                @forelse($pendingComments as $comment)
                    <a href="{{ route('admin.comments.show', $comment->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition border-l-4 border-transparent hover:border-yellow-400">
                        <p class="font-semibold text-sm text-gray-800 truncate">"{{ $comment->content }}"</p>
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
</div>