<header class="header-transparent py-3 shadow-sm">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="header-menu-link logo-link text-decoration-none d-flex align-items-center">
                <div class="d-flex align-items-center logo-container">
                    {{-- Logo Dinas --}}
                    <a class="navbar-brand me-3" href="{{ url('/') }}">
                        @if(isset($settings['app_logo']))
                            <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Logo {{ $settings['app_name'] ?? '' }}" style="max-height: 50px;">
                        @else
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Default" style="max-height: 50px;">
                        @endif
                    </a>                
                    {{-- Teks Logo untuk Desktop (dua baris) --}}
                    <div class="logo-text-group d-none d-lg-block">
                        <div class="logo-main-title">PEMERINTAH PROVINSI SUMATERA SELATAN</div>
                        <div class="logo-sub-title">DINAS ENERGI DAN SUMBER DAYA MINERAL</div>
                    </div>
                    
                    {{-- Teks Logo untuk Mobile (satu baris) --}}
                    <span class="logo-text d-lg-none">{{ config('app.name', 'DESDM') }}</span>
                </div>
            </a>
            {{-- Navigasi Utama --}}
            <nav class="navbar navbar-expand-lg p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    {{-- PERUBAHAN DI SINI: Menambahkan kelas align-items-center --}}
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link header-menu-link" href="{{ url('/') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link header-menu-link" href="{{ url('/') }}#tentang-kami">Tentang Kami</a>
                        </li>
                        {{-- Dropdown untuk Informasi Publik (PPID) --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle header-menu-link" href="#" id="navbarDropdownPPID" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                PPID
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownPPID">
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.index') }}">Daftar Informasi Publik (DIP)</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header dropdown-header-custom">Profil PPID</h6></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID Overview</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.profil-ppid.visi-misi-maklumat') }}">Visi, Misi & Maklumat</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.profil-ppid.struktur-organisasi') }}">Struktur Organisasi PPID</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.profil-ppid.tugas-fungsi') }}">Tugas & Fungsi PPID</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.profil-ppid.dasar-hukum') }}">Dasar Hukum PPID</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header dropdown-header-custom">Layanan Informasi</h6></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.permohonan.prosedur') }}">Alur Permohonan Informasi</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.permohonan.form') }}">Formulir Permohonan Informasi</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header dropdown-header-custom">Pengajuan Keberatan</h6></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.keberatan.prosedur') }}">Alur Pengajuan Keberatan</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.keberatan.form') }}">Formulir Pengajuan Keberatan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.laporan-statistik') }}">Laporan & Statistik PPID</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.kontak-ppid') }}">Kontak PPID</a></li>
                            </ul>
                        </li>

                        {{-- Dropdown untuk Media Center --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle header-menu-link" href="#" id="navbarDropdownMC" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Media Center
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownMC">
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('publikasi.index') }}">Dokumen</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('berita.index') }}">Berita</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('galeri.index') }}">Galeri</a></li>
                            </ul>
                        </li>
                        {{-- Dropdown untuk Layanan & Pengaduan --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle header-menu-link" href="#" id="navbarDropdownLayanan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Layanan
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdownLayanan">
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('layanan-pengaduan.index') }}">Layanan Overview</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('layanan-pengaduan.pengaduan') }}">Pengaduan Masyarakat</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('layanan-pengaduan.faq-umum') }}">FAQ Umum</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('layanan-pengaduan.daftar-layanan') }}">Daftar Layanan Umum</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('layanan-pengaduan.cek-status') }}">Cek Status Layanan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link header-menu-link" href="{{ route('kontak.index') }}">Kontak</a>
                        </li>
                        
                        {{-- Logika untuk Pengguna Login/Tamu --}}
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dasbor Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit.public') }}">Edit Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                                                Keluar
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Masuk</a>
                            </li>
                            <li class="nav-item ms-lg-1">
                                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                            </li>
                        @endauth

                        {{-- PERUBAHAN DI SINI: Membungkus form pencarian dalam <li> --}}
                        <li class="nav-item ms-lg-3">
                            <form class="d-flex" action="{{ route('search') }}" method="GET">
                                <div class="input-group">
                                    <input class="form-control form-control-sm" type="search" name="query" placeholder="Cari..." aria-label="Search" value="{{ request('query') }}">
                                    <button class="btn btn-outline-secondary btn-sm" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>