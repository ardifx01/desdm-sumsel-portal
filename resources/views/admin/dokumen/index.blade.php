<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Dokumen') }}
            </h2>
            <a href="{{ route('admin.dokumen.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Unggah Dokumen
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Form Filter -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border">
                        <form action="{{ route('admin.dokumen.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-center">
                            <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                            <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                            <select name="status_aktif" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status_aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status_aktif') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 text-sm font-semibold">
                                    <i class="bi bi-funnel-fill mr-2"></i> Filter
                                </button>
                                @if(request()->hasAny(['q', 'category_id', 'status_aktif']))
                                    <a href="{{ route('admin.dokumen.index') }}" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-semibold">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Dokumen -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Dokumen</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info & Statistik</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($dokumen as $doc)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg
                                                @if(Str::contains($doc->file_tipe, 'pdf')) bg-red-100 text-red-600
                                                @elseif(Str::contains($doc->file_tipe, ['word', 'doc'])) bg-blue-100 text-blue-600
                                                @elseif(Str::contains($doc->file_tipe, ['excel', 'xls'])) bg-green-100 text-green-600
                                                @elseif(Str::contains($doc->file_tipe, ['powerpoint', 'ppt'])) bg-orange-100 text-orange-600
                                                @else bg-gray-100 text-gray-600 @endif">
                                                <i class="bi 
                                                    @if(Str::contains($doc->file_tipe, 'pdf')) bi-file-earmark-pdf-fill
                                                    @elseif(Str::contains($doc->file_tipe, ['word', 'doc'])) bi-file-earmark-word-fill
                                                    @elseif(Str::contains($doc->file_tipe, ['excel', 'xls'])) bi-file-earmark-excel-fill
                                                    @elseif(Str::contains($doc->file_tipe, ['powerpoint', 'ppt'])) bi-file-earmark-ppt-fill
                                                    @else bi-file-earmark-fill @endif text-2xl"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900" title="{{ $doc->judul }}">{{ Str::limit($doc->judul, 50) }}</div>
                                                <div class="text-sm text-gray-500">Publikasi: {{ $doc->tanggal_publikasi ? $doc->tanggal_publikasi->isoFormat('D MMM YYYY') : '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- LOGIKA BADGE KATEGORI BERWARNA DIKEMBALIKAN DI SINI --}}
                                        @if($doc->category)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doc->category->badge_class }}">
                                                {{ $doc->category->nama }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Tanpa Kategori
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center" title="Ukuran File">
                                            <i class="bi bi-file-earmark-binary-fill mr-2"></i>
                                            @if($doc->file_path && Storage::disk('public')->exists($doc->file_path))
                                                {{ number_format(Storage::disk('public')->size($doc->file_path) / 1024, 1) }} KB
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                        <div class="flex items-center mt-1" title="Jumlah Unduhan">
                                            <i class="bi bi-cloud-arrow-down-fill mr-2"></i>
                                            {{ $doc->hits }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doc->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $doc->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Unduh/Lihat File">
                                            <i class="bi bi-download text-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.dokumen.edit', $doc) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.dokumen.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="bi bi-trash3-fill text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada dokumen yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $dokumen->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>