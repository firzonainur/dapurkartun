<section id="galeri" class="section gallery-section" aria-label="Galeri Portofolio Dapur Kartun">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-tag">Katalog Visual</span>
            <h2>Galeri Karya &amp; Karakter</h2>
            <p>Jelajahi koleksi ilustrasi kartun, eksplorasi maskot, dan animasi visual yang telah kami lahirkan bersama para kolaborator.</p>
        </div>

        <!-- Category Filter Tabs -->
        <div class="category-tabs" role="tablist" aria-label="Filter Kategori Galeri">
            @foreach($categories as $cat)
                <button 
                    class="cat-tab-btn {{ $loop->first ? 'active' : '' }}" 
                    role="tab" 
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    data-category="{{ $cat }}">
                    {{ $cat }}
                </button>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid">
            @forelse($galleries as $artwork)
                <article 
                    class="gallery-card" 
                    data-category="{{ $artwork->category }}" 
                    role="button" 
                    aria-label="Lihat karya: {{ $artwork->title }}">
                    
                    <div class="gallery-img-wrap">
                        <img 
                            src="{{ asset($artwork->image) }}" 
                            alt="{{ $artwork->title }}" 
                            width="400" 
                            height="300" 
                            loading="lazy">
                        
                        <div class="gallery-overlay">
                            <span class="gallery-overlay-badge">{{ $artwork->category }}</span>
                        </div>
                    </div>

                    <div class="gallery-card-body">
                        <h3 class="gallery-card-title">{{ $artwork->title }}</h3>
                        @if(!empty($artwork->description))
                            <p class="gallery-card-desc">{{ $artwork->description }}</p>
                        @endif
                    </div>
                </article>
            @empty
                <!-- Empty State (R-27) -->
                <div class="gallery-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎨</div>
                    <h3>Belum Ada Karya yang Dipublikasikan</h3>
                    <p>Karya baru sedang diramu di dapur kreatif kami. Silakan kembali lagi nanti!</p>
                </div>
            @endforelse
        </div>

        <!-- Filter Empty Notice -->
        <div class="gallery-empty-state" style="display: none; text-align: center; padding: 3rem 1rem;">
            <p style="font-weight: 700; color: var(--c-text-muted);">Tidak ada karya ditemukan pada kategori ini.</p>
        </div>

        <!-- Bottom Action CTA -->
        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="#kontak" class="btn btn-primary">
                Tertarik Kolaborasi Karya Serupa?
            </a>
        </div>
    </div>
</section>

<!-- Lightbox Modal (R-26, R-32) -->
<div class="lightbox-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Pratinjau Karya Detail">
    <div class="lightbox-dialog">
        <button class="lightbox-close-btn" aria-label="Tutup Pratinjau (Escape)">&times;</button>
        
        <div class="lightbox-image-wrap">
            <img class="lightbox-img" src="" alt="Pratinjau Karya">
        </div>

        <div class="lightbox-info">
            <span class="lightbox-category badge-counter" style="align-self: flex-start; padding: 0.3rem 0.8rem; font-size: 0.8rem;"></span>
            <h3 class="lightbox-title" style="font-size: 1.5rem; color: var(--c-midnight);"></h3>
            <p class="lightbox-desc" style="color: var(--c-text-muted); font-size: 1rem; line-height: 1.6;"></p>
        </div>
    </div>
</div>
