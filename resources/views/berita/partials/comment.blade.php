<div class="d-flex mb-3">
    <div class="flex-shrink-0 me-3">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? $comment->name) }}&color=FFFFFF&background=0D8ABC" class="rounded-circle" width="40" height="40" alt="Avatar">
    </div>
    <div class="flex-grow-1">
        <h6 class="mt-0">
            {{ $comment->user->name ?? $comment->name }}
            @if($comment->email)
                <small class="text-muted fw-normal">({{ $comment->email }})</small>
            @endif
        </h6>
        <div class="p-3 bg-light rounded shadow-sm">
            <p class="mb-0">{{ $comment->content }}</p>
        </div>
        <small class="text-muted mt-2 mb-2 d-block">
            {{ $comment->created_at->diffForHumans() }}
            <a href="#" class="reply-btn text-muted fw-bold ms-2" data-comment-id="{{ $comment->id }}">Balas</a>
        </small>
        
        {{-- Form Balasan --}}
        <div class="reply-form mt-3 ps-3 border-start" id="reply-form-{{ $comment->id }}" style="display:none;">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                
                @if(!auth()->check())
                <div class="mb-2">
                    <label for="reply-name-{{ $comment->id }}" class="form-label">Nama Anda <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="reply-name-{{ $comment->id }}" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="reply-email-{{ $comment->id }}" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="reply-email-{{ $comment->id }}" class="form-control" required>
                </div>
                @endif
                
                <div class="mb-2">
                    <textarea name="content" class="form-control" rows="2" placeholder="Balas komentar ini..." required></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Kirim Balasan</button>
            </form>
        </div>
        
        {{-- Tampilkan Balasan Secara Rekursif --}}
        @foreach($comment->replies as $reply)
            <div class="mt-3"> @include('berita.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
            </div>
        @endforeach
    </div>
</div>