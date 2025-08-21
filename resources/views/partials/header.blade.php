<header class="header-transparent shadow-sm">
    <nav class="navbar navbar-expand-xl navbar-light">
        <div class="container">
            
            {{-- Bagian Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                @php
                    $logoPath = $settings['app_logo'] ?? null;
                    $logoExists = $logoPath && file_exists(public_path('storage/' . $logoPath));
                @endphp
                @if($logoExists)
                    <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo DESDM Sumsel" style="height: 50px;">
                @else
                    <span class="fw-bold fs-5 text-primary">DESDM SUMSEL</span>
                @endif
            </a>

            {{-- Tombol Hamburger (Toggler) --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Kontainer Menu yang Bisa 'Collapse' --}}
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-xl-center">
                    {{-- Item Menu --}}
                    <li class="nav-item"><a class="nav-link header-menu-link" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link header-menu-link" href="{{ url('/#tentang-kami') }}">Tentang Kami</a></li>
                    
                    {{-- Dropdown PPID --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle header-menu-link" href="#" data-bs-toggle="dropdown">PPID</a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.index') }}">Daftar Informasi Publik (DIP)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header dropdown-header-custom">Profil PPID</h6></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('informasi-publik.profil-ppid.index') }}">Profil PPID Overview</a></li>
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

                    {{-- Dropdown Media Center --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle header-menu-link" href="#" data-bs-toggle="dropdown">Media Center</a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('publikasi.index') }}">Dokumen</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('berita.index') }}">Berita</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('galeri.index') }}">Galeri</a></li>
                        </ul>
                    </li>

                    {{-- Dropdown Layanan --}}
                    <li class="nav-item"><a class="nav-link header-menu-link" href="{{ url('/#services') }}">Layanan</a></li>
                    
                    <li class="nav-item"><a class="nav-link header-menu-link" href="{{ route('kontak.index') }}">Kontak</a></li>

                    {{-- Garis Pemisah di Tampilan Mobile --}}
                    <li class="d-xl-none"><hr class="dropdown-divider"></li>

                    {{-- Logika User (Auth/Guest) --}}
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
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
                        <li class="nav-item mt-3 mt-xl-0 ms-xl-2"><a class="btn btn-outline-primary btn-sm w-100" href="{{ route('login') }}">Masuk</a></li>
                        <li class="nav-item mt-2 mt-xl-0 ms-xl-1"><a class="btn btn-primary btn-sm w-100" href="{{ route('register') }}">Daftar</a></li>
                    @endguest

                    {{-- Form Pencarian --}}
                    <li class="nav-item mt-3 mt-xl-0 ms-xl-3">
                        <form class="d-flex" action="{{ route('search') }}" method="GET">
                            <input class="form-control form-control-sm" type="search" name="q" placeholder="Cari..." value="{{ request('q') }}">
                            <button class="btn btn-outline-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>