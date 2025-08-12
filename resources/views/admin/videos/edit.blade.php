<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Video: ') }} <span class="font-normal">{{ Str::limit($video->judul, 50) }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                            <p class="font-bold">Terjadi Kesalahan</p>
                            <ul class="list-disc list-inside mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.videos.update', $video) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Video</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul', $video->judul) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="video_url" class="block text-sm font-medium text-gray-700">URL Video (YouTube)</label>
                                <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Masukkan URL YouTube yang baru di sini">
                                <p class="mt-1 text-xs text-gray-500">Kode embed saat ini:</p>
                                <div class="p-2 bg-gray-100 rounded text-xs text-gray-600 font-mono">{{ $video->embed_code }}</div>
                            </div>

                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Video (Opsional)</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                            </div>

                            <div>
                                <label class="inline-flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 text-gray-600 rounded" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Aktif (Tampilkan di Publik)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-sm font-semibold mr-2">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">Update Video</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>