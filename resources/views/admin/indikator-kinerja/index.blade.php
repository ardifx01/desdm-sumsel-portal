<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Indikator Kinerja') }}
            </h2>
            <a href="{{ route('admin.indikator-kinerja.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Indikator Baru
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

                    <div class="space-y-8">
                        @forelse ($sasaranStrategis as $sasaran)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                                    {{ $sasaran->urutan }}. {{ $sasaran->sasaran }}
                                </h3>
                                @if($sasaran->indikatorKinerja->isEmpty())
                                    <p class="text-sm text-gray-500 italic">Belum ada indikator untuk sasaran ini.</p>
                                @else
                                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 10%;">Urutan</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Indikator</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($sasaran->indikatorKinerja->sortBy('urutan') as $indikator)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center font-medium">
                                                        {{ $indikator->urutan }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <p class="text-sm font-medium text-gray-900">{{ $indikator->nama_indikator }}</p>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                        {{ $indikator->satuan }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                        <a href="{{ route('admin.indikator-kinerja.edit', $indikator) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                            <i class="bi bi-pencil-square text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('admin.indikator-kinerja.destroy', $indikator) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus indikator ini? Semua data target & realisasi terkait akan terhapus!');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                                <i class="bi bi-trash3-fill text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500">Silakan tambahkan <a href="{{ route('admin.sasaran-strategis.create') }}" class="text-blue-600 hover:underline">Sasaran Strategis</a> terlebih dahulu.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>