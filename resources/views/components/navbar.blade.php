<header class="site-header" role="banner">
    <div class="container header-inner">
        <!-- Logo -->
        <a href="#beranda" class="brand-logo" aria-label="Beranda {{ $settings['site_title'] ?? 'Dapur Kartun' }}">
            <img src="{{ asset($settings['site_logo'] ?? 'images/logo.svg') }}" alt="{{ $settings['site_title'] ?? 'Logo Dapur Kartun' }}" width="190" height="48" style="max-height: 48px; object-fit: contain;">
        </a>

        <!-- Desktop Navigation Menu -->
        <nav role="navigation" aria-label="Navigasi Utama">
            <ul class="nav-menu">
                <li><a href="#beranda" class="nav-link active">Home</a></li>
                <li><a href="#tentang" class="nav-link">Tentang Kami</a></li>
                <li><a href="#galeri" class="nav-link">Galeri</a></li>
                <li><a href="#testimoni" class="nav-link">Testimoni</a></li>
                <li><a href="#kontak" class="nav-link">Kontak</a></li>
            </ul>
        </nav>

        <!-- CTA & Mobile Toggle -->
        <div class="nav-actions">
            <a href="#kontak" class="btn btn-primary btn-sm btn-contact-header">
                Hubungi Kami
            </a>

            <!-- Mobile Hamburger Toggle -->
            <button class="mobile-toggle" aria-label="Buka Menu Navigasi" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Slide-out Drawer -->
<div class="mobile-drawer-overlay"></div>
<aside class="mobile-drawer" role="dialog" aria-modal="true" aria-label="Menu Mobile">
    <div class="mobile-drawer-brand">
        <img src="{{ asset($settings['site_logo'] ?? 'images/logo.svg') }}" alt="{{ $settings['site_title'] ?? 'Dapur Kartun' }}" width="160" height="40" style="max-height: 40px; object-fit: contain;">
    </div>

    <ul class="mobile-nav-list" style="list-style: none; display: flex; flex-direction: column; gap: 1.25rem;">
        <li><a href="#beranda" class="nav-link" style="font-size: 1.2rem;">Home</a></li>
        <li><a href="#tentang" class="nav-link" style="font-size: 1.2rem;">Tentang Kami</a></li>
        <li><a href="#galeri" class="nav-link" style="font-size: 1.2rem;">Galeri</a></li>
        <li><a href="#testimoni" class="nav-link" style="font-size: 1.2rem;">Testimoni</a></li>
        <li><a href="#kontak" class="nav-link" style="font-size: 1.2rem;">Kontak</a></li>
    </ul>
    <div style="margin-top: 1.5rem;">
        <a href="#kontak" class="btn btn-primary" style="width: 100%;">Hubungi Kami</a>
    </div>
</aside>
