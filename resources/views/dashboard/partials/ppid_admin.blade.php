{{-- Judul Bagian --}}
<h3 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Statistik PPID</h3>

{{-- Grid untuk Kartu Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
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
        <p class="text-xs text-gray-500 mt-2">Ditolak: <span class="font-semibold">{{ $permohonanStatus['Ditolak'] ?? 0 }}</span></p>
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
        <p class="text-xs text-gray-500 mt-2">Ditolak: <span class="font-semibold">{{ $keberatanStatus['Ditolak'] ?? 0 }}</span></p>
    </div>

    <!-- Kartu Total Informasi Publik -->
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
                            <p class="font-semibold text-sm text-gray-800">{{ $permohonan->nama_pemohon }}</p>
                            <p class="text-xs text-gray-500 mt-1">No. Reg: {{ $permohonan->no_register }}</p>
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
                            <p class="font-semibold text-sm text-gray-800">{{ $keberatan->nama_pemohon }}</p>
                            <p class="text-xs text-gray-500 mt-1">No. Reg: {{ $keberatan->no_register }}</p>
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