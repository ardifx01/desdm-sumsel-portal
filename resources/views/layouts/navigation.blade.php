<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
{{-- Logo --}}
<div class="shrink-0 flex items-center">
    <a href="{{ route('dashboard') }}">
        
        @php
            // Variabel $settings sudah tersedia global via View Composer
            $logoPath = $settings['app_logo'] ?? null;
            $logoExists = $logoPath && file_exists(public_path('storage/' . $logoPath));
        @endphp

        @if($logoExists)
            {{-- Jika logo ada, tampilkan gambar --}}
            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo DESDM Sumsel" style="height: 40px;">
        @else
            {{-- Jika tidak ada, tampilkan teks --}}
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                DESDM SUMSEL
            </span>
        @endif

    </a>
</div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Dropdown Pengaturan (Hanya untuk Super Admin) --}}
                    @if(Auth::user()->role === 'super_admin')
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                      
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>Pengaturan</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.users.index')">
                                    {{ __('Manajemen Pengguna') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.settings.edit')">
                                    {{ __('Pengaturan Global Web') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.activity-log.index')">
                                    {{ __('Activity Log') }}
                                </x-dropdown-link>                                
                                <div class="border-t border-gray-200"></div>
                                <x-dropdown-link :href="route('admin.static-pages.index')">
                                    {{ __('Halaman Statis') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    {{-- Dropdown Media Center (Untuk Super Admin dan Editor) --}}
                    @if(in_array(Auth::user()->role, ['super_admin', 'editor']))
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>Media Center</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Manajemen Berita</h6>
                                @if(Auth::user()->role === 'super_admin')
                                <x-dropdown-link :href="route('admin.categories.index')">
                                    {{ __('Kategori Berita') }}
                                </x-dropdown-link>
                                @endif
                                <x-dropdown-link :href="route('admin.posts.index')">
                                    {{ __('Berita') }}
                                </x-dropdown-link>
                                
                                <div class="border-t border-gray-200"></div>
                                <x-dropdown-link :href="route('admin.comments.index')">
                                    {{ __('Moderasi Komentar') }}
                                </x-dropdown-link>
                                
                                @if(Auth::user()->role === 'super_admin')
                                <div class="border-t border-gray-200"></div>
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Manajemen Dokumen</h6>
                                <x-dropdown-link :href="route('admin.dokumen-categories.index')">
                                    {{ __('Kategori Dokumen') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.dokumen.index')">
                                    {{ __('Dokumen') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Manajemen Galeri</h6>
                                <x-dropdown-link :href="route('admin.albums.index')">
                                    {{ __('Album Foto') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.videos.index')">
                                    {{ __('Video') }}
                                </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    {{-- Dropdown PPID (Untuk Super Admin dan PPID Admin) --}}
                    @if(in_array(Auth::user()->role, ['super_admin', 'ppid_admin']))
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="60">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>PPID</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Manajemen Informasi Publik</h6>
                                <x-dropdown-link :href="route('admin.informasi-publik-categories.index')">
                                    {{ __('Kategori Informasi Publik') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.informasi-publik.index')">
                                    {{ __('Informasi Publik') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Manajemen Permohonan & Keberatan</h6>
                                <x-dropdown-link :href="route('admin.permohonan.index')">
                                    {{ __('Permohonan Informasi') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.keberatan.index')">
                                    {{ __('Pengajuan Keberatan') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
                    
                    {{-- Dropdown OPD (Hanya untuk Super Admin) --}}
                    @if(Auth::user()->role === 'super_admin')
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>OPD</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Pejabat/Pimpinan Unit</h6>
                                <x-dropdown-link :href="route('admin.pejabat.index')">
                                    {{ __('Manajemen Pejabat') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Bidang/UPTD/Cabdin</h6>
                                <x-dropdown-link :href="route('admin.bidang.index')">
                                    {{ __('Manajemen Bidang') }}
                                </x-dropdown-link>
                                {{-- TAUTAN BARU DI SINI --}}
                                <div class="border-t border-gray-200"></div>
                                <h6 class="dropdown-header px-4 py-2 text-xs text-gray-400">Kinerja</h6>
                                <x-dropdown-link :href="route('admin.sasaran-strategis.index')">
                                    {{ __('Sasaran Strategis') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.indikator-kinerja.index')">
                                    {{ __('Indikator Kinerja') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.kinerja.index')">
                                    {{ __('Capaian Kinerja') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Profil Pengguna) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

        {{-- Menu Dinamis Responsif --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            @if(Auth::user()->role === 'super_admin')
                <div class="px-4 py-2 text-xs text-gray-400">Pengaturan</div>
                <x-responsive-nav-link :href="route('admin.users.index')">{{ __('Manajemen Pengguna') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings.edit')">{{ __('Pengaturan Global Web') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.activity-log.index')">{{ __('Activity Log') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.static-pages.index')">{{ __('Halaman Statis') }}</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @if(in_array(Auth::user()->role, ['super_admin', 'editor']))
                <div class="px-4 py-2 text-xs text-gray-400">Media Center</div>
                @if(Auth::user()->role === 'super_admin')
                    <x-responsive-nav-link :href="route('admin.categories.index')">{{ __('Kategori Berita') }}</x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('admin.posts.index')">{{ __('Berita') }}</x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.comments.index')">{{ __('Moderasi Komentar') }}</x-responsive-nav-link>

                @if(Auth::user()->role === 'super_admin')
                    <x-responsive-nav-link :href="route('admin.dokumen-categories.index')">{{ __('Kategori Dokumen') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.dokumen.index')">{{ __('Dokumen') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.albums.index')">{{ __('Album Foto') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.videos.index')">{{ __('Video') }}</x-responsive-nav-link>
                @endif
            @endif
        </div>
        
        <div class="pt-4 pb-1 border-t border-gray-200">
            @if(in_array(Auth::user()->role, ['super_admin', 'ppid_admin']))
                <div class="px-4 py-2 text-xs text-gray-400">PPID</div>
                <x-responsive-nav-link :href="route('admin.informasi-publik-categories.index')">{{ __('Kategori Informasi Publik') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.informasi-publik.index')">{{ __('Informasi Publik') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.permohonan.index')">{{ __('Permohonan Informasi') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.keberatan.index')">{{ __('Pengajuan Keberatan') }}</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @if(Auth::user()->role === 'super_admin')
                <div class="px-4 py-2 text-xs text-gray-400">OPD</div>
                <x-responsive-nav-link :href="route('admin.pejabat.index')">{{ __('Manajemen Pejabat') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.bidang.index')">{{ __('Manajemen Bidang') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sasaran-strategis.index')">{{ __('Sasaran Strategis') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.indikator-kinerja.index')">{{ __('Indikator Kinerja') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.kinerja.index')">{{ __('Capaian Kinerja') }}</x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>