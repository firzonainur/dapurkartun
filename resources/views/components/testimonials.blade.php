<section id="testimoni" class="section testimonials-section" aria-label="Testimoni Sahabat Dapur Kartun">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-tag">Kata Sahabat</span>
            <h2>Cerita Kolaborasi Bersama Kami</h2>
            <p>Pengalaman para kreator, penerbit, dan jenama yang telah mempercayakan dunia visual karakternya kepada Dapur Kartun.</p>
        </div>

        <!-- Testimonials Cards Grid -->
        <div class="testimonials-grid">
            @forelse($testimonials as $testi)
                <div class="testimonial-card">
                    <div>
                        <!-- Rating Stars -->
                        <div class="testimonial-rating" aria-label="Rating {{ $testi->rating }} dari 5 bintang">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $i <= $testi->rating ? '#FFC107' : '#E2E8F0' }}" stroke="#1F1135" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            @endfor
                        </div>

                        <!-- Quote Message -->
                        <p class="testimonial-quote">
                            {{ $testi->message }}
                        </p>
                    </div>

                    <!-- Author Info -->
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset($testi->avatar ?? 'images/avatars/avatar-1.svg') }}" alt="Avatar {{ $testi->customer_name }}" width="52" height="52" loading="lazy">
                        </div>
                        <div class="author-info">
                            <h4>{{ $testi->customer_name }}</h4>
                            <p>{{ $testi->role }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State (R-27) -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
                    <p style="color: var(--c-text-muted);">Belum ada ulasan yang ditampilkan saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
