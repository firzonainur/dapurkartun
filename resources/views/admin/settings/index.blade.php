@extends('layouts.admin')

@section('title', 'Pengaturan Situs')
@section('header_title', 'Pengaturan & Informasi Studio')

@section('content')
    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Konfigurasi Identitas &amp; Kontak Dapur Kartun</h3>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <h4 style="font-size: 1.1rem; color: var(--adm-primary); margin-bottom: 1rem; border-bottom: 1px solid var(--adm-border); padding-bottom: 0.5rem;">
                1. Identitas Brand &amp; Website
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="site_title" class="adm-label">Nama Website / Brand <span style="color: var(--adm-danger);">*</span></label>
                    <input type="text" name="site_title" id="site_title" class="adm-input" value="{{ old('site_title', $settings['site_title'] ?? 'Dapur Kartun') }}" required>
                </div>

                <div class="adm-form-group">
                    <label for="site_tagline" class="adm-label">Tagline Brand</label>
                    <input type="text" name="site_tagline" id="site_tagline" class="adm-input" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Studio Ilustrasi dan Animasi Penuh Cerita') }}">
                </div>
            </div>

            <h4 style="font-size: 1.1rem; color: var(--adm-primary); margin: 1.5rem 0 1rem; border-bottom: 1px solid var(--adm-border); padding-bottom: 0.5rem;">
                2. Kontak Resmi Studio
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

            <h4 style="font-size: 1.1rem; color: var(--adm-primary); margin: 1.5rem 0 1rem; border-bottom: 1px solid var(--adm-border); padding-bottom: 0.5rem;">
                3. Tautan Media Sosial
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="instagram_url" class="adm-label">Instagram URL</label>
                    <input type="url" name="instagram_url" id="instagram_url" class="adm-input" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                </div>

                <div class="adm-form-group">
                    <label for="youtube_url" class="adm-label">YouTube URL</label>
                    <input type="url" name="youtube_url" id="youtube_url" class="adm-input" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}">
                </div>

                <div class="adm-form-group">
                    <label for="behance_url" class="adm-label">Behance URL</label>
                    <input type="url" name="behance_url" id="behance_url" class="adm-input" value="{{ old('behance_url', $settings['behance_url'] ?? '') }}">
                </div>
            </div>

            <h4 style="font-size: 1.1rem; color: var(--adm-primary); margin: 1.5rem 0 1rem; border-bottom: 1px solid var(--adm-border); padding-bottom: 0.5rem;">
                4. Konten Bagian Tentang Kami &amp; Metrik
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
                <button type="submit" class="adm-btn adm-btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem;">
                    Simpan Semua Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
