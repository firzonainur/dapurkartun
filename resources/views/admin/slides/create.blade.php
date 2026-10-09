@extends('layouts.admin')

@section('title', 'Tambah Slide Baru')
@section('header_title', 'Tambah Slide Hero')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Formulir Slide Baru</h3>
            <a href="{{ route('admin.slides.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="adm-form-group">
                <label for="title" class="adm-label">Judul Utama Slide <span style="color: var(--adm-danger);">*</span></label>
                <input type="text" name="title" id="title" class="adm-input" value="{{ old('title') }}" placeholder="Contoh: Selamat Datang di Dunia Dapur Kartun" required>
                @error('title') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="subtitle" class="adm-label">Subjudul / Deskripsi Singkat</label>
                <textarea name="subtitle" id="subtitle" class="adm-textarea" rows="3" placeholder="Contoh: Tempat ide kreatif diolah menjadi karya visual yang penuh warna, cerita, dan imajinasi.">{{ old('subtitle') }}</textarea>
                @error('subtitle') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="image_file" class="adm-label">Unggah Berkas Gambar / Ilustrasi (SVG/PNG/JPG/WebP)</label>
                    <input type="file" name="image_file" id="image_file" class="adm-input" accept="image/*">
                    <small style="color: var(--adm-text-muted);">Maksimal ukuran 3MB</small>
                    @error('image_file') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="adm-form-group">
                    <label for="image_url" class="adm-label">Atau Gunakan Jalur Gambar Statis</label>
                    <input type="text" name="image_url" id="image_url" class="adm-input" value="{{ old('image_url', 'images/slides/slide-1-dapur-imajinasi.svg') }}" placeholder="images/slides/...">
                    <small style="color: var(--adm-text-muted);">Gunakan jika memakai aset SVG bawaan</small>
                    @error('image_url') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="button_text" class="adm-label">Teks Tombol Aksi (CTA)</label>
                    <input type="text" name="button_text" id="button_text" class="adm-input" value="{{ old('button_text', 'Jelajahi Karya') }}" placeholder="Contoh: Jelajahi Karya">
                </div>

                <div class="adm-form-group">
                    <label for="button_url" class="adm-label">Tautan Tombol</label>
                    <input type="text" name="button_url" id="button_url" class="adm-input" value="{{ old('button_url', '#galeri') }}" placeholder="Contoh: #galeri atau https://...">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="sort_order" class="adm-label">Nomor Urutan Tampil <span style="color: var(--adm-danger);">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" class="adm-input" value="{{ old('sort_order', 1) }}" min="0" required>
                </div>

                <div class="adm-form-group" style="display: flex; align-items: center; margin-top: 1.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span>Aktifkan Slide di Website</span>
                    </label>
                </div>
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="adm-btn adm-btn-primary">
                    Simpan Slide
                </button>
                <a href="{{ route('admin.slides.index') }}" class="adm-btn adm-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
