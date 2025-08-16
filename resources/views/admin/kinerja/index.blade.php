<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4 sm:mb-0">
                {{ __('Manajemen Capaian Kinerja') }}
            </h2>
            <form action="{{ route('admin.kinerja.index') }}" method="GET" class="flex items-center space-x-2">
                <label for="tahun" class="text-sm font-medium">Tampilkan Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @php $currentYear = date('Y'); @endphp
                    @foreach ($availableYears as $yearOption)
                        <option value="{{ $yearOption }}" {{ $yearOption == $tahun ? 'selected' : '' }}>{{ $yearOption }}</option>
                    @endforeach
                    @if(!$availableYears->contains($currentYear))
                        <option value="{{ $currentYear }}" {{ $currentYear == $tahun ? 'selected' : '' }}>{{ $currentYear }}</option>
                    @endif
                    <option value="{{ $currentYear + 1 }}" {{ ($currentYear + 1) == $tahun ? 'selected' : '' }}>{{ $currentYear + 1 }}</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.kinerja.storeOrUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahun }}">

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="font-bold">Terjadi Kesalahan Validasi. Mohon periksa kembali input Anda.</p>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @php
                        // Helper function untuk format angka cerdas
                        function formatKinerjaNumber($number) {
                            if (is_null($number)) return 0;
                            // Cek jika angka adalah bilangan bulat (atau desimalnya .00)
                            if (floor($number) == $number) {
                                return number_format($number, 0, ',', '.');
                            }
                            return number_format($number, 2, ',', '.');
                        }
                        @endphp

                        @forelse($sasaranStrategis as $sasaran)
                            <div class="mb-10">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                                    Sasaran Strategis {{ $sasaran->urutan }}: {{ $sasaran->sasaran }}
                                </h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width: 300px;">Indikator Kinerja</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-l">Target Tahunan</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-l">Realisasi Q1</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Realisasi Q2</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Realisasi Q3</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Realisasi Q4</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-l">Total Realisasi</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">% Capaian</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @forelse($sasaran->indikatorKinerja as $indikator)
                                                @php
                                                    $kinerja = $indikator->kinerja->first();
                                                @endphp
                                                <tr class="border-b">
                                                    <td class="px-4 py-2 font-medium">{{ $indikator->nama_indikator }}</td>
                                                    <td class="px-4 py-2">{{ $indikator->satuan }}</td>
                                                    <td class="px-2 py-1 border-l">
                                                        <input type="text" name="kinerja[{{$indikator->id}}][target_tahunan]" value="{{ formatKinerjaNumber($kinerja->target_tahunan ?? 0) }}" class="w-32 border-gray-300 rounded-md shadow-sm text-sm text-right number-mask">
                                                    </td>
                                                    <td class="px-2 py-1 border-l"><input type="text" name="kinerja[{{$indikator->id}}][realisasi_q1]" value="{{ formatKinerjaNumber($kinerja->realisasi_q1 ?? 0) }}" class="w-32 border-gray-300 rounded-md shadow-sm text-sm text-right number-mask"></td>
                                                    <td class="px-2 py-1"><input type="text" name="kinerja[{{$indikator->id}}][realisasi_q2]" value="{{ formatKinerjaNumber($kinerja->realisasi_q2 ?? 0) }}" class="w-32 border-gray-300 rounded-md shadow-sm text-sm text-right number-mask"></td>
                                                    <td class="px-2 py-1"><input type="text" name="kinerja[{{$indikator->id}}][realisasi_q3]" value="{{ formatKinerjaNumber($kinerja->realisasi_q3 ?? 0) }}" class="w-32 border-gray-300 rounded-md shadow-sm text-sm text-right number-mask"></td>
                                                    <td class="px-2 py-1"><input type="text" name="kinerja[{{$indikator->id}}][realisasi_q4]" value="{{ formatKinerjaNumber($kinerja->realisasi_q4 ?? 0) }}" class="w-32 border-gray-300 rounded-md shadow-sm text-sm text-right number-mask"></td>
                                                    <td class="px-4 py-2 border-l text-right font-semibold bg-gray-50">{{ formatKinerjaNumber($kinerja->total_realisasi ?? 0) }}</td>
                                                    <td class="px-4 py-2 text-center font-bold {{ ($kinerja->persentase_capaian ?? 0) >= 100 ? 'text-green-600' : 'text-red-600' }} bg-gray-50">{{ number_format($kinerja->persentase_capaian ?? 0, 2, ',', '.') }}%</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="px-4 py-4 text-center text-gray-500 italic">
                                                        Belum ada indikator kinerja yang ditambahkan untuk sasaran ini. <a href="{{ route('admin.indikator-kinerja.index') }}" class="text-blue-600 hover:underline">Kelola Indikator</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500">Silakan tambahkan <a href="{{ route('admin.sasaran-strategis.index') }}" class="text-blue-600 hover:underline">Sasaran Strategis</a> terlebih dahulu.</p>
                            </div>
                        @endforelse

                        <div class="flex justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan Semua Perubahan') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT UNTUK MASKING INPUT --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.number-mask').forEach(function(input) {
                // PERBAIKAN DI SINI: Selalu izinkan 2 desimal untuk input
                new Cleave(input, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                    delimiter: '.',
                    numeralDecimalMark: ',',
                    numeralDecimalScale: 2 // <-- Selalu set ke 2
                });
            });
        });
    </script>
    @endpush
</x-app-layout>