@extends('layouts.admin')

@section('title', 'Edit Slide')
@section('header_title', 'Perbarui Slide Hero')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Edit Slide: {{ $slide->title }}</h3>
            <a href="{{ route('admin.slides.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="adm-form-group">
                <label for="title" class="adm-label">Judul Utama Slide <span style="color: var(--adm-danger);">*</span></label>
                <input type="text" name="title" id="title" class="adm-input" value="{{ old('title', $slide->title) }}" required>
                @error('title') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="subtitle" class="adm-label">Subjudul / Deskripsi Singkat</label>
                <textarea name="subtitle" id="subtitle" class="adm-textarea" rows="3">{{ old('subtitle', $slide->subtitle) }}</textarea>
                @error('subtitle') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="adm-label">Pratinjau Gambar Saat Ini:</label>
                <div style="background: #F8FAFC; border: 1px dashed var(--adm-border); border-radius: 8px; padding: 1rem; text-align: center; margin-top: 0.5rem;">
                    <img id="imagePreview" src="{{ asset($slide->image) }}" alt="Pratinjau Slide" style="max-height: 140px; border-radius: 8px; object-fit: contain;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="image_file" class="adm-label">Ganti Berkas Gambar (Opsional)</label>
                    <input type="file" name="image_file" id="image_file" class="adm-input" accept="image/*" onchange="previewSlideImage(this)">
                    <small style="color: var(--adm-text-muted);">Maksimal 3MB (SVG/PNG/JPG/WebP)</small>
                    @error('image_file') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="adm-form-group">
                    <label for="image_url" class="adm-label">Atau Jalur Gambar Statis</label>
                    <input type="text" name="image_url" id="image_url" class="adm-input" value="{{ old('image_url', $slide->image) }}" oninput="previewStaticUrl(this.value)">
                </div>
            </div>


            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="button_text" class="adm-label">Teks Tombol Aksi</label>
                    <input type="text" name="button_text" id="button_text" class="adm-input" value="{{ old('button_text', $slide->button_text) }}">
                </div>

                <div class="adm-form-group">
                    <label for="button_url" class="adm-label">Tautan Tombol</label>
                    <input type="text" name="button_url" id="button_url" class="adm-input" value="{{ old('button_url', $slide->button_url) }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="sort_order" class="adm-label">Urutan Tampil <span style="color: var(--adm-danger);">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" class="adm-input" value="{{ old('sort_order', $slide->sort_order) }}" min="0" required>
                </div>

                <div class="adm-form-group" style="display: flex; align-items: center; margin-top: 1.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active) ? 'checked' : '' }}>
                        <span>Aktifkan Slide di Website</span>
                    </label>
                </div>
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="adm-btn adm-btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.slides.index') }}" class="adm-btn adm-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewSlideImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function previewStaticUrl(url) {
            if (url) {
                document.getElementById('imagePreview').src = '/' + url.replace(/^\//, '');
            }
        }
    </script>
@endsection

