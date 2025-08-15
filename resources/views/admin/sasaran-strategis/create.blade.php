<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sasaran Strategis Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <form action="{{ route('admin.sasaran-strategis.store') }}" method="POST">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                                <p class="font-bold">Terjadi Kesalahan</p>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="sasaran" :value="__('Nama Sasaran Strategis')" />
                                <textarea id="sasaran" name="sasaran" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>{{ old('sasaran') }}</textarea>
                                <x-input-error :messages="$errors->get('sasaran')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="urutan" :value="__('Nomor Urutan')" />
                                <x-text-input id="urutan" name="urutan" type="number" class="mt-1 block w-full" :value="old('urutan', 0)" required />
                                <p class="mt-1 text-xs text-gray-500">Angka ini akan digunakan untuk mengurutkan tampilan sasaran.</p>
                                <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.sasaran-strategis.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Sasaran') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>