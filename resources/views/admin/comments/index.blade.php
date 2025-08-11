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
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Komentar</h3>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim & Komentar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konteks Postingan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($comments as $comment)
                                <tr class="{{ $comment->status == 'pending' ? 'bg-yellow-50' : '' }}">
                                    <td class="px-6 py-4">
                                        {{-- PERUBAHAN DI SINI: Menambahkan kutipan komentar induk --}}
                                        @if($comment->parent)
                                            <div class="text-xs text-gray-500 mb-2 p-2 bg-gray-100 rounded-md">
                                                <div class="flex items-center mb-1">
                                                    <i class="bi bi-arrow-return-right mr-2"></i>
                                                    <span>Membalas: <span class="font-medium">{{ $comment->parent->user->name ?? $comment->parent->name }}</span></span>
                                                </div>
                                                <p class="pl-5 italic truncate">"...{{ Str::limit($comment->parent->content, 70) }}"</p>
                                            </div>
                                        @endif

                                        <div class="text-sm font-medium text-gray-900">{{ $comment->user->name ?? $comment->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $comment->user ? 'Pengguna Terdaftar' : $comment->email }}</div>
                                        <p class="text-sm text-gray-800 mt-2 italic border-l-4 {{ $comment->parent_id ? 'border-blue-300' : 'border-gray-200' }} pl-3">
                                            "{{ Str::limit($comment->content, 120) }}"
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('berita.show', $comment->post->slug) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            {{ Str::limit($comment->post->title, 40) }}
                                        </a>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $comment->created_at->isoFormat('D MMM YYYY, HH:mm') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @switch($comment->status)
                                                    @case('approved') bg-green-100 text-green-800 @break
                                                    @case('rejected') bg-red-100 text-red-800 @break
                                                    @default bg-yellow-100 text-yellow-800
                                                @endswitch">
                                                {{ ucfirst($comment->status) }}
                                            </span>
                                            @if(!$comment->user_id)
                                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $comment->email_verified_at ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $comment->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        @if($comment->status == 'pending')
                                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Setujui">
                                                    <i class="bi bi-check-circle-fill text-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-orange-500 hover:text-orange-700" title="Tolak">
                                                    <i class="bi bi-x-circle-fill text-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('admin.comments.show', $comment) }}" class="text-blue-600 hover:text-blue-900" title="Lihat & Balas">
                                            <i class="bi bi-chat-square-dots-fill text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini secara permanen?');">
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
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
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