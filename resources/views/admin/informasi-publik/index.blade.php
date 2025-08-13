<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Informasi Publik') }}
            </h2>
            <a href="{{ route('admin.informasi-publik.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Item Baru
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
                        <form action="{{ route('admin.informasi-publik.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-center">
                            <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                            <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                            <select name="is_active" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 text-sm font-semibold">
                                    <i class="bi bi-funnel-fill mr-2"></i> Filter
                                </button>
                                @if(request()->hasAny(['q', 'category_id', 'is_active']))
                                    <a href="{{ route('admin.informasi-publik.index') }}" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-semibold">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Informasi Publik -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Informasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statistik</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($informasiPublik as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($item->thumbnail)
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $item->thumbnail) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                                                        <i class="bi bi-info-square-fill text-2xl text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900" title="{{ $item->judul }}">{{ Str::limit($item->judul, 50) }}</div>
                                                <div class="text-sm text-gray-500">Update: {{ $item->updated_at->isoFormat('D MMM YYYY') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- PERUBAHAN DI SINI: Badge Kategori Berwarna --}}
                                        @if($item->category)
                                            @php
                                                $colors = [
                                                    'bg-blue-100 text-blue-800',
                                                    'bg-green-100 text-green-800',
                                                    'bg-yellow-100 text-yellow-800',
                                                    'bg-red-100 text-red-800',
                                                    'bg-indigo-100 text-indigo-800',
                                                    'bg-purple-100 text-purple-800',
                                                ];
                                                $colorIndex = $item->category->id % count($colors);
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$colorIndex] }}">
                                                {{ $item->category->nama }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Tanpa Kategori
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{-- PERUBAHAN DI SINI: Menambahkan Statistik Hits/Download --}}
                                        <div class="flex items-center" title="Dilihat / Diunduh">
                                            <i class="bi bi-eye-fill mr-1"></i> {{ $item->hits }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        @if($item->file_path)
                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Unduh/Lihat Lampiran">
                                                <i class="bi bi-paperclip text-lg"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.informasi-publik.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.informasi-publik.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
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
                                        Tidak ada item informasi publik yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $informasiPublik->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>