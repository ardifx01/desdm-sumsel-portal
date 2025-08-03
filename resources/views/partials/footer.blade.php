{{-- Font Awesome untuk ikon sosial, pastikan sudah ada di file layout utama --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* ... (Gaya CSS untuk menu dan elemen lain di atas) ... */

    /* Aturan CSS yang diperbarui untuk footer */
    footer {
        background-color: #212529; /* Mengatur ulang warna latar belakang yang sedikit lebih gelap */
    }

    /* Memperbaiki warna judul agar putih dan tebal */
    footer h5 {
        color: #ffffff !important; /* Mengubah warna menjadi putih murni, menggunakan !important untuk memastikan override */
        font-weight: 700; /* Membuat judul lebih tebal */
        margin-bottom: 1rem;
    }

    /* Mengatur ulang gaya tautan di dalam footer agar tidak terpengaruh gaya default */
    footer .list-unstyled a,
    footer .social-icons a {
        color: #adb5bd; /* Warna teks abu-abu terang */
        text-decoration: none; /* Menghilangkan garis bawah */
        transition: color 0.3s ease;
    }

    footer .list-unstyled a:hover {
        color: var(--bs-primary) !important; /* Warna saat dihover berubah ke warna tema */
    }

    footer .social-icons {
        margin-top: 1rem;
        display: flex;
        gap: 1.5rem; /* Memberi jarak antar ikon */
    }

    footer .social-icons a {
        font-size: 1.5rem; /* Ukuran ikon lebih besar */
        color: #adb5bd; /* Warna ikon */
        transition: color 0.3s ease, transform 0.3s ease;
    }

    footer .social-icons a:hover {
        transform: translateY(-3px) scale(1.1); /* Efek melayang saat dihover */
        color: var(--bs-primary) !important;
    }

    footer p {
        color: #adb5bd;
    }

    footer hr {
        border-color: rgba(255, 255, 255, 0.1); /* Garis pemisah yang lebih samar */
    }

    footer .text-muted {
        color: #6c757d !important; /* Warna teks copyright yang lebih gelap */
        font-size: 0.9rem;
    }
</style>

<footer class="bg-dark text-white py-5 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>DESDM SUMSEL</h5>
                <p>Dinas Energi dan Sumber Daya Mineral</br>
                    Provinsi Sumatera Selatan</p>
                <table class="text-muted">
                    <tr>
                        <td>Alamat </td>
                        <td> : </td>
                        <td> Jalan Angkatan 45 No. 2440, Palembang</td>
                    </tr>
                    <tr>
                        <td>Telp. </td>
                        <td> : </td>
                        <td> 0711-379040</td>
                    </tr>
                    <tr>
                        <td>E-Mail </td>
                        <td> : </td>
                        <td> desdm.sumselprov@gmail.com</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Tautan Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('informasi-publik.index') }}">Informasi Publik (PPID)</a></li>
                    <li><a href="{{ route('publikasi.index') }}">Publikasi & Dokumen</a></li>
                    <li><a href="{{ route('berita.index') }}">Berita & Pengumuman</a></li>
                    <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li><a href="{{ route('layanan-pengaduan.index') }}">Layanan & Pengaduan</a></li>
                    <li><a href="{{ route('kontak.index') }}">Kontak Umum</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Informasi Penting</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('static-pages.peta-situs') }}">Peta Situs</a></li>
                    <li><a href="{{ route('static-pages.kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('static-pages.disclaimer') }}">Disclaimer</a></li>
                    <li><a href="{{ route('static-pages.aksesibilitas') }}">Halaman Aksesibilitas</a></li>
                </ul>
                <h5 class="mt-4">Ikuti Kami</h5>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <div class="text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'DESDM Sumsel') }}. Hak Cipta Dilindungi. <br>Dikembangkan oleh Tim IT Dinas ESDM Provinsi Sumatera Selatan.</p>
        </div>
    </div>
</footer>
