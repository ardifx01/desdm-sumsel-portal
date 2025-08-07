<p>Halo,</p>
<p>Terima kasih telah berkomentar. Untuk memverifikasi email Anda dan melanjutkan proses moderasi komentar, silakan klik tautan di bawah ini:</p>

<a href="{{ url('/comments/' . $comment->id . '/verify?token=' . sha1($comment->email)) }}">Verifikasi Email Saya</a>

<p>Jika Anda tidak mengirim komentar ini, silakan abaikan email ini.</p>