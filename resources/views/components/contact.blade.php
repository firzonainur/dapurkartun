<section id="kontak" class="section contact-section" aria-label="Kontak dan Kolaborasi Dapur Kartun">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-tag">Ruang Kolaborasi</span>
            <h2>Punya Ide Menarik? Mari Kita Wujudkan!</h2>
            <p>Ceritakan ide cerita, konsep maskot, atau rencana serial animasi yang ingin kamu buat bersama tim Dapur Kartun.</p>
        </div>

        <div class="contact-layout">
            <!-- Left: Contact Details Card -->
            <div class="contact-info-card">
                <div>
                    <h3>Mari Berbincang</h3>
                    <p style="margin-top: 0.5rem;">Pintu dapur kreasi kami selalu terbuka untuk mendiskusikan gagasan visual terbaik.</p>
                </div>

                <ul class="contact-channel-list">
                    <li class="contact-channel-item">
                        <div class="channel-icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="channel-details">
                            <h5>WhatsApp Resmi</h5>
                            <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '6281234567890' }}?text=Halo%20Dapur%20Kartun,%20saya%20tertarik%20berdiskusi%20tentang%20proyek%20kreatif." target="_blank" rel="noopener noreferrer">
                                {{ $settings['contact_phone'] ?? '+62 812-3456-7890' }}
                            </a>
                        </div>
                    </li>

                    <li class="contact-channel-item">
                        <div class="channel-icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </div>
                        <div class="channel-details">
                            <h5>Email Surat</h5>
                            <a href="mailto:{{ $settings['contact_email'] ?? 'halo@dapurkartun.id' }}">
                                {{ $settings['contact_email'] ?? 'halo@dapurkartun.id' }}
                            </a>
                        </div>
                    </li>

                    <li class="contact-channel-item">
                        <div class="channel-icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="channel-details">
                            <h5>Studio Fisik</h5>
                            <span>{{ $settings['studio_address'] ?? 'Jl. Cerita Kreatif No. 42, Bandung, Jawa Barat' }}</span>
                        </div>
                    </li>
                </ul>

                <!-- Direct WhatsApp Fast Button -->
                <div style="margin-top: 1rem;">
                    <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '6281234567890' }}?text=Halo%20Dapur%20Kartun,%20saya%20ingin%20berkonsultasi%20mengenai%20proyek%20ilustrasi%20kartun." 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn btn-secondary" 
                       style="width: 100%;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                        Chat Langsung di WhatsApp
                    </a>
                </div>
            </div>

            <!-- Right: Working Contact Form -->
            <div class="contact-form-card">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error" role="alert">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" novalidate>
                    @csrf

                    <!-- Anti-spam Honeypot field (hidden from humans) -->
                    <div style="display: none;" aria-hidden="true">
                        <label for="website_trap">Tolong biarkan kolom ini kosong jika Anda manusia</label>
                        <input type="text" name="website_trap" id="website_trap" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap <span style="color: var(--c-orange);">*</span></label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-input @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" 
                            placeholder="Contoh: Rian Anggoro" 
                            required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email <span style="color: var(--c-orange);">*</span></label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-input @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" 
                                placeholder="nama@email.com" 
                                required>
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor WhatsApp</label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="phone" 
                                class="form-input @error('phone') is-invalid @enderror" 
                                value="{{ old('phone') }}" 
                                placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">Subjek atau Jenis Proyek</label>
                        <input 
                            type="text" 
                            name="subject" 
                            id="subject" 
                            class="form-input @error('subject') is-invalid @enderror" 
                            value="{{ old('subject') }}" 
                            placeholder="Contoh: Ilustrasi Buku Anak / Desain Maskot">
                        @error('subject')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Ceritakan Ide Anda <span style="color: var(--c-orange);">*</span></label>
                        <textarea 
                            name="message" 
                            id="message" 
                            class="form-textarea @error('message') is-invalid @enderror" 
                            placeholder="Tuliskan secara singkat konsep cerita, jumlah karakter, atau referensi gaya visual yang diinginkan..." 
                            required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
                        Kirim Pesan Kolaborasi
                    </button>

                    <p style="font-size: 0.8rem; color: var(--c-text-muted); text-align: center; margin-top: 0.75rem;">
                        * Pesan Anda tersimpan dengan aman ke database kami dan tim kami akan merespons dalam waktu 1x24 jam.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
