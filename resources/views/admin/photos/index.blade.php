<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4 sm:mb-0">
                Manajemen Foto Album: <span class="font-normal">{{ Str::limit($album->nama, 50) }}</span>
            </h2>
            <a href="{{ route('admin.albums.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar Album
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Foto ({{ $photos->total() }})</h3>
                        <a href="{{ route('admin.albums.photos.create', $album) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            <i class="bi bi-plus-lg mr-2"></i> Tambah Foto Baru
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($photos->isEmpty())
                        <div class="text-center py-16">
                            <i class="bi bi-images text-6xl text-gray-300"></i>
                            <h4 class="mt-4 text-xl font-semibold text-gray-700">Album ini Masih Kosong</h4>
                            <p class="mt-2 text-gray-500">Unggah foto pertama Anda ke dalam album ini.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($photos as $photo)
                            <div class="relative group bg-white rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                <div class="h-48 bg-gray-100">

                                    @if($photo->admin_thumb_url)
                                        <img src="{{ $photo->admin_thumb_url }}" 
                                            class="card-img-top" 
                                            alt="{{ $photo->judul }}" 
                                            style="height: 200px; width: 100%; object-fit: cover;">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-secondary-subtle text-secondary" style="height: 200px;">
                                            <i class="bi bi-image-alt" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif                                  
                                </div>
                                <div class="p-3">
                                    <p class="text-sm font-medium text-gray-800 truncate" title="{{ $photo->judul ?: $photo->file_name }}">
                                        {{ $photo->judul ?: Str::limit($photo->file_name, 30) }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $photo->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $photo->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </div>
                                </div>
                                
                                {{-- OVERLAY DENGAN TOMBOL AKSI (VERSI LEBIH KUAT) --}}
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition-all duration-300"
                                     style="opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;"
                                     x-data="{}" x-init="$el.closest('.group').addEventListener('mouseenter', () => { $el.style.opacity = '1'; $el.style.visibility = 'visible'; }); $el.closest('.group').addEventListener('mouseleave', () => { $el.style.opacity = '0'; $el.style.visibility = 'hidden'; });">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.albums.photos.edit', [$album, $photo]) }}" class="inline-flex items-center justify-center h-10 w-10 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition" title="Edit Foto">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('admin.albums.photos.destroy', [$album, $photo]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center h-10 w-10 bg-red-600 text-white rounded-full hover:bg-red-700 transition" title="Hapus Foto">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $photos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>