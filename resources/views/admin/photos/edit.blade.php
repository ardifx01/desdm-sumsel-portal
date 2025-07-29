<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Foto: ' . Str::limit($photo->judul ?: $photo->file_name, 50)) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.albums.photos.update', [$album, $photo]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Penting untuk metode PUT/PATCH --}}
                        <div class="mb-4">
                            <label for="file_photo" class="block text-sm font-medium text-gray-700">Ganti File Foto <small>(Opsional, JPG, PNG, GIF, SVG, Max 2MB, kosongkan jika tidak mengubah)</small></label>
                            <input type="file" name="file_photo" id="file_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/jpeg,image/png,image/gif,image/svg+xml">
                            @error('file_photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if($photo->file_path)
                                <p class="text-xs text-gray-500 mt-2">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $photo->file_path) }}" alt="Current Photo" class="w-32 h-32 rounded-md object-cover">
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Foto (Opsional)</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $photo->judul) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Foto (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('deskripsi', $photo->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 text-gray-600" {{ old('is_active', $photo->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Aktif (Tampilkan di Publik)</span>
                            </label>
                            @error('is_active')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.albums.photos.index', $album) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>