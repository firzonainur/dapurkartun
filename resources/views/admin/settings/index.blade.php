@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('header_title', 'Pengaturan Identitas & Informasi Studio')

@section('content')
    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Konfigurasi Pengaturan Dapur Kartun</h3>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Identitas Brand & Visual Assets -->
            <h4 style="font-size: 1.1rem; color: #1F1135; font-weight: 800; margin-bottom: 1rem; border-bottom: 2px solid var(--adm-border); padding-bottom: 0.5rem;">
                1. Identitas Brand &amp; Aset Logo
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
                <!-- Logo File Upload & Preview -->
                <div class="adm-form-group">
                    <label class="adm-label">Logo Website</label>
                    <div style="background: #F8FAFC; border: 1px dashed var(--adm-border); border-radius: 8px; padding: 1rem; text-align: center; margin-bottom: 0.75rem;">
                        <img id="logoPreview" src="{{ asset($settings['site_logo'] ?? 'images/logo.svg') }}" alt="Logo Saat Ini" style="max-height: 50px; object-fit: contain;">
                    </div>
                    <input type="file" name="logo_file" id="logo_file" class="adm-input" accept="image/*" onchange="previewLogoFile(this)">
                    <small style="color: var(--adm-text-muted);">Format SVG/PNG/JPG/WebP, maksimal 2MB.</small>
                    @error('logo_file') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>

                <!-- Favicon Upload & Preview -->
                <div class="adm-form-group">
                    <label class="adm-label">Favicon Website</label>
                    <div style="background: #F8FAFC; border: 1px dashed var(--adm-border); border-radius: 8px; padding: 1rem; text-align: center; margin-bottom: 0.75rem;">
                        <img id="faviconPreview" src="{{ asset($settings['site_favicon'] ?? 'images/logo.svg') }}" alt="Favicon Saat Ini" style="width: 36px; height: 36px; object-fit: contain;">
                    </div>
                    <input type="file" name="favicon_file" id="favicon_file" class="adm-input" accept="image/*,.ico" onchange="previewFaviconFile(this)">
                    <small style="color: var(--adm-text-muted);">Format ICO/PNG/SVG, maksimal 1MB.</small>
                    @error('favicon_file') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="site_title" class="adm-label">Nama Website / Brand <span style="color: var(--adm-danger);">*</span></label>
                    <input type="text" name="site_title" id="site_title" class="adm-input" value="{{ old('site_title', $settings['site_title'] ?? 'Dapur Kartun') }}" required>
                    @error('site_title') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="adm-form-group">
                    <label for="site_tagline" class="adm-label">Tagline Brand / Deskripsi Singkat</label>
                    <input type="text" name="site_tagline" id="site_tagline" class="adm-input" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Studio Ilustrasi dan Animasi Penuh Cerita') }}">
                </div>
            </div>

            <!-- 2. Pengaturan SEO Meta -->
            <h4 style="font-size: 1.1rem; color: #1F1135; font-weight: 800; margin: 1.5rem 0 1rem; border-bottom: 2px solid var(--adm-border); padding-bottom: 0.5rem;">
                2. Pengaturan SEO (Meta Title &amp; Description)
            </h4>

            <div class="adm-form-group">
                <label for="meta_title" class="adm-label">Meta Title (Judul Tab &amp; Hasil Pencarian)</label>
                <input type="text" name="meta_title" id="meta_title" class="adm-input" value="{{ old('meta_title', $settings['meta_title'] ?? 'Dapur Kartun - Studio Ilustrasi dan Animasi Penuh Cerita') }}" placeholder="Contoh: Dapur Kartun - Studio Ilustrasi dan Animasi Penuh Cerita">
                @error('meta_title') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="meta_description" class="adm-label">Meta Description (Ringkasan di Mesin Pencari)</label>
                <textarea name="meta_description" id="meta_description" class="adm-textarea" rows="2" placeholder="Deskripsi ringkas yang tampil di Google atau pratinjau tautan media sosial...">{{ old('meta_description', $settings['meta_description'] ?? 'Dapur Kartun adalah studio visual kreatif yang mengolah ide menjadi ilustrasi kartun, karakter orisinal, dan animasi bercerita.') }}</textarea>
                @error('meta_description') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- 3. Kontak Resmi Studio -->
            <h4 style="font-size: 1.1rem; color: #1F1135; font-weight: 800; margin: 1.5rem 0 1rem; border-bottom: 2px solid var(--adm-border); padding-bottom: 0.5rem;">
                3. Kontak Resmi &amp; Footer Studio
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="contact_email" class="adm-label">Email Kontak <span style="color: var(--adm-danger);">*</span></label>
                    <input type="email" name="contact_email" id="contact_email" class="adm-input" value="{{ old('contact_email', $settings['contact_email'] ?? 'halo@dapurkartun.id') }}" required>
                </div>

                <div class="adm-form-group">
                    <label for="whatsapp_number" class="adm-label">Nomor WhatsApp (Format: 628xxx) <span style="color: var(--adm-danger);">*</span></label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="adm-input" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '6281234567890') }}" required>
                </div>

                <div class="adm-form-group">
                    <label for="contact_phone" class="adm-label">Teks Tampilan Telepon</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="adm-input" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+62 812-3456-7890') }}">
                </div>

                <div class="adm-form-group">
                    <label for="studio_address" class="adm-label">Alamat Studio</label>
                    <input type="text" name="studio_address" id="studio_address" class="adm-input" value="{{ old('studio_address', $settings['studio_address'] ?? 'Jl. Cerita Kreatif No. 42, Bandung, Jawa Barat') }}">
                </div>
            </div>

            <div class="adm-form-group">
                <label for="footer_info" class="adm-label">Informasi Footer / Hak Cipta</label>
                <textarea name="footer_info" id="footer_info" class="adm-textarea" rows="2" placeholder="Hak cipta dilindungi undang-undang. Studio ilustrasi & animasi independen.">{{ old('footer_info', $settings['footer_info'] ?? 'Hak cipta dilindungi undang-undang. Karya ilustrasi dan animasi orisinal.') }}</textarea>
            </div>

            <!-- 4. Media Sosial -->
            <h4 style="font-size: 1.1rem; color: #1F1135; font-weight: 800; margin: 1.5rem 0 1rem; border-bottom: 2px solid var(--adm-border); padding-bottom: 0.5rem;">
                4. Tautan Media Sosial
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="instagram_url" class="adm-label">Instagram URL</label>
                    <input type="url" name="instagram_url" id="instagram_url" class="adm-input" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/...">
                </div>

                <div class="adm-form-group">
                    <label for="youtube_url" class="adm-label">YouTube URL</label>
                    <input type="url" name="youtube_url" id="youtube_url" class="adm-input" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/...">
                </div>

                <div class="adm-form-group">
                    <label for="behance_url" class="adm-label">Behance URL</label>
                    <input type="url" name="behance_url" id="behance_url" class="adm-input" value="{{ old('behance_url', $settings['behance_url'] ?? '') }}" placeholder="https://behance.net/...">
                </div>
            </div>

            <!-- 5. Konten Tentang Kami & Metrik -->
            <h4 style="font-size: 1.1rem; color: #1F1135; font-weight: 800; margin: 1.5rem 0 1rem; border-bottom: 2px solid var(--adm-border); padding-bottom: 0.5rem;">
                5. Konten Bagian Tentang Kami &amp; Metrik
            </h4>

            <div class="adm-form-group">
                <label for="about_title" class="adm-label">Judul Tentang Kami</label>
                <input type="text" name="about_title" id="about_title" class="adm-input" value="{{ old('about_title', $settings['about_title'] ?? 'Kreativitas Penuh Cerita') }}">
            </div>

            <div class="adm-form-group">
                <label for="about_story" class="adm-label">Kisah &amp; Filosofi Studio</label>
                <textarea name="about_story" id="about_story" class="adm-textarea" rows="4">{{ old('about_story', $settings['about_story'] ?? '') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="stat_illustrations" class="adm-label">Metrik Ilustrasi</label>
                    <input type="text" name="stat_illustrations" id="stat_illustrations" class="adm-input" value="{{ old('stat_illustrations', $settings['stat_illustrations'] ?? '450+ Karya (Data Contoh)') }}">
                </div>

                <div class="adm-form-group">
                    <label for="stat_characters" class="adm-label">Metrik Karakter</label>
                    <input type="text" name="stat_characters" id="stat_characters" class="adm-input" value="{{ old('stat_characters', $settings['stat_characters'] ?? '120+ Karakter (Data Contoh)') }}">
                </div>

                <div class="adm-form-group">
                    <label for="stat_animations" class="adm-label">Metrik Animasi</label>
                    <input type="text" name="stat_animations" id="stat_animations" class="adm-input" value="{{ old('stat_animations', $settings['stat_animations'] ?? '35+ Serial (Data Contoh)') }}">
                </div>

                <div class="adm-form-group">
                    <label for="stat_creators" class="adm-label">Metrik Tim Artis</label>
                    <input type="text" name="stat_creators" id="stat_creators" class="adm-input" value="{{ old('stat_creators', $settings['stat_creators'] ?? '8 Artis (Data Contoh)') }}">
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="padding: 0.8rem 2.5rem; font-size: 1rem;">
                    Simpan Semua Pengaturan
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewLogoFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFaviconFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('faviconPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

