<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Komentar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">&larr; Kembali ke Daftar Komentar</a>
                        <h3 class="text-lg font-medium text-gray-900 mb-0">Komentar #{{ $comment->id }}</h3>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="card p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted small"><strong>Postingan:</strong> 
                                    <a href="{{ route('berita.show', $comment->post->slug) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $comment->post->title }}
                                    </a>
                                </p>
                                <p class="text-muted small"><strong>Pengirim:</strong> 
                                    {{ $comment->user->name ?? $comment->name }} ({{ $comment->email ?? 'N/A' }})
                                </p>
                                <p class="text-muted small"><strong>Status Verifikasi:</strong> 
                                    @if($comment->email_verified_at)
                                        <span class="badge badge-success">Terverifikasi</span>
                                    @else
                                        <span class="badge badge-warning">Belum Verifikasi</span>
                                    @endif
                                </p>
                                <p class="text-muted small"><strong>Status Moderasi:</strong> 
                                    <span class="badge {{ $comment->status == 'approved' ? 'badge-success' : ($comment->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="text-muted small"><strong>Dikirim:</strong> {{ $comment->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-muted small"><strong>Terakhir Diperbarui:</strong> {{ $comment->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <hr>
                        <h5 class="mt-3">Isi Komentar:</h5>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            @if($comment->status == 'pending')
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                </form>
                            @endif
                            @if($comment->status != 'rejected')
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#replyModal">Balas</button>
                            @endif
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Membalas Komentar --}}
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Balas Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.comments.reply') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="replyContent" class="form-label">Isi Balasan</label>
                            <textarea class="form-control" name="content" id="replyContent" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    // Ini hanya untuk memastikan modal balasan berfungsi di halaman ini
    var replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
</script>
@endpush