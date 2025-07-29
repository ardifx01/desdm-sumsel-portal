<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Dokumen Publikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Dokumen Resmi</h3>
                        <a href="{{ route('admin.dokumen.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Tambah Dokumen Baru</a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <form action="{{ route('admin.dokumen.index') }}" method="GET" class="flex space-x-2">
                            <input type="text" name="q" placeholder="Cari judul dokumen..." value="{{ request('q') }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <select name="category_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Semua Kategori</option> {{-- PASTIKAN VALUE INI KOSONG STRING --}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                            <select name="status_aktif" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Semua Status</option> {{-- PASTIKAN VALUE INI KOSONG STRING --}}
                                <option value="1" {{ request('status_aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status_aktif') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Filter</button>
                            @if(request('q') || request('category_id') || request('status_aktif') !== null)
                                <a href="{{ route('admin.dokumen.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Dokumen</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Publikasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($dokumen as $doc)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ Str::limit($doc->judul, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $doc->category->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $doc->tanggal_publikasi ? $doc->tanggal_publikasi->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doc->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $doc->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 mr-3">Lihat File</a> {{-- TAMBAHKAN 'storage/' --}}
                                        <a href="{{ route('admin.dokumen.edit', $doc) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('admin.dokumen.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? File fisik juga akan dihapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada dokumen yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $dokumen->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>