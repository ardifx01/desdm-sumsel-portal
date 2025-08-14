{{-- Judul Bagian --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Statistik PPID</h3>

{{-- Grid untuk Kartu Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Kartu Total Informasi Publik (DENGAN STATISTIK DETAIL) -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-cyan-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Informasi Publik</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalInformasiPublik ?? 0 }}</p>
            </div>
            <div class="bg-cyan-100 p-3 rounded-full">
                <i class="bi bi-info-circle-fill text-2xl text-cyan-600"></i>
            </div>
        </div>
        {{-- STATISTIK KATEGORI BARU --}}
        <div class="mt-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-xs">
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

{{-- Grid untuk Aktivitas Terkini --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Aktivitas Terkini</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    <!-- Kolom Permohonan Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Permohonan Informasi Terbaru</h4>
        <div class="space-y-4">
            @forelse($recentPermohonan as $permohonan)
                <a href="{{ route('admin.permohonan.show', $permohonan->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-sm text-gray-800">{{ $permohonan->user->name ?? '[N/A]' }}</p>
                            <p class="text-xs text-gray-500 mt-1">No. Reg: {{ $permohonan->nomor_registrasi }}</p>
                        </div>
                        <span class="text-xs text-gray-400 flex-shrink-0">{{ $permohonan->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-check2-circle text-3xl text-gray-300"></i>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada permohonan baru.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Kolom Keberatan Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h4 class="font-bold text-lg mb-4">Pengajuan Keberatan Terbaru</h4>
        <div class="space-y-4">
            @forelse($recentKeberatan as $keberatan)
                <a href="{{ route('admin.keberatan.show', $keberatan->id) }}" class="block p-3 rounded-md hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-sm text-gray-800">{{ $keberatan->user->name ?? '[N/A]' }}</p>
                            <p class="text-xs text-gray-500 mt-1">No. Reg Permohonan: {{ $keberatan->nomor_registrasi_permohonan }}</p>
                        </div>
                        <span class="text-xs text-gray-400 flex-shrink-0">{{ $keberatan->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-check2-circle text-3xl text-gray-300"></i>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada keberatan baru.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>