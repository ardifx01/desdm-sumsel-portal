{{-- Tag <link> dan <style> sudah dihapus sepenuhnya dari sini --}}

<footer class="bg-dark text-white py-5 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>DESDM SUMSEL</h5>
                <p>Dinas Energi dan Sumber Daya Mineral<br>
                    Provinsi Sumatera Selatan</p>
                <table class="text-muted w-100">
                    <tbody>
                        <tr>
                            <td class="fw-bold w-20 align-top">Alamat</td>
                            <td class="pe-2 align-top"> : </td>
                            <td>{{ $settings['alamat_kantor'] ?? 'Alamat belum diatur' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold w-20">Telp.</td>
                            <td class="pe-2"> : </td>
                            <td>{{ $settings['telp_kontak'] ?? 'Telp belum diatur' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold w-20">E-Mail</td>
                            <td class="pe-2"> : </td>
                            <td>{{ $settings['email_kontak'] ?? 'Email belum diatur' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Tautan Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
                    <li><a href="{{ route('publikasi.index') }}">Publikasi & Dokumen</a></li>
                    <li><a href="{{ route('berita.index') }}">Berita Terbaru</a></li>
                    <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li><a href="{{ url('/#services') }}">Layanan & Pengaduan</a></li>
                    <li><a href="{{ route('kontak.index') }}">Kontak Umum</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Informasi Penting</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('static-pages.peta-situs') }}">Peta Situs</a></li>
                    <li><a href="{{ route('static-pages.show', 'kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('static-pages.show', 'disclaimer') }}">Disclaimer</a></li>
                    <li><a href="{{ route('static-pages.show', 'aksesibilitas') }}">Halaman Aksesibilitas</a></li>
                </ul>
                <h5 class="mt-4">Ikuti Kami</h5>
                <div class="social-icons">
                    <a href="{{ $settings['facebook_url'] ?? '#' }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $settings['twitter_url'] ?? '#' }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <div class="text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'DESDM Sumsel') }}. Hak Cipta Dilindungi. <br>Dikembangkan oleh Tim IT Dinas ESDM Provinsi Sumatera Selatan.</p>
        </div>
    </div>
</footer>