<section id="beranda" class="hero-section" aria-label="Hero Bagian Utama">
    <!-- Floating Parallax Layers -->
    <div class="parallax-layer layer-cloud-1" data-speed="0.25">
        <img src="{{ asset('images/hero/cloud-1.svg') }}" alt="" width="220" height="110" aria-hidden="true">
    </div>

    <div class="parallax-layer layer-cloud-2" data-speed="0.18">
        <img src="{{ asset('images/hero/cloud-2.svg') }}" alt="" width="190" height="95" aria-hidden="true">
    </div>

    <div class="parallax-layer layer-star-1" data-speed="0.45">
        <img src="{{ asset('images/hero/floating-stars.svg') }}" alt="" width="80" height="80" aria-hidden="true">
    </div>

    <div class="parallax-layer layer-star-2" data-speed="0.35">
        <img src="{{ asset('images/hero/floating-stars.svg') }}" alt="" width="60" height="60" aria-hidden="true">
    </div>

    <div class="parallax-layer layer-pencil" data-speed="0.55">
        <img src="{{ asset('images/hero/floating-pencil.svg') }}" alt="" width="100" height="100" aria-hidden="true">
    </div>

    <div class="container hero-slider">
        <div class="slider-container" role="region" aria-roledescription="carousel" aria-label="Slider Sorotan Dapur Kartun">
            <div class="slider-track">
                @forelse($slides as $index => $slide)
                    <div class="slide-item" role="group" aria-roledescription="slide" aria-label="Slide {{ $index + 1 }} dari {{ count($slides) }}">
                        <div class="slide-content">
                            <div class="slide-badge">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <span>Studio Kartun &amp; Karakter</span>
                            </div>

                            <h1 class="slide-title">
                                {{ $slide->title }}
                            </h1>

                            <p class="slide-subtitle">
                                {{ $slide->subtitle }}
                            </p>

                            <div class="slide-actions">
                                @if(!empty($slide->button_text))
                                    <a href="{{ $slide->button_url ?? '#galeri' }}" class="btn btn-primary">
                                        {{ $slide->button_text }}
                                    </a>
                                @endif
                                <a href="#tentang" class="btn btn-secondary">
                                    Kenali Kami
                                </a>
                            </div>
                        </div>

                        <div class="slide-visual">
                            <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" width="550" height="420" loading="eager">
                        </div>
                    </div>
                @empty
                    <!-- Fallback Slide if database is empty -->
                    <div class="slide-item">
                        <div class="slide-content">
                            <h1 class="slide-title">Selamat Datang di Dunia Dapur Kartun</h1>
                            <p class="slide-subtitle">Tempat ide kreatif diolah menjadi karya visual yang penuh warna, cerita, dan imajinasi.</p>
                            <div class="slide-actions">
                                <a href="#galeri" class="btn btn-primary">Jelajahi Karya</a>
                                <a href="#tentang" class="btn btn-secondary">Kenali Kami</a>
                            </div>
                        </div>
                        <div class="slide-visual">
                            <img src="{{ asset('images/slides/slide-1-dapur-imajinasi.svg') }}" alt="Ilustrasi Dapur Kartun">
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Slider Navigation Controls -->
        <div class="slider-controls">
            <!-- Indicator Dots -->
            <div class="slider-dots" role="tablist" aria-label="Pilih Slide">
                @foreach($slides as $idx => $s)
                    <button class="slider-dot {{ $idx === 0 ? 'active' : '' }}" role="tab" aria-label="Slide {{ $idx + 1 }}" data-slide="{{ $idx }}"></button>
                @endforeach
            </div>

            <!-- Arrows -->
            <div class="slider-arrows">
                <button class="slider-arrow-btn btn-slide-prev" aria-label="Slide Sebelumnya">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="slider-arrow-btn btn-slide-next" aria-label="Slide Berikutnya">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
