<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentVerificationMail;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:500',
            'website' => 'nullable|max:0',
            'parent_id' => 'nullable|exists:comments,id',
        ];

        if (!auth()->check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email';
        }

        $request->validate($rules);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $request->input('post_id');
        $comment->parent_id = $request->input('parent_id');

        if (auth()->check()) {
            $comment->user_id = auth()->id();
            $comment->status = 'approved';
            $comment->email_verified_at = now(); // <-- Tambahkan ini
        } else {
            $comment->name = $request->input('name');
            $comment->email = $request->input('email');
            $comment->status = 'pending';
        }
        
        $comment->save();

        if (!$comment->user_id) {
            Mail::to($comment->email)->send(new CommentVerificationMail($comment));
            return back()->with('success', 'Komentar Anda berhasil dikirim! Silakan cek email Anda untuk verifikasi.');
        }

        return back()->with('success', 'Komentar Anda berhasil dikirim dan langsung disetujui.');
    }

    public function verifyEmail(Request $request, Comment $comment)
    {
        if (!$request->hasValidSignature() && $request->input('token') !== sha1($comment->email)) {
            return redirect()->route('berita.show', $comment->post->slug)
                             ->with('error', 'Tautan verifikasi tidak valid atau sudah kadaluarsa.');
        }

        $comment->email_verified_at = now();
        $comment->save();
        
        return redirect()->route('berita.show', $comment->post->slug)
                         ->with('success', 'Email Anda berhasil diverifikasi. Komentar Anda akan segera dimoderasi.');
    }
}