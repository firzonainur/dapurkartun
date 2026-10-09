<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="#beranda">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Dapur Kartun" width="180" height="45" style="filter: brightness(0) invert(1);">
                </a>
                <p>
                    {{ $settings['site_tagline'] ?? 'Studio Ilustrasi & Animasi Penuh Cerita' }}. Tempat ide-ide segar diolah menjadi karya visual yang menyenangkan dan berkarakter.
                </p>
                <!-- Social Channels -->
                <div class="social-links" aria-label="Media Sosial Dapur Kartun">
                    @if(!empty($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                    @endif

                    @if(!empty($settings['youtube_url']))
                        <a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="YouTube">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                            </svg>
                        </a>
                    @endif

                    @if(!empty($settings['behance_url']))
                        <a href="{{ $settings['behance_url'] }}" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Behance Portfolio">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 8h5a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2H4z"></path>
                                <path d="M4 12h6a2.5 2.5 0 0 1 2.5 2.5v0a2.5 2.5 0 0 1-2.5 2.5H4z"></path>
                                <line x1="15" y1="9" x2="20" y2="9"></line>
                                <path d="M15 15a3 3 0 0 0 6 0v-1a3 3 0 0 0-3-3h-1a3 3 0 0 0-2 2v2z"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="footer-col">
                <h4>Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#galeri">Galeri Karya</a></li>
                    <li><a href="#testimoni">Ulasan Klien</a></li>
                    <li><a href="#kontak">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Creative Categories -->
            <div class="footer-col">
                <h4>Layanan Kreatif</h4>
                <ul class="footer-links">
                    <li><a href="#galeri">Ilustrasi Kartun Digital</a></li>
                    <li><a href="#galeri">Desain Karakter &amp; Maskot</a></li>
                    <li><a href="#galeri">Animasi 2D Pendek</a></li>
                    <li><a href="#galeri">Buku Cerita Anak Bergambar</a></li>
                    <li><a href="#galeri">Desain Kemasan Kreatif</a></li>
                </ul>
            </div>

            <!-- Studio Info -->
            <div class="footer-col">
                <h4>Kontak Studio</h4>
                <ul class="footer-links">
                    <li><span style="color: var(--c-text-light-muted);">{{ $settings['studio_address'] ?? 'Bandung, Jawa Barat' }}</span></li>
                    <li><a href="mailto:{{ $settings['contact_email'] ?? 'halo@dapurkartun.id' }}">{{ $settings['contact_email'] ?? 'halo@dapurkartun.id' }}</a></li>
                    <li><a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '6281234567890' }}" target="_blank" rel="noopener noreferrer">{{ $settings['contact_phone'] ?? '+62 812-3456-7890' }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Dapur Kartun Studio. Hak cipta dilindungi undang-undang.</p>
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                <a href="{{ route('admin.login') }}" style="color: rgba(255, 255, 255, 0.4); font-size: 0.75rem;" title="Akses Panel Admin">
                    Panel Admin
                </a>
            </div>
        </div>
    </div>
</footer>
