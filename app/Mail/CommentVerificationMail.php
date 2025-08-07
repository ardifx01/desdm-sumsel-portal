<?php

// app/Mail/CommentVerificationMail.php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Email Komentar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comments.verification',
        );
    }
}