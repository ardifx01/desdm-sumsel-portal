<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KontakDinasMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Properti untuk menyimpan data dari formulir

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data; // Inisialisasi data yang akan dikirim ke template email
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan Baru dari Formulir Kontak Website: ' . $this->data['subjek'], // Subjek email
            from: new \Illuminate\Mail\Mailables\Address($this->data['email_pengirim'], $this->data['nama_pengirim']), // Menggunakan nama dan email pengirim dari form
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->data['email_pengirim'], $this->data['nama_pengirim']), // Agar bisa langsung Reply ke pengirim
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.kontak-dinas', // Mengarahkan ke template Blade email
            with: [
                'nama_pengirim' => $this->data['nama_pengirim'],
                'email_pengirim' => $this->data['email_pengirim'],
                'telp_pengirim' => $this->data['telp_pengirim'],
                'subjek' => $this->data['subjek'],
                'pesan' => $this->data['pesan'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Tidak ada attachment untuk email kontak sederhana
    }
}