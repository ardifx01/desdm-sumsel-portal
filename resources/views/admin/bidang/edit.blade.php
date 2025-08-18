<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bidang, UPTD, atau Cabang Dinas: ') . $bidang->nama }}
        </h2>
    </x-slot>

    {{-- SELURUH KONTEN UTAMA HALAMAN HARUS BERADA DI SINI --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.bidang.update', $bidang->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Gunakan metode PUT untuk update --}}

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

                        <div class="mb-4">
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $bidang->nama)" required autofocus />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tipe" :value="__('Tipe')" />
                            <select name="tipe" id="tipe" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="bidang" {{ old('tipe', $bidang->tipe) == 'bidang' ? 'selected' : '' }}>Bidang</option>
                                <option value="UPTD" {{ old('tipe', $bidang->tipe) == 'UPTD' ? 'selected' : '' }}>UPTD</option>
                                <option value="cabang_dinas" {{ old('tipe', $bidang->tipe) == 'cabang_dinas' ? 'selected' : '' }}>Cabang Dinas</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tupoksi" :value="__('Tugas Pokok & Fungsi (Tupoksi)')" />
                            <textarea name="tupoksi" id="tupoksi" class="tinymce-editor block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('tupoksi', $bidang->tupoksi) }}</textarea>
                            <x-input-error :messages="$errors->get('tupoksi')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Isi konten Tupoksi di sini.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pejabat_kepala_id" :value="__('Kepala Bidang/UPTD/Cabang Dinas')" />
                            <select name="pejabat_kepala_id" id="pejabat_kepala_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Pejabat --</option>
                                @foreach ($pejabats as $pejabat)
                                    <option value="{{ $pejabat->id }}" {{ old('pejabat_kepala_id', $bidang->pejabat_kepala_id) == $pejabat->id ? 'selected' : '' }}>{{ $pejabat->nama }} ({{ $pejabat->jabatan }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('pejabat_kepala_id')" class="mt-2" />
                        </div>

                        <div class="mb-4" id="wilayah_kerja_field">
                            <x-input-label for="wilayah_kerja" :value="__('Wilayah Kerja')" />
                            <x-text-input id="wilayah_kerja" class="block mt-1 w-full" type="text" name="wilayah_kerja" :value="old('wilayah_kerja', $bidang->wilayah_kerja)" />
                            <x-input-error :messages="$errors->get('wilayah_kerja')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Hanya untuk Cabang Dinas.</p>
                        </div>

                        <div class="mb-4" id="alamat_field">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea name="alamat" id="alamat" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $bidang->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Hanya untuk Cabang Dinas atau UPTD.</p>
                        </div>

                        <div class="mb-4" id="map_field">
                            <x-input-label for="map" :value="__('Embed Code Peta')" />
                            <textarea name="map" id="map" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('map', $bidang->map) }}</textarea>
                            <x-input-error :messages="$errors->get('map')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Hanya untuk Cabang Dinas atau UPTD. Tempelkan kode embed dari Google Maps.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="grafik_kinerja" :value="__('Embed Code Grafik Kinerja (Opsional)')" />
                            <textarea name="grafik_kinerja" id="grafik_kinerja" class="tinymce-editor block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('grafik_kinerja', $bidang->grafik_kinerja) }}</textarea>
                            <x-input-error :messages="$errors->get('grafik_kinerja')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Tempelkan kode embed grafik dari sumber eksternal.</p>
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', $bidang->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.bidang.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Perbarui Bidang') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>