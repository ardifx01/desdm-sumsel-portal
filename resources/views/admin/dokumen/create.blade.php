<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Dokumen Baru') }}
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

                    <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Dokumen</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Dokumen (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="file_dokumen" class="block text-sm font-medium text-gray-700">Upload File Dokumen <small>(PDF, DOCX, XLSX, PPTX, Max 5MB)</small></label>
                            <input type="file" name="file_dokumen" id="file_dokumen" 
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                accept="application/pdf,application/msword,.doc,.docx,application/vnd.ms-excel,.xls,.xlsx,application/vnd.ms-powerpoint,.ppt,.pptx" {{-- TAMBAHKAN ATRIBUT INI --}}
                                required>
                            @error('file_dokumen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_publikasi" class="block text-sm font-medium text-gray-700">Tanggal Publikasi (Opsional)</label>
                            <input type="date" name="tanggal_publikasi" id="tanggal_publikasi" value="{{ old('tanggal_publikasi') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                {{-- Hidden input untuk memastikan nilai 0 terkirim jika checkbox tidak dicentang --}}
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="form-checkbox h-5 w-5 text-gray-600" checked> {{-- Default checked untuk tambah baru --}}
                                <span class="ml-2 text-gray-700">Aktif (Tampilkan di Publik)</span>
                            </label>
                            @error('is_active')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.dokumen.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Dokumen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>