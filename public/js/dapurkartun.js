/**
 * Dapur Kartun - Interactive Script Engine
 * Fully compliant with Anti-Slop (R-26, R-32, R-35)
 */

document.addEventListener('DOMContentLoaded', () => {
    initHeaderScroll();
    initMobileNav();
    initParallax();
    initHeroSlider();
    initGalleryFilter();
    initGalleryLightbox();
});

/* --------------------------------------------------------------------------
   1. STICKY HEADER & SCROLL SPY
   -------------------------------------------------------------------------- */
function initHeaderScroll() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const onScroll = () => {
        if (window.scrollY > 40) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Scroll spy for navigation
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-menu .nav-link, .mobile-drawer .nav-link');

    const updateActiveNav = () => {
        const scrollY = window.pageYOffset;

        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 120;
            const sectionId = current.getAttribute('id');

            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    if (link.getAttribute('href') === `#${sectionId}`) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
        });
    };

    window.addEventListener('scroll', updateActiveNav, { passive: true });
}

/* --------------------------------------------------------------------------
   2. MOBILE NAVIGATION DRAWER
   -------------------------------------------------------------------------- */
function initMobileNav() {
    const toggleBtn = document.querySelector('.mobile-toggle');
    const drawer = document.querySelector('.mobile-drawer');
    const overlay = document.querySelector('.mobile-drawer-overlay');
    const drawerLinks = document.querySelectorAll('.mobile-drawer .nav-link, .mobile-drawer .btn');

    if (!toggleBtn || !drawer || !overlay) return;

    const openDrawer = () => {
        toggleBtn.classList.add('active');
        drawer.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeDrawer = () => {
        toggleBtn.classList.remove('active');
        drawer.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    toggleBtn.addEventListener('click', () => {
        if (drawer.classList.contains('open')) {
            closeDrawer();
        } else {
            openDrawer();
        }
    });

    overlay.addEventListener('click', closeDrawer);

    drawerLinks.forEach(link => {
        link.addEventListener('click', closeDrawer);
    });

    // Close on Escape key (R-32)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer.classList.contains('open')) {
            closeDrawer();
        }
    });
}

/* --------------------------------------------------------------------------
   3. HERO PARALLAX ENGINE
   -------------------------------------------------------------------------- */
function initParallax() {
    // Respect prefers-reduced-motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const layers = document.querySelectorAll('.parallax-layer[data-speed]');
    if (!layers.length) return;

    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                // Only animate while hero is near viewport
                if (scrolled < window.innerHeight * 1.3) {
                    layers.forEach(layer => {
                        const speed = parseFloat(layer.getAttribute('data-speed')) || 0.2;
                        // Mobile devices get 50% gentler movement
                        const factor = window.innerWidth < 768 ? 0.4 : 1.0;
                        const yPos = -(scrolled * speed * factor);
                        layer.style.transform = `translate3d(0, ${yPos}px, 0)`;
                    });
                }
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}

/* --------------------------------------------------------------------------
   4. HERO SLIDER ENGINE
   -------------------------------------------------------------------------- */
function initHeroSlider() {
    const track = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.slide-item');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.querySelector('.btn-slide-prev');
    const nextBtn = document.querySelector('.btn-slide-next');

    if (!track || slides.length === 0) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    let autoSlideTimer = null;
    const intervalTime = 5500;

    const goToSlide = (index) => {
        if (index < 0) {
            index = totalSlides - 1;
        } else if (index >= totalSlides) {
            index = 0;
        }
        currentIndex = index;

        track.style.transform = `translateX(-${currentIndex * 100}%)`;

        dots.forEach((dot, idx) => {
            if (idx === currentIndex) {
                dot.classList.add('active');
                dot.setAttribute('aria-current', 'true');
            } else {
                dot.classList.remove('active');
                dot.removeAttribute('aria-current');
            }
        });
    };

    const nextSlide = () => goToSlide(currentIndex + 1);
    const prevSlide = () => goToSlide(currentIndex - 1);

    if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetTimer(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetTimer(); });

    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            goToSlide(idx);
            resetTimer();
        });
    });

    const startTimer = () => {
        autoSlideTimer = setInterval(nextSlide, intervalTime);
    };

    const resetTimer = () => {
        clearInterval(autoSlideTimer);
        startTimer();
    };

    // Pause on hover
    const sliderBox = document.querySelector('.hero-slider');
    if (sliderBox) {
        sliderBox.addEventListener('mouseenter', () => clearInterval(autoSlideTimer));
        sliderBox.addEventListener('mouseleave', () => startTimer());
    }

    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    track.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    const handleSwipe = () => {
        const threshold = 40;
        if (touchEndX < touchStartX - threshold) {
            nextSlide();
            resetTimer();
        } else if (touchEndX > touchStartX + threshold) {
            prevSlide();
            resetTimer();
        }
    };

    startTimer();
}

/* --------------------------------------------------------------------------
   5. GALLERY CATEGORY FILTER
   -------------------------------------------------------------------------- */
function initGalleryFilter() {
    const tabs = document.querySelectorAll('.cat-tab-btn');
    const items = document.querySelectorAll('.gallery-card');
    const emptyNotice = document.querySelector('.gallery-empty-state');

    if (!tabs.length || !items.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const selectedCat = tab.getAttribute('data-category');
            let visibleCount = 0;

            items.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                if (selectedCat === 'Semua' || itemCat === selectedCat) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (emptyNotice) {
                emptyNotice.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    });
}

/* --------------------------------------------------------------------------
   6. GALLERY LIGHTBOX MODAL (R-26, R-32)
   -------------------------------------------------------------------------- */
function initGalleryLightbox() {
    const modal = document.querySelector('.lightbox-modal');
    const closeBtn = document.querySelector('.lightbox-close-btn');
    const modalImg = document.querySelector('.lightbox-img');
    const modalTitle = document.querySelector('.lightbox-title');
    const modalCategory = document.querySelector('.lightbox-category');
    const modalDesc = document.querySelector('.lightbox-desc');
    const cards = document.querySelectorAll('.gallery-card');

    if (!modal || !cards.length) return;

    let previousActiveElement = null;

    const openModal = (card) => {
        previousActiveElement = document.activeElement;

        const img = card.querySelector('img');
        const title = card.querySelector('.gallery-card-title');
        const desc = card.querySelector('.gallery-card-desc');
        const category = card.getAttribute('data-category');

        if (modalImg && img) {
            modalImg.src = img.src;
            modalImg.alt = img.alt || 'Karya Dapur Kartun';
        }
        if (modalTitle && title) modalTitle.textContent = title.textContent;
        if (modalDesc && desc) modalDesc.textContent = desc.textContent;
        if (modalCategory) modalCategory.textContent = category;

        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        if (closeBtn) closeBtn.focus();
    };

    const closeModal = () => {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        if (previousActiveElement) {
            previousActiveElement.focus();
        }
    };

    cards.forEach(card => {
        card.addEventListener('click', () => openModal(card));
        // Keyboard activation with Enter
        card.setAttribute('tabindex', '0');
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openModal(card);
            }
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
}
