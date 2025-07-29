<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Foto Album: ' . Str::limit($album->nama, 50)) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Foto dalam Album "{{ $album->nama }}"</h3>
                        <a href="{{ route('admin.albums.photos.create', $album) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Tambah Foto Baru</a>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse ($photos as $photo)
                        <div class="relative group bg-gray-100 rounded-lg overflow-hidden shadow-md">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->judul ?: $photo->file_name }}" class="w-full h-48 object-cover">
                            <div class="p-3">
                                <h4 class="font-semibold text-sm truncate">{{ $photo->judul ?: Str::limit($photo->file_name, 30) }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($photo->deskripsi, 40) }}</p>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $photo->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $photo->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('admin.albums.photos.edit', [$album, $photo]) }}" class="text-white px-3 py-1 bg-indigo-600 rounded-md hover:bg-indigo-700 mr-2">Edit</a>
                                <form action="{{ route('admin.albums.photos.destroy', [$album, $photo]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white px-3 py-1 bg-red-600 rounded-md hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-5">
                            <p class="text-gray-500">Album ini belum memiliki foto.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $photos->links() }}
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('admin.albums.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Kembali ke Daftar Album</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>