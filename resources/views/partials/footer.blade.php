<footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>Tentang DESDM Sumsel</h5>
                    <p>Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan. Transparan, Akuntabel, dan Inovatif.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('informasi-publik.index') }}" class="text-white text-decoration-none">Informasi Publik (PPID)</a></li>
                        <li><a href="{{ route('publikasi.index') }}" class="text-white text-decoration-none">Publikasi & Dokumen</a></li>
                        <li><a href="{{ route('berita.index') }}" class="text-white text-decoration-none">Berita & Pengumuman</a></li>
                        <li><a href="{{ route('galeri.index') }}" class="text-white text-decoration-none">Galeri</a></li>
                        <li><a href="{{ route('layanan-pengaduan.index') }}" class="text-white text-decoration-none">Layanan & Pengaduan</a></li>
                        <li><a href="{{ route('kontak.index') }}" class="text-white text-decoration-none">Kontak Umum</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Informasi Penting</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('static-pages.peta-situs') }}" class="text-white text-decoration-none">Peta Situs</a></li>
                        <li><a href="{{ route('static-pages.kebijakan-privasi') }}" class="text-white text-decoration-none">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('static-pages.disclaimer') }}" class="text-white text-decoration-none">Disclaimer</a></li>
                        <li><a href="{{ route('static-pages.aksesibilitas') }}" class="text-white text-decoration-none">Halaman Aksesibilitas</a></li>
                    </ul>
                    <h5 class="mt-3">Ikuti Kami</h5>
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'DESDM Sumsel') }}. Hak Cipta Dilindungi. <br>Dikembangkan oleh Tim IT Dinas ESDM Provinsi Sumatera Selatan.</p>
            </div>
        </div>
    </footer>

{{-- Font Awesome untuk ikon unduh, jika belum diinstal di layout --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{-- Bootstrap Icons juga bisa digunakan jika prefer --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">