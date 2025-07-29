<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Permohonan Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Permohonan Informasi Publik</h3>

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

                    {{-- Form Filter dan Pencarian --}}
                    <div class="mb-4">
                        <form action="{{ route('admin.permohonan.index') }}" method="GET" class="flex flex-wrap gap-2 items-end">
                            <div class="flex-1 min-w-[200px]">
                                <label for="q" class="block text-sm font-medium text-gray-700">Cari Pemohon/No. Registrasi</label>
                                <input type="text" name="q" id="q" placeholder="Nama atau No. Registrasi..." value="{{ request('q') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div class="flex-1 min-w-[150px]">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Semua Status</option>
                                    @foreach($statuses as $s)
                                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1 min-w-[150px]">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div class="flex-1 min-w-[150px]">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Grupkan tombol agar sejajar dengan input lainnya --}}
                            <div class="flex-shrink-0 flex items-end gap-2"> {{-- TAMBAHKAN flex items-end gap-2 --}}
                                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Filter</button>
                                @if(request('q') || request('status') || request('start_date') || request('end_date'))
                                    <a href="{{ route('admin.permohonan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Tabel Daftar Permohonan --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Reg</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rincian Informasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Permohonan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($permohonan as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->nomor_registrasi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->nama_pemohon }} ({{ $item->email_pemohon }})
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ Str::limit($item->rincian_informasi, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggal_permohonan->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ ['Menunggu Diproses' => 'bg-yellow-100 text-yellow-800', 'Diproses' => 'bg-blue-100 text-blue-800', 'Diterima' => 'bg-green-100 text-green-800', 'Ditolak' => 'bg-red-100 text-red-800', 'Selesai' => 'bg-gray-100 text-gray-800'][$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.permohonan.show', $item) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Detail</a>
                                        <form action="{{ route('admin.permohonan.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada permohonan informasi yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $permohonan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>