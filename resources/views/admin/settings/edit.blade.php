<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Umum Web') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
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

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Umum Website</h3>
                        <div class="mb-4">
                            <label for="app_name" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                            <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $settings['app_name'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('app_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input untuk Logo --}}
                        <div class="mb-4">
                            <label for="app_logo" class="block text-sm font-medium text-gray-700">Logo Aplikasi</label>
                            @if(isset($settings['app_logo']))
                                <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Logo Aplikasi" class="my-2" style="max-height: 80px;">
                            @endif
                            <input type="file" name="app_logo" id="app_logo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            @error('app_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input untuk Favicon --}}
                        <div class="mb-4">
                            <label for="app_favicon" class="block text-sm font-medium text-gray-700">Favicon Aplikasi</label>
                            @if(isset($settings['app_favicon']))
                                <img src="{{ asset('storage/' . $settings['app_favicon']) }}" alt="Favicon Aplikasi" class="my-2" style="max-height: 32px;">
                            @endif
                            <input type="file" name="app_favicon" id="app_favicon" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            @error('app_favicon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-4">Informasi Kontak</h3>
                        <div class="mb-4">
                            <label for="alamat_kantor" class="block text-sm font-medium text-gray-700">Alamat Kantor</label>
                            <textarea name="alamat_kantor" id="alamat_kantor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3" required>{{ old('alamat_kantor', $settings['alamat_kantor'] ?? '') }}</textarea>
                            @error('alamat_kantor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email_kontak" class="block text-sm font-medium text-gray-700">Email Kontak</label>
                            <input type="email" name="email_kontak" id="email_kontak" value="{{ old('email_kontak', $settings['email_kontak'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('email_kontak') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="telp_kontak" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" name="telp_kontak" id="telp_kontak" value="{{ old('telp_kontak', $settings['telp_kontak'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('telp_kontak') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-4">Tautan Media Sosial</h3>
                        <div class="mb-4">
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                            <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('facebook_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                            <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('twitter_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                            <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('instagram_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="youtube_url" class="block text-sm font-medium text-gray-700">Youtube URL</label>
                            <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('youtube_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>