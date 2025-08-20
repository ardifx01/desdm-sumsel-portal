<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Album Foto') }}
            </h2>
            <a href="{{ route('admin.albums.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Buat Album Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($albums as $album)
                <div class="bg-white rounded-lg shadow-md overflow-hidden group">
                    <a href="{{ route('admin.albums.photos.index', $album) }}" class="block">
                        <div class="relative h-40 bg-gray-200">
                            {{-- PERBAIKAN DI SINI --}}
                            @if($album->admin_thumb_url)
                                <img src="{{ $album->admin_thumb_url }}" alt="{{ $album->nama }}" style="object-fit: cover;">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="bi bi-images text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded-tr-lg">
                                {{ $album->photos->count() }} Foto
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 truncate">{{ $album->nama }}</h4>
                            <p class="text-sm text-gray-500">{{ $album->is_active ? 'Aktif' : 'Non-Aktif' }}</p>
                        </div>
                    </a>
                    <div class="px-4 pb-3 flex justify-end items-center space-x-2 border-t border-gray-100 pt-3">
                        <a href="{{ route('admin.albums.edit', $album) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit Album">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus album ini beserta semua fotonya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus Album">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500">Belum ada album foto yang dibuat.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $albums->links() }}
            </div>
        </div>
    </div>
</x-app-layout>