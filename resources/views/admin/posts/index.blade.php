<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4 sm:mb-0">
                {{ __('Manajemen Berita') }}
            </h2>
            @can('create', App\Models\Post::class)
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="bi bi-plus-lg mr-2"></i> Tulis Berita Baru
            </a>
            @endcan
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

                    <!-- Form Filter -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border">
                        <form action="{{ route('admin.posts.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-center">
                            <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                            <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 text-sm font-semibold">
                                    <i class="bi bi-funnel-fill mr-2"></i> Filter
                                </button>
                                @if(request()->hasAny(['q', 'category_id', 'status']))
                                    <a href="{{ route('admin.posts.index') }}" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-semibold">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Berita -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Artikel</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status & Statistik</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($posts as $post)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-20">
                                                @if($post->hasMedia('featured_image'))
                                                    <img class="h-12 w-20 rounded-md object-cover" src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') }}" alt="">
                                                @else
                                                    <div class="h-12 w-20 rounded-md bg-gray-100 flex items-center justify-center">
                                                        <i class="bi bi-image-alt text-2xl text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                                                    <a href="{{ route('berita.show', $post->slug) }}" target="_blank" title="{{ $post->title }}">{{ Str::limit($post->title, 60) }}</a>
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $post->created_at->isoFormat('D MMM YYYY') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- KOLOM KATEGORI DIKEMBALIKAN DI SINI --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 'badge-category-' . Str::slug($post->category->name) }}">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $post->author->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center mb-1">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-xs" title="Dilihat / Komentar">
                                            <i class="bi bi-eye-fill mr-1"></i> {{ $post->hits }}
                                            <span class="mx-1">|</span>
                                            <i class="bi bi-chat-dots-fill mr-1"></i> {{ $post->comments->count() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        @can('update', $post)
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $post)
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="bi bi-trash3-fill text-lg"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada artikel berita yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>