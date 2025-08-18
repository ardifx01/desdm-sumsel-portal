{{-- Tentukan kelas wrapper berdasarkan apakah ini balasan atau bukan --}}
@php
    $wrapperClass = ($depth > 0) ? 'comment-reply' : '';
@endphp

<div class="{{ $wrapperClass }}">
    <div class="d-flex mb-3">
        <div class="flex-shrink-0 me-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? $comment->name) }}&background=0D8ABC&color=FFFFFF&rounded=true" width="50" height="50" alt="Avatar">
        </div>
        <div class="flex-grow-1">
            <h6 class="mt-0 fw-bold">
                {{ $comment->user->name ?? $comment->name }}
            </h6>
            <div class="comment-content p-3 bg-light rounded shadow-sm mb-2">
                {{-- PERBAIKAN PENTING: Gunakan e() untuk sanitasi output --}}
                <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
            </div>
            <div class="comment-actions small text-muted d-block">
                <span>{{ $comment->created_at->diffForHumans() }}</span>
                <a href="#" class="reply-btn text-primary ms-2" data-comment-id="{{ $comment->id }}">
                    <i class="bi bi-reply-fill"></i> Balas
                </a>
            </div>
            
            {{-- Form Balasan --}}
            <div class="reply-form mt-3" id="reply-form-{{ $comment->id }}">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    
                    @guest
                    <div class="row mb-2">
                        <div class="col-md-6"><input type="text" name="name" class="form-control form-control-sm" placeholder="Nama Anda *" required></div>
                        <div class="col-md-6"><input type="email" name="email" class="form-control form-control-sm" placeholder="Email Anda *" required></div>
                    </div>
                    @endguest
                    
                    <div class="mb-2">
                        <textarea name="content" class="form-control form-control-sm" rows="3" placeholder="Tulis balasan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Kirim Balasan</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tampilkan Balasan Secara Rekursif --}}
    @foreach($comment->replies as $reply)
        @include('berita.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
    @endforeach
</div>