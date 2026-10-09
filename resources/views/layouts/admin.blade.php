<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') - Dapur Kartun</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar" role="navigation" aria-label="Menu Admin">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset('images/logo.svg') }}" alt="Dapur Kartun" width="160" height="40" style="filter: brightness(0) invert(1);">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span>📊</span>
                            <span>Dashboard</span>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.slides.index') }}" class="sidebar-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span>🖼️</span>
                            <span>Kelola Slider</span>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.galleries.index') }}" class="sidebar-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span>🎨</span>
                            <span>Kelola Galeri</span>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span>💬</span>
                            <span>Kelola Testimoni</span>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span>📬</span>
                            <span>Pesan Masuk</span>
                        </span>
                        @php
                            $unreadTotal = \App\Models\Contact::where('is_read', false)->count();
                        @endphp
                        @if($unreadTotal > 0)
                            <span class="badge-counter">{{ $unreadTotal }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="sidebar-link-content">
                            <span>⚙️</span>
                            <span>Pengaturan Situs</span>
                        </span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link" style="color: #94A3B8;">
                    <span class="sidebar-link-content">
                        <span>🌐</span>
                        <span>Lihat Website</span>
                    </span>
                    <span>↗</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Topbar Header -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <h2>@yield('header_title', 'Panel Admin Dapur Kartun')</h2>
                </div>

                <div class="topbar-right">
                    <div class="user-badge">
                        <div class="user-avatar-circle">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="adm-btn adm-btn-secondary adm-btn-sm" title="Keluar dari Panel Admin">
                            Keluar
                        </button>
                    </form>
                </div>
            </header>

            <!-- Body Content -->
            <div class="admin-body">
                @if(session('success'))
                    <div style="background-color: #DCFCE7; color: #166534; padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #BBF7D0;">
                        <span>✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div style="background-color: #FEE2E2; color: #991B1B; padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; border: 1px solid #FECACA;">
                        <span>⚠</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
