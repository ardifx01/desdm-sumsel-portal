<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Permohonan Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Permohonan #{{ $permohonan_informasi->nomor_registrasi }}</h3>
                        <div>
                            {{-- Form untuk Update Status --}}
                            <form action="{{ route('admin.permohonan.update', ['permohonan_item' => $permohonan_informasi->id]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <label for="status" class="sr-only">Ubah Status</label>
                                <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($statuses as $s)
                                        <option value="{{ $s }}" {{ $permohonan_informasi->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="ml-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Update Status</button>
                            </form>
                        </div>
                    </div>

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

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700">Data Pemohon:</h4>
                        <p><strong>Nama:</strong> {{ $permohonan_informasi->nama_pemohon }}</p>
                        <p><strong>Email:</strong> {{ $permohonan_informasi->email_pemohon }}</p>
                        <p><strong>Telepon:</strong> {{ $permohonan_informasi->telp_pemohon ?: '-' }}</p>
                        <p><strong>Alamat:</strong> {{ $permohonan_informasi->alamat_pemohon }}</p>
                        <p><strong>Pekerjaan:</strong> {{ $permohonan_informasi->pekerjaan_pemohon ?: '-' }}</p>
                        <p><strong>Jenis Pemohon:</strong> {{ $permohonan_informasi->jenis_pemohon ?: '-' }}</p>
                        @if($permohonan_informasi->identitas_pemohon)
                            <p><strong>Identitas:</strong> <a href="{{ asset('storage/' . $permohonan_informasi->identitas_pemohon) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat File Identitas</a></p>
                        @endif
                        <p><strong>Tanggal Permohonan:</strong> {{ $permohonan_informasi->tanggal_permohonan->format('d M Y H:i') }}</p>
                        <p><strong>Status:</strong> <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ ['Menunggu Diproses' => 'bg-yellow-100 text-yellow-800', 'Diproses' => 'bg-blue-100 text-blue-800', 'Diterima' => 'bg-green-100 text-green-800', 'Ditolak' => 'bg-red-100 text-red-800', 'Selesai' => 'bg-gray-100 text-gray-800'][$permohonan_informasi->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $permohonan_informasi->status }}
                        </span></p>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700">Detail Permohonan:</h4>
                        <p><strong>Rincian Informasi:</strong></p>
                        <div class="border rounded p-3 bg-gray-50">
                            <p>{{ $permohonan_informasi->rincian_informasi }}</p>
                        </div>
                        <p class="mt-2"><strong>Tujuan Penggunaan:</strong> {{ $permohonan_informasi->tujuan_penggunaan_informasi ?: '-' }}</p>
                        <p><strong>Cara Memperoleh:</strong> {{ $permohonan_informasi->cara_mendapatkan_informasi }}</p>
                        @if($permohonan_informasi->cara_mendapatkan_salinan)
                            <p><strong>Cara Salinan:</strong> {{ $permohonan_informasi->cara_mendapatkan_salinan }}</p>
                        @endif
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-700">Catatan Admin:</h4>
                        <form action="{{ route('admin.permohonan.update', ['permohonan_item' => $permohonan_informasi->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $permohonan_informasi->status }}"> {{-- Pastikan status dikirim --}}
                            <textarea name="catatan_admin" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('catatan_admin', $permohonan_informasi->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Catatan</button>
                        </form>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('admin.permohonan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Kembali ke Daftar Permohonan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>