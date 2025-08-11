<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Umum Web') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Container Utama dengan Alpine.js untuk state management tab --}}
            <div x-data="{ tab: 'umum' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="sm:flex">
                    {{-- Navigasi Tab di Sisi Kiri --}}
                    <div class="w-full sm:w-1/4 border-b sm:border-b-0 sm:border-r border-gray-200 p-4">
                        <nav class="space-y-1">
                            <a @click.prevent="tab = 'umum'" href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                               :class="{'bg-gray-200 text-gray-900': tab === 'umum', 'text-gray-600 hover:bg-gray-100': tab !== 'umum'}">
                                <i class="bi bi-gear-fill mr-3"></i>
                                Informasi Umum
                            </a>
                            <a @click.prevent="tab = 'kontak'" href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                               :class="{'bg-gray-200 text-gray-900': tab === 'kontak', 'text-gray-600 hover:bg-gray-100': tab !== 'kontak'}">
                                <i class="bi bi-person-rolodex mr-3"></i>
                                Informasi Kontak
                            </a>
                            <a @click.prevent="tab = 'medsos'" href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                               :class="{'bg-gray-200 text-gray-900': tab === 'medsos', 'text-gray-600 hover:bg-gray-100': tab !== 'medsos'}">
                                <i class="bi bi-share-fill mr-3"></i>
                                Media Sosial
                            </a>
                        </nav>
                    </div>

                    {{-- Konten Form di Sisi Kanan --}}
                    <div class="w-full sm:w-3/4 p-6">
                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            {{-- KONTEN TAB 1: INFORMASI UMUM --}}
                            <div x-show="tab === 'umum'" class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Informasi Umum & Branding</h3>
                                
                                <div>
                                    <label for="app_name" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                                    <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $settings['app_name'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label for="app_logo" class="block text-sm font-medium text-gray-700">Logo Aplikasi (Rekomendasi: .png transparan)</label>
                                    @if(isset($settings['app_logo']))
                                        <div class="mt-2 p-2 border rounded-md inline-block bg-gray-50">
                                            <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Logo Aplikasi" style="max-height: 60px;">
                                        </div>
                                    @endif
                                    <input type="file" name="app_logo" id="app_logo" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah logo.</p>
                                </div>

                                <div>
                                    <label for="app_favicon" class="block text-sm font-medium text-gray-700">Favicon (Rekomendasi: .ico atau .png 32x32)</label>
                                    @if(isset($settings['app_favicon']))
                                        <div class="mt-2 p-1 border rounded-md inline-block bg-gray-50">
                                            <img src="{{ asset('storage/' . $settings['app_favicon']) }}" alt="Favicon Aplikasi" style="max-height: 32px;">
                                        </div>
                                    @endif
                                    <input type="file" name="app_favicon" id="app_favicon" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah favicon.</p>
                                </div>
                            </div>

                            {{-- KONTEN TAB 2: INFORMASI KONTAK --}}
                            <div x-show="tab === 'kontak'" class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Informasi Kontak</h3>
                                
                                <div>
                                    <label for="alamat_kantor" class="block text-sm font-medium text-gray-700">Alamat Kantor</label>
                                    <textarea name="alamat_kantor" id="alamat_kantor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" required>{{ old('alamat_kantor', $settings['alamat_kantor'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label for="email_kontak" class="block text-sm font-medium text-gray-700">Email Kontak</label>
                                    <input type="email" name="email_kontak" id="email_kontak" value="{{ old('email_kontak', $settings['email_kontak'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label for="telp_kontak" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" name="telp_kontak" id="telp_kontak" value="{{ old('telp_kontak', $settings['telp_kontak'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            {{-- KONTEN TAB 3: MEDIA SOSIAL --}}
                            <div x-show="tab === 'medsos'" class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Tautan Media Sosial</h3>
                                
                                <div>
                                    <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                                    <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://facebook.com/username">
                                </div>
                                <div>
                                    <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                                    <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://twitter.com/username">
                                </div>
                                <div>
                                    <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                                    <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://instagram.com/username">
                                </div>
                                <div>
                                    <label for="youtube_url" class="block text-sm font-medium text-gray-700">Youtube URL</label>
                                    <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://youtube.com/channel/...">
                                </div>
                            </div>

                            {{-- Tombol Aksi (selalu terlihat) --}}
                            <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 gap-4">
                                {{-- TOMBOL KEMBALI DITAMBAHKAN DI SINI --}}
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Kembali ke Dashboard') }}
                                </a>

                                <x-primary-button>
                                    {{ __('Simpan Semua Pengaturan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>