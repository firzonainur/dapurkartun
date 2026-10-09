<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') - Dapur Kartun</title>

    @php
        $siteFavicon = \App\Models\SiteSetting::get('site_favicon', 'images/logo.svg');
        $siteLogo = \App\Models\SiteSetting::get('site_logo', 'images/logo.svg');
    @endphp

    <link rel="icon" type="image/svg+xml" href="{{ asset($siteFavicon) }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper" id="adminWrapper">
        <!-- Backdrop Overlay for Mobile Drawer -->
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar" id="adminSidebar" role="navigation" aria-label="Menu Admin">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset($siteLogo) }}" alt="Dapur Kartun" width="140" height="36" style="filter: brightness(0) invert(1); max-height: 36px; object-fit: contain;">
                </a>
                <button type="button" class="sidebar-close-mobile" id="sidebarCloseBtn" aria-label="Tutup Menu">
                    &times;
                </button>
            </div>

            <ul class="sidebar-menu">
                <!-- 1. Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span class="sidebar-link-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="9"></rect>
                                    <rect x="14" y="3" width="7" height="5"></rect>
                                    <rect x="14" y="12" width="7" height="9"></rect>
                                    <rect x="3" y="16" width="7" height="5"></rect>
                                </svg>
                            </span>
                            <span class="sidebar-link-text">Dashboard</span>
                        </span>
                    </a>
                </li>

                <!-- 2. Konten Website (Dropdown Group) -->
                @php
                    $isContentActive = request()->routeIs('admin.slides.*', 'admin.galleries.*', 'admin.gallery.*', 'admin.testimonials.*', 'admin.news.*', 'admin.news-categories.*');
                @endphp
                <li class="sidebar-group {{ $isContentActive ? 'open' : '' }}" id="contentGroup">
                    <button type="button" class="sidebar-link {{ $isContentActive ? 'active' : '' }}" id="contentToggleBtn" aria-expanded="{{ $isContentActive ? 'true' : 'false' }}">
                        <span class="sidebar-link-content">
                            <span class="sidebar-link-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </span>
                            <span class="sidebar-link-text">Konten Website</span>
                        </span>
                        <span class="submenu-arrow">▼</span>
                    </button>
                    <ul class="sidebar-submenu {{ $isContentActive ? '' : 'hidden' }}" id="contentSubmenu">
                        <li>
                            <a href="{{ route('admin.slides.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                                <span>&bull;</span>
                                <span>Slider Hero</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.galleries.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.galleries.*', 'admin.gallery.*') ? 'active' : '' }}">
                                <span>&bull;</span>
                                <span>Galeri Karya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.testimonials.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                                <span>&bull;</span>
                                <span>Testimoni</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.news.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.news.*', 'admin.news-categories.*') ? 'active' : '' }}">
                                <span>&bull;</span>
                                <span>News / Artikel</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 3. Pesan Kontak -->
                <li>
                    <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span class="sidebar-link-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <span class="sidebar-link-text">Pesan Kontak</span>
                        </span>
                        @php
                            $unreadTotal = \App\Models\Contact::where('is_read', false)->count();
                        @endphp
                        @if($unreadTotal > 0)
                            <span class="badge-counter">{{ $unreadTotal }}</span>
                        @endif
                    </a>
                </li>

                <!-- 4. Pengaturan Website -->
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span class="sidebar-link-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </span>
                            <span class="sidebar-link-text">Pengaturan Website</span>
                        </span>
                    </a>
                </li>
            </ul>

            <!-- Footer: 5. Lihat Website & 6. Keluar -->
            <div class="sidebar-footer">
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="sidebar-link" style="color: #94A3B8;">
                    <span class="sidebar-link-content">
                        <span class="sidebar-link-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                        </span>
                        <span class="sidebar-link-text">Lihat Website</span>
                    </span>
                    <span style="font-size: 0.8rem;">↗</span>
                </a>

                <button type="button" class="sidebar-link" id="sidebarLogoutBtn" style="color: #F87171;">
                    <span class="sidebar-link-content">
                        <span class="sidebar-link-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </span>
                        <span class="sidebar-link-text">Keluar</span>
                    </span>
                </button>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Topbar Header -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Buka atau Tutup Menu Navigasi">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <h2>@yield('header_title', 'Panel Admin Dapur Kartun')</h2>
                </div>

                <div class="topbar-right">
                    <div class="user-badge">
                        <div class="user-avatar-circle">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                    </div>

                    <button type="button" class="adm-btn adm-btn-secondary adm-btn-sm" id="topbarLogoutBtn" title="Keluar dari Panel Admin">
                        Keluar
                    </button>
                </div>
            </header>

            <!-- Body Content -->
            <div class="admin-body">
                @if(session('success'))
                    <div style="background-color: #DCFCE7; color: #166534; padding: 0.9rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.6rem; border: 1px solid #BBF7D0;">
                        <span>✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div style="background-color: #FEE2E2; color: #991B1B; padding: 0.9rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.6rem; border: 1px solid #FECACA;">
                        <span>⚠</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div class="adm-modal-backdrop" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="adm-modal-card">
            <h3 class="adm-modal-title" id="logoutModalTitle">Konfirmasi Keluar</h3>
            <p class="adm-modal-text">Apakah Anda yakin ingin keluar dari Panel Admin Dapur Kartun? Sesi pengelolaan Anda akan diakhiri dengan aman.</p>
            <div class="adm-modal-actions">
                <button type="button" class="adm-btn adm-btn-secondary" id="logoutCancelBtn">Batal</button>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="adm-btn adm-btn-danger">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Sidebar drawer and desktop collapse handling
        const adminWrapper = document.getElementById('adminWrapper');
        const adminSidebar = document.getElementById('adminSidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                adminSidebar.classList.toggle('drawer-open');
                sidebarBackdrop.classList.toggle('active');
            } else {
                adminWrapper.classList.toggle('sidebar-collapsed');
            }
        }

        function closeSidebarDrawer() {
            adminSidebar.classList.remove('drawer-open');
            sidebarBackdrop.classList.remove('active');
        }

        sidebarToggleBtn.addEventListener('click', toggleSidebar);
        if (sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebarDrawer);
        if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebarDrawer);

        // Submenu accordion toggle
        const contentToggleBtn = document.getElementById('contentToggleBtn');
        const contentGroup = document.getElementById('contentGroup');
        const contentSubmenu = document.getElementById('contentSubmenu');

        if (contentToggleBtn) {
            contentToggleBtn.addEventListener('click', () => {
                const isHidden = contentSubmenu.classList.toggle('hidden');
                contentGroup.classList.toggle('open', !isHidden);
                contentToggleBtn.setAttribute('aria-expanded', !isHidden);
            });
        }

        // Logout Confirmation Modal
        const logoutModal = document.getElementById('logoutModal');
        const topbarLogoutBtn = document.getElementById('topbarLogoutBtn');
        const sidebarLogoutBtn = document.getElementById('sidebarLogoutBtn');
        const logoutCancelBtn = document.getElementById('logoutCancelBtn');

        function openLogoutModal() {
            logoutModal.classList.add('active');
        }

        function closeLogoutModal() {
            logoutModal.classList.remove('active');
        }

        if (topbarLogoutBtn) topbarLogoutBtn.addEventListener('click', openLogoutModal);
        if (sidebarLogoutBtn) sidebarLogoutBtn.addEventListener('click', openLogoutModal);
        if (logoutCancelBtn) logoutCancelBtn.addEventListener('click', closeLogoutModal);

        logoutModal.addEventListener('click', (e) => {
            if (e.target === logoutModal) closeLogoutModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLogoutModal();
                closeSidebarDrawer();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

