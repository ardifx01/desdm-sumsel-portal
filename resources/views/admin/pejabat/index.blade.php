<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Pejabat Dinas') }}
            </h2>
            <a href="{{ route('admin.pejabat.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Pejabat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pejabat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pejabat as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @php
                                                    // --- LOGIKA BARU UNTUK INISIAL NAMA ---
                                                    // 1. Hapus gelar depan dan belakang
                                                    $cleanName = preg_replace('/^(Drs\.|Dr\.|Ir\.|H\.|Hj\.)\s*/', '', $item->nama);
                                                    $cleanName = preg_replace('/,\s*(S\.T|M\.Si|S\.STP|M\.Eng|ST|MM|AP|M\.Sc)\.?$/i', '', $cleanName);
                                                    $cleanName = trim($cleanName);

                                                    // 2. Pecah nama menjadi beberapa kata
                                                    $words = explode(' ', $cleanName);
                                                    $initials = '';

                                                    if (count($words) >= 2) {
                                                        // Ambil huruf pertama dari kata pertama dan terakhir
                                                        $initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
                                                    } elseif (!empty($words[0])) {
                                                        // Ambil dua huruf pertama jika hanya satu kata
                                                        $initials = strtoupper(substr($words[0], 0, 2));
                                                    } else {
                                                        $initials = 'NA'; // Fallback jika nama kosong setelah dibersihkan
                                                    }
                                                    
                                                    // URL Avatar default sebagai fallback
                                                    $defaultAvatar = 'https://ui-avatars.com/api/?name='.urlencode($initials).'&color=7F9CF5&background=EBF4FF&length=' . strlen($initials);
                                                @endphp
                                                <img class="h-12 w-12 rounded-full object-cover" 
                                                     src="{{ $item->getFirstMediaUrl('foto_pejabat', 'thumb') ?: $defaultAvatar }}" 
                                                     alt="{{ $item->nama }}"
                                                     onerror="this.onerror=null; this.src='{{ $defaultAvatar }}';">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                                                {{-- <div class="text-sm text-gray-500">{{ $item->nip ?: 'NIP: -' }}</div> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $item->jabatan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->urutan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.pejabat.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.pejabat.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pejabat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="bi bi-trash3-fill text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data pejabat yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pejabat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>