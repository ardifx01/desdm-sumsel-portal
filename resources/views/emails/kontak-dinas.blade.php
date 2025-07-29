<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari Formulir Kontak Website</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background-color: #f8f8f8; padding: 10px; border-bottom: 1px solid #eee; text-align: center; }
        .content { padding: 20px 0; }
        .footer { border-top: 1px solid #eee; padding-top: 10px; font-size: 0.8em; color: #777; text-align: center; }
        ul { list-style: none; padding: 0; }
        li strong { display: inline-block; width: 120px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pesan Baru dari Formulir Kontak Website</h2>
        </div>
        <div class="content">
            <p>Anda menerima pesan baru dari formulir kontak di website {{ config('app.name') }}:</p>
            <ul>
                <li><strong>Nama:</strong> {{ $nama_pengirim }}</li>
                <li><strong>Email:</strong> {{ $email_pengirim }}</li>
                @if ($telp_pengirim)
                    <li><strong>Telepon:</strong> {{ $telp_pengirim }}</li>
                @endif
                <li><strong>Subjek:</strong> {{ $subjek }}</li>
            </ul>
            <p><strong>Pesan:</strong></p>
            <p style="white-space: pre-wrap; border: 1px solid #eee; padding: 10px; background-color: #f9f9f9;">{{ $pesan }}</p>
        </div>
        <div class="footer">
            <p>Pesan ini dikirim secara otomatis dari formulir kontak website {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>