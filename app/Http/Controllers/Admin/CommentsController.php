<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini
use Illuminate\Support\Facades\Gate; // <-- Tambahkan ini

class CommentsController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Comment::class);

        $query = Comment::with(['post', 'user'])->latest();

        // Jika pengguna adalah editor, hanya tampilkan komentar dari postingannya
        if (Auth::user()->role === 'editor') {
            $query->whereHas('post', function ($q) {
                $q->where('author_id', Auth::id());
            });
        }

        $comments = $query->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        Gate::authorize('view', $comment);
        return view('admin.comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        Gate::authorize('update', $comment);
        $comment->status = 'approved';
        $comment->save();
        return back()->with('success', 'Komentar berhasil disetujui!');
    }

    public function reject(Comment $comment)
    {
        Gate::authorize('update', $comment);
        $comment->status = 'rejected';
        $comment->save();
        return back()->with('success', 'Komentar berhasil ditolak.');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
    
    public function reply(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'required|exists:comments,id',
            'content' => 'required|string|max:500',
        ]);

        // Temukan komentar induk untuk otorisasi
        $parentComment = Comment::findOrFail($request->parent_id);
        Gate::authorize('reply', $parentComment);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $request->input('post_id');
        $comment->parent_id = $request->input('parent_id');
        $comment->user_id = auth()->id();
        $comment->status = 'approved';
        $comment->email_verified_at = now();
        $comment->save();

        return back()->with('success', 'Balasan komentar berhasil dikirim.');
    }
}