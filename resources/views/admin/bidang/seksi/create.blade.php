<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Seksi Baru untuk ') . $bidang->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.bidang.seksi.index', $bidang->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; {{ __('Kembali ke Daftar Seksi') }}
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.bidang.seksi.store', $bidang->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="nama_seksi" :value="__('Nama Seksi')" />
                            <x-text-input id="nama_seksi" class="block mt-1 w-full" type="text" name="nama_seksi" :value="old('nama_seksi')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_seksi')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tugas" :value="__('Tugas Seksi')" />
                            <textarea name="tugas" id="tugas" class="tinymce-editor block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('tugas') }}</textarea>
                            <x-input-error :messages="$errors->get('tugas')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Isi tugas seksi di sini.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pejabat_kepala_id" :value="__('Kepala Seksi')" />
                            <select name="pejabat_kepala_id" id="pejabat_kepala_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Pejabat --</option>
                                @foreach ($pejabats as $pejabat)
                                    <option value="{{ $pejabat->id }}" {{ old('pejabat_kepala_id') == $pejabat->id ? 'selected' : '' }}>{{ $pejabat->nama }} ({{ $pejabat->jabatan }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('pejabat_kepala_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="urutan" :value="__('Urutan Tampilan')" />
                            <x-text-input id="urutan" class="block mt-1 w-full" type="number" name="urutan" :value="old('urutan', 0)" />
                            <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.bidang.seksi.index', $bidang->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Seksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>