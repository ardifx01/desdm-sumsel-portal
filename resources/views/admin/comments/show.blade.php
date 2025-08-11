<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Komentar #') }}{{ $comment->id }}
            </h2>
            <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- KARTU KONTEKS KOMENTAR INDUK --}}
            @if($comment->parent)
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <p class="text-sm font-medium text-gray-500 mb-2">Membalas komentar dari <span class="font-bold">{{ $comment->parent->user->name ?? $comment->parent->name }}</span>:</p>
                    <div class="p-4 bg-gray-100 rounded-lg text-sm text-gray-700 italic">
                        "{{ $comment->parent->content }}"
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Info Header Komentar -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Pada Postingan:</p>
                                <a href="{{ route('berita.show', $comment->post->slug) }}" target="_blank" class="text-lg font-semibold text-indigo-600 hover:text-indigo-800">
                                    {{ $comment->post->title }}
                                </a>
                            </div>
                            <div class="text-right text-sm text-gray-500 flex-shrink-0">
                                {{ $comment->created_at->isoFormat('dddd, D MMMM YYYY') }}
                                <br>
                                <span class="text-xs">{{ $comment->created_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center space-x-4 text-sm">
                            <p><strong>Pengirim:</strong> {{ $comment->user->name ?? $comment->name }}</p>
                            <p><strong>Status:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($comment->status)
                                        @case('approved') bg-green-100 text-green-800 @break
                                        @case('rejected') bg-red-100 text-red-800 @break
                                        @default bg-yellow-100 text-yellow-800
                                    @endswitch">
                                    {{ ucfirst($comment->status) }}
                                </span>
                            </p>
                            @if(!$comment->user_id)
                            <p><strong>Verifikasi:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $comment->email_verified_at ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $comment->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                </span>
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Isi Komentar -->
                    <div class="mt-4">
                        <h4 class="font-semibold mb-2">Isi Komentar:</h4>
                        <div class="p-4 bg-gray-50 rounded-lg prose max-w-none">
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>

                    <!-- Aksi Moderasi -->
                    <div class="flex items-center justify-end mt-6 pt-4 border-t border-gray-200 space-x-2">
                        {{-- Tombol Approve (selalu tampil jika status bukan 'approved') --}}
                        @if($comment->status != 'approved')
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-semibold">Setujui</button>
                            </form>
                        @endif

                        {{-- Tombol Reject (selalu tampil jika status bukan 'rejected') --}}
                        @if($comment->status != 'rejected')
                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm font-semibold">Tolak</button>
                            </form>
                        @endif
                        
                        {{-- Tombol Balas (selalu tampil jika status bukan 'rejected') --}}
                        @if($comment->status != 'rejected')
                            <button x-data @click.prevent="document.getElementById('reply-form').scrollIntoView({ behavior: 'smooth' }); document.getElementById('replyContent').focus()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold">Balas</button>
                        @endif

                        {{-- Tombol Hapus (selalu tampil) --}}
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-semibold">Hapus</button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- Form Balasan (selalu tampil jika status bukan ditolak) --}}
            @if($comment->status != 'rejected')
            <div id="reply-form" class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Tulis Balasan Anda</h3>
                    <p class="mt-1 text-sm text-gray-600">Balasan Anda akan langsung disetujui dan ditampilkan.</p>
                    <form action="{{ route('admin.comments.reply') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div>
                            <textarea name="content" id="replyContent" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ketik balasan Anda di sini..." required></textarea>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button>{{ __('Kirim Balasan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>