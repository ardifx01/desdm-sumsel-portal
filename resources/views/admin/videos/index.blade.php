<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Video') }}
            </h2>
            <a href="{{ route('admin.videos.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Video Baru
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
                @forelse ($videos as $video)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    {{-- STRUKTUR PALING SEDERHANA TANPA OVERLAY --}}
                    <div class="h-40 bg-gray-200">
                        @if($video->thumbnail)
                            <img src="{{ $video->thumbnail }}" alt="{{ $video->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="bi bi-camera-video-off-fill text-5xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 flex-grow">
                        <h4 class="font-bold text-gray-800 truncate h-12" title="{{ $video->judul }}">{{ $video->judul }}</h4>
                    </div>
                    <div class="px-4 pb-3 flex justify-between items-center border-t border-gray-100 pt-3">
                        <div>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $video->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $video->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            {{-- IKON PLAY DITAMBAHKAN DI SINI --}}
                            <i class="bi bi-play-circle-fill text-gray-400 text-lg" title="Video"></i>
                            <a href="{{ route('admin.videos.edit', $video) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit Video">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </a>
                            <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus Video">
                                    <i class="bi bi-trash3-fill text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500">Belum ada video yang ditambahkan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>