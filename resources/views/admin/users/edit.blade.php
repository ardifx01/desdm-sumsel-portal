<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Informasi Profil') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Perbarui informasi profil dan peran pengguna ini.") }}
                            </p>
                        </header>
                        
                        <form method="POST" action="{{ route('admin.users.updateProfile', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')
                        

                            <div>
                                <x-input-label for="name" :value="__('Nama')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
    
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            
                            <div>
                                <x-input-label for="role" :value="__('Peran')" />
                                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach(['super_admin', 'ppid_admin', 'editor', 'moderator', 'user'] as $role)
                                        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Perbarui Kata Sandi') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Pastikan pengguna menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
                            </p>
                        </header>
                        
                        <form method="POST" action="{{ route('admin.users.updatePassword', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
    
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Kata Sandi') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>