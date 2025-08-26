<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna: ') }} <span class="font-bold">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Notifikasi Sukses Global --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Kartu untuk Update Profil dan Peran --}}
            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Informasi Profil & Peran') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Perbarui informasi profil dan tetapkan peran untuk pengguna ini.") }}
                            </p>
                        </header>
                        
                        {{-- Form Gabungan untuk Profil dan Peran --}}
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')
                        
                            {{-- Input Nama --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
    
                            {{-- Input Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            
                            {{-- Dropdown Peran (Role) --}}
                            <div>
                                <x-input-label for="role" :value="__('Peran')" />
                                <select name="role" id="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach(['super_admin', 'ppid_admin', 'editor', 'user'] as $roleValue)
                                        <option value="{{ $roleValue }}" {{ old('role', $user->role) === $roleValue ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $roleValue)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>
    
                            {{-- Tombol Aksi --}}
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Perubahan Profil') }}</x-primary-button>
                                
                                {{-- TOMBOL KEMBALI DITAMBAHKAN DI SINI --}}
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- Kartu untuk Update Kata Sandi --}}
            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Perbarui Kata Sandi') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Pastikan pengguna menggunakan kata sandi yang panjang dan acak agar tetap aman. Biarkan kosong jika tidak ingin mengubahnya.') }}
                            </p>
                        </header>
                        
                        {{-- Form Terpisah untuk Kata Sandi --}}
                        <form method="POST" action="{{ route('admin.users.updatePassword', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            {{-- Input Kata Sandi Baru --}}
                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi Baru (Opsional)')" />
                                <x-password-input id="password" name="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
    
                            {{-- Input Konfirmasi Kata Sandi --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                <x-password-input id="password_confirmation" name="password_confirmation" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
    
                            {{-- Tombol Aksi --}}
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Kata Sandi') }}</x-primary-button>

                                {{-- TOMBOL KEMBALI DITAMBAHKAN DI SINI --}}
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>