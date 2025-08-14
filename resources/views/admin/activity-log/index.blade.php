<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Log Aktivitas Pengguna') }}
            </h2>
            
            {{-- TOMBOL BARU DI SINI --}}
            <form action="{{ route('admin.activity-log.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA log aktivitas secara permanen? Aksi ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    <i class="bi bi-trash3-fill mr-2"></i> Bersihkan Log
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Perubahan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelaku</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($activities as $activity)
                                <tr>
                                    <td class="px-6 py-4 align-top">
                                        <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if($activity->subject)
                                                {{ Str::afterLast($activity->subject_type, '\\') }}: {{ $activity->subject->title ?? $activity->subject->name ?? $activity->subject->judul ?? $activity->subject->nama ?? $activity->subject->id }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 align-top text-sm text-gray-700">
                                        {{-- PERUBAHAN DI SINI: Menampilkan detail dari kolom 'properties' --}}
                                        @if($activity->event === 'updated' && $activity->properties->has('attributes'))
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($activity->properties['attributes'] as $key => $value)
                                                    {{-- Abaikan updated_at karena tidak informatif --}}
                                                    @if($key === 'updated_at') @continue @endif
                                                    <li>
                                                        <span class="font-semibold">{{ Str::ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                        <span class="text-red-600 line-through">{{ Str::limit($activity->properties['old'][$key] ?? 'N/A', 50) }}</span> &rarr;
                                                        <span class="text-green-600">{{ Str::limit($value, 50) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top whitespace-nowrap text-sm text-gray-500">
                                        {{ $activity->causer->name ?? 'Sistem/Tamu' }}
                                    </td>
                                    <td class="px-6 py-4 align-top whitespace-nowrap text-sm text-gray-500">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada aktivitas yang tercatat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>