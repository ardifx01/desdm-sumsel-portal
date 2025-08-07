<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moderasi Komentar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Komentar</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konten</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Postingan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($comments as $comment)
                                <tr class="{{ $comment->status == 'pending' ? 'bg-yellow-50' : '' }}">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <a href="{{ route('admin.comments.show', $comment) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ Str::limit($comment->content, 100) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('berita.show', $comment->post->slug) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                            {{ Str::limit($comment->post->title, 30) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $comment->user->name ?? $comment->name }} ({{ $comment->email ?? 'N/A' }})
                                        @if($comment->email_verified_at)
                                            <span class="badge badge-success">Terverifikasi</span>
                                        @else
                                            <span class="badge badge-warning">Belum Verifikasi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="badge {{ $comment->status == 'approved' ? 'badge-success' : ($comment->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($comment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.comments.show', $comment) }}" class="text-blue-600 hover:text-blue-900 me-2">Lihat</a>
                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada komentar yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>