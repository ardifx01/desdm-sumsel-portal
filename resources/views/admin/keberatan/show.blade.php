<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Keberatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Keberatan untuk Permohonan #{{ $pengajuan_keberatan->nomor_registrasi_permohonan }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Diajukan pada: {{ $pengajuan_keberatan->tanggal_pengajuan->isoFormat('dddd, D MMMM YYYY - HH:mm') }}</p>
                        </div>
                        <a href="{{ route('admin.keberatan.index') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
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
                                <dd class="text-gray-900 col-span-2">{{ $pengajuan_keberatan->user->name ?? '[Pengguna Dihapus]' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Email</dt>
                                <dd class="text-gray-900 col-span-2">{{ $pengajuan_keberatan->user->email ?? 'N/A' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Telepon</dt>
                                <dd class="text-gray-900 col-span-2">{{ $pengajuan_keberatan->user->telp ?? '-' }}</dd>

                                <dt class="font-medium text-gray-500 col-span-1">Alamat</dt>
                                <dd class="text-gray-900 col-span-2">{{ $pengajuan_keberatan->user->alamat ?? '-' }}</dd>
                            </dl>
                        </div>

                        {{-- Kolom Detail Keberatan --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-800 border-b pb-2">Detail Keberatan</h4>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Jenis Keberatan:</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $pengajuan_keberatan->jenis_keberatan }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Alasan Pengajuan:</p>
                                <div class="mt-1 border rounded p-3 bg-gray-50 text-sm text-gray-800">
                                    <p>{{ $pengajuan_keberatan->alasan_keberatan }}</p>
                                </div>
                            </div>
                            @if($pengajuan_keberatan->kasus_posisi)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Kasus Posisi:</p>
                                    <div class="mt-1 border rounded p-3 bg-gray-50 text-sm text-gray-800">
                                        <p>{{ $pengajuan_keberatan->kasus_posisi }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form Update Status & Catatan --}}
                    <div class="mt-8 pt-6 border-t">
                        <h4 class="font-semibold text-gray-800 mb-4">Tindak Lanjut Admin</h4>
                        <form action="{{ route('admin.keberatan.update', ['keberatan_item' => $pengajuan_keberatan->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                                <div class="md:col-span-2">
                                    <label for="catatan_admin" class="block text-sm font-medium text-gray-700">Catatan Admin</label>
                                    <textarea name="catatan_admin" id="catatan_admin" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('catatan_admin', $pengajuan_keberatan->catatan_admin) }}</textarea>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @foreach($statuses as $s)
                                            <option value="{{ $s }}" {{ $pengajuan_keberatan->status == $s ? 'selected' : '' }}>{{ $s }}</option>
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