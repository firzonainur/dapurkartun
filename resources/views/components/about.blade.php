<section id="tentang" class="section about-section" aria-label="Tentang Dapur Kartun">
    <div class="container">
        <div class="about-grid">
            <!-- Visual Mascot Storyteller Card -->
            <div class="about-visual">
                <div class="about-visual-card">
                    <span class="about-tag">Filosofi Kreasi</span>
                    <img src="{{ asset('images/about/mascot-storyteller.svg') }}" alt="Maskot Dapur Kartun Membaca Buku Dongeng" width="440" height="440" loading="lazy">
                </div>
            </div>

            <!-- Narrative Content -->
            <div class="about-content">
                <div>
                    <span class="slide-badge" style="margin-bottom: 0.75rem;">
                        Cerita Studio
                    </span>
                    <h2>{{ $settings['about_title'] ?? 'Kreativitas Penuh Cerita' }}</h2>
                </div>

                <p class="about-text">
                    {{ $settings['about_story'] ?? 'Dapur Kartun adalah studio visual independen tempat ide-ide segar diolah menjadi ilustrasi kartun, karakter orisinal, dan animasi bercerita. Kami menggabungkan keterampilan sketsa manual dengan kehangatan warna digital untuk menciptakan karya yang hidup, berkarakter, dan ramah untuk segala usia.' }}
                </p>

                <p class="about-text">
                    Setiap karakter kartun yang kami lahirkan memiliki latar belakang emosi, keunikan kepribadian, dan cerita visual tersendiri, siap menemani buku anak, kampanye edukasi, hingga identitas maskot jenama Anda.
                </p>

                <!-- Dynamic Highlight Stats from Database -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $settings['stat_illustrations'] ?? '450+ Karya (Data Contoh)' }}</div>
                        <div class="stat-label">Ilustrasi Dihasilkan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">{{ $settings['stat_characters'] ?? '120+ Karakter (Data Contoh)' }}</div>
                        <div class="stat-label">Karakter Maskot Unik</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">{{ $settings['stat_animations'] ?? '35+ Serial (Data Contoh)' }}</div>
                        <div class="stat-label">Proyek Animasi 2D</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">{{ $settings['stat_creators'] ?? '8 Artis (Data Contoh)' }}</div>
                        <div class="stat-label">Kreator &amp; Animator</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
