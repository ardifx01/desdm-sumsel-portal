<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unggah Foto ke Album: ') }} <span class="font-bold">{{ $album->nama }}</span>
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

                    {{-- Kita akan menggunakan satu form untuk semua unggahan --}}
                    <form action="{{ route('admin.albums.photos.store', $album) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Komponen Multi-Upload dengan Alpine.js --}}
                        <div x-data="fileUploadComponent()">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih atau Seret File Foto (Bisa lebih dari satu)</label>
                            <div 
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-indigo-500 transition"
                                @dragover.prevent="dragging = true"
                                @dragleave.prevent="dragging = false"
                                @drop.prevent="dropFiles($event)"
                                :class="{ 'border-indigo-500 bg-indigo-50': dragging }"
                                @click="$refs.fileInput.click()">
                                
                                <input type="file" name="photos[]" x-ref="fileInput" @change="addFiles($event.target.files)" multiple class="hidden" accept="image/*">
                                
                                <i class="bi bi-cloud-arrow-up-fill text-4xl text-gray-400"></i>
                                <p class="mt-2 text-sm text-gray-600">Seret & lepas file di sini, atau klik untuk memilih file.</p>
                                <p class="text-xs text-gray-500">Maksimal 2MB per file (JPG, PNG, GIF, SVG)</p>
                            </div>

                            {{-- Daftar Pratinjau File --}}
                            <div x-show="files.length > 0" class="mt-4 space-y-2">
                                <template x-for="(file, index) in files" :key="index">
                                    <div class="flex items-center p-2 bg-gray-50 rounded-lg border">
                                        <img :src="file.preview" class="w-16 h-16 rounded-md object-cover mr-4">
                                        <div class="flex-grow">
                                            <p class="text-sm font-medium text-gray-800" x-text="file.name"></p>
                                            <p class="text-xs text-gray-500" x-text="`${(file.size / 1024).toFixed(1)} KB`"></p>
                                        </div>
                                        <button @click.prevent="removeFile(index)" class="text-red-500 hover:text-red-700">&times;</button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t">
                            <label class="inline-flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 text-gray-600" checked>
                                <span class="ml-2 text-sm text-gray-600">Aktifkan semua foto setelah diunggah</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('admin.albums.photos.index', $album) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-sm font-semibold">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">
                                <i class="bi bi-upload mr-2"></i> Unggah Foto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>