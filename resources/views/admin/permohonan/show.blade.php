<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Permohonan Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Permohonan #{{ $permohonan_informasi->nomor_registrasi }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Diajukan pada: {{ $permohonan_informasi->tanggal_permohonan->isoFormat('dddd, D MMMM YYYY - HH:mm') }}</p>
                        </div>
                        <a href="{{ route('admin.permohonan.index') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kolom Data Pemohon --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-800 border-b pb-2">Data Pemohon</h4>
                            <dl class="grid grid-cols-3 gap-x-4 gap-y-2 text-sm">
                                <dt class="font-medium text-gray-500 col-span-1">Nama</dt>
                                <dd class="text-gray-900 col-span-2">{{ $permohonan_informasi->user->name ?? '[Pengguna Dihapus]' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Email</dt>
                                <dd class="text-gray-900 col-span-2">{{ $permohonan_informasi->user->email ?? 'N/A' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Telepon</dt>
                                <dd class="text-gray-900 col-span-2">{{ $permohonan_informasi->user->telp ?? '-' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Alamat</dt>
                                <dd class="text-gray-900 col-span-2">{{ $permohonan_informasi->user->alamat ?? '-' }}</dd>
                                
                                <dt class="font-medium text-gray-500 col-span-1">Pekerjaan</dt>
                                <dd class="text-gray-900 col-span-2">{{ $permohonan_informasi->pekerjaan_pemohon ?: '-' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Jenis Pemohon</dt>
                                <dd class="text-gray-900 col-span-2">{{ $permohonan_informasi->jenis_pemohon ?: '-' }}</dd>

                                @if($permohonan_informasi->identitas_pemohon)
                                    <dt class="font-medium text-gray-500 col-span-1">Identitas</dt>
                                    <dd class="text-gray-900 col-span-2">
                                        <a href="{{ asset('storage/' . $permohonan_informasi->identitas_pemohon) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat File</a>
                                    </dd>
                                @endif
                            </dl>
                        </div>

                        {{-- Kolom Detail Permohonan --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-800 border-b pb-2">Detail Permohonan</h4>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Rincian Informasi yang Diminta:</p>
                                <div class="mt-1 border rounded p-3 bg-gray-50 text-sm text-gray-800">
                                    <p>{{ $permohonan_informasi->rincian_informasi }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tujuan Penggunaan:</p>
                                <p class="text-sm text-gray-800">{{ $permohonan_informasi->tujuan_penggunaan_informasi ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Cara Memperoleh:</p>
                                <p class="text-sm text-gray-800">{{ $permohonan_informasi->cara_mendapatkan_informasi }}</p>
                            </div>
                            @if($permohonan_informasi->cara_mendapatkan_salinan)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Cara Mendapatkan Salinan:</p>
                                    <p class="text-sm text-gray-800">{{ $permohonan_informasi->cara_mendapatkan_salinan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form Update Status & Catatan --}}
                    <div class="mt-8 pt-6 border-t">
                        <h4 class="font-semibold text-gray-800 mb-4">Tindak Lanjut Admin</h4>
                        <form action="{{ route('admin.permohonan.update', ['permohonan_item' => $permohonan_informasi->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                                <div class="md:col-span-2">
                                    <label for="catatan_admin" class="block text-sm font-medium text-gray-700">Catatan Admin</label>
                                    <textarea name="catatan_admin" id="catatan_admin" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('catatan_admin', $permohonan_informasi->catatan_admin) }}</textarea>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @foreach($statuses as $s)
                                            <option value="{{ $s }}" {{ $permohonan_informasi->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="mt-2 w-full justify-center inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>