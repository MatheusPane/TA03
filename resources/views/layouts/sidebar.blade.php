<aside class="app-sidebar">
    <div class="sidebar-brand">
        <a href="{{ url('/dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image" />
            <span class="brand-text">Silalahi Dolok</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav nav-sidebar flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false">

                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @auth
                @if (Auth::user()->hasRole('Admin'))

                    {{-- 1. MANAJEMEN USER --}}
                    <li class="nav-header">Manajemen User</li>
                    <li class="nav-item">
                        <a href="{{ url('/roles') }}" class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-shield-lock"></i>
                            <p>Kelola Role</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>Kelola User</p>
                        </a>
                    </li>

                    {{-- 2. MASTER DATA --}}
                    <li class="nav-header">Master Data</li>
                    <li class="nav-item has-treeview {{ request()->is('ref_*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-database-fill"></i>
                            <p>
                                Referensi
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/ref_status_perkawinan') }}" class="nav-link {{ request()->is('ref_status_perkawinan*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-heart"></i>
                                    <p>Status Perkawinan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_agama') }}" class="nav-link {{ request()->is('ref_agama*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-book"></i>
                                    <p>Agama</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_pendidikan') }}" class="nav-link {{ request()->is('ref_pendidikan*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-mortarboard"></i>
                                    <p>Pendidikan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_pekerjaan') }}" class="nav-link {{ request()->is('ref_pekerjaan*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-briefcase"></i>
                                    <p>Pekerjaan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_status_dalam_keluarga') }}" class="nav-link {{ request()->is('ref_status_dalam_keluarga*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>Status Dalam Keluarga</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_jabatan') }}" class="nav-link {{ request()->is('ref_jabatan*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-badge"></i>
                                    <p>Jabatan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_jenis_akseptor_kb') }}" class="nav-link {{ request()->is('ref_jenis_akseptor_kb*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-capsule"></i>
                                    <p>Jenis Akseptor KB</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_jenis_kelompok_belajar') }}" class="nav-link {{ request()->is('ref_jenis_kelompok_belajar*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-journal-text"></i>
                                    <p>Jenis Kelompok Belajar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_jenis_koperasi') }}" class="nav-link {{ request()->is('ref_jenis_koperasi*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-shop"></i>
                                    <p>Jenis Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_jenis_usaha') }}" class="nav-link {{ request()->is('ref_jenis_usaha*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-building"></i>
                                    <p>Jenis Usaha</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_makanan_pokok') }}" class="nav-link {{ request()->is('ref_makanan_pokok*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-egg-fried"></i>
                                    <p>Makanan Pokok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_sumber_air') }}" class="nav-link {{ request()->is('ref_sumber_air*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-droplet"></i>
                                    <p>Sumber Air</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/ref_kegiatan_warga') }}" class="nav-link {{ request()->is('ref_kegiatan_warga*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-calendar-event"></i>
                                    <p>Kegiatan Warga</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @endauth

                {{-- 3. KEPENDUDUKAN --}}
                <li class="nav-header">Kependudukan</li>
                <li class="nav-item">
                    <a href="{{ url('/data_warga') }}" class="nav-link {{ request()->is('data_warga*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-vcard"></i>
                        <p>Data Warga</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/data_keluarga') }}" class="nav-link {{ request()->is('data_keluarga*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-heart"></i>
                        <p>Daftar Keluarga</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/dasawisma') }}" class="nav-link {{ request()->is('dasawisma*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Dasawisma</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kegiatan_warga.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('kegiatan_warga.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-calendar-check"></i>
                        <p>Kegiatan Warga</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('panduan_keluarga.index') }}" 
                       class="nav-link {{ request()->routeIs('panduan_keluarga.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Panduan Catatan Keluarga</p>
                    </a>
                </li>

                {{-- 4. KONFIGURASI --}}
                <li class="nav-header">Konfigurasi</li>
                <li class="nav-item">
                    <a href="{{ url('/tahun') }}" class="nav-link {{ request()->is('tahun*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-calendar3"></i>
                        <p>Tahun Pemerintahan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/dusun') }}" class="nav-link {{ request()->is('dusun*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-houses"></i>
                        <p>Data Dusun</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/desa-konfigurasi') }}" class="nav-link {{ request()->is('desa-konfigurasi*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-wide-connected"></i>
                        <p>Konfigurasi Desa</p>
                    </a>
                </li>

                {{-- 5. KELOLA SURAT --}}
                <li class="nav-header">Kelola Surat</li>
                <li class="nav-item">
                    <a href="{{ route('surat_keputusan.index') }}" 
                       class="nav-link {{ request()->routeIs('surat_keputusan.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>Surat Keputusan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('surat-biasa.index') }}" 
                       class="nav-link {{ request()->routeIs('surat-biasa.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark"></i>
                        <p>Surat Biasa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('surat-edaran.index') }}" 
                       class="nav-link {{ request()->routeIs('surat-edaran.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-arrow-up"></i>
                        <p>Surat Edaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('surat-kuasa.index') }}" 
                       class="nav-link {{ request()->routeIs('surat-kuasa.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-person"></i>
                        <p>Surat Kuasa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('surat-tugas.index') }}" 
                       class="nav-link {{ request()->routeIs('surat-tugas.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-check"></i>
                        <p>Surat Tugas</p>
                    </a>
                </li>

                {{-- LOGOUT --}}
                <li class="nav-header">Akun</li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" style="cursor: pointer;">
                            <i class="nav-icon bi bi-box-arrow-right"></i>
                            <p>Keluar</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
{{-- OverlayScrollbars --}}
<script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined' && OverlayScrollbarsGlobal.OverlayScrollbars) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>