<?php

// app/Http/Controllers/Admin/CommentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['post', 'user'])->latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        return view('admin.comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        $comment->status = 'approved';
        $comment->save();
        return back()->with('success', 'Komentar berhasil disetujui!');
    }

    public function reject(Comment $comment)
    {
        $comment->status = 'rejected';
        $comment->save();
        return back()->with('success', 'Komentar berhasil ditolak.');
    }

    public function destroy(Comment $comment)
    {
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

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $request->input('post_id');
        $comment->parent_id = $request->input('parent_id');
        $comment->user_id = auth()->id(); // Otomatis dari admin yang login
        $comment->status = 'approved'; // Balasan admin otomatis disetujui
        $comment->email_verified_at = now(); // <-- Tambahkan baris ini
        $comment->save();

        return back()->with('success', 'Balasan komentar berhasil dikirim.');
    }
}