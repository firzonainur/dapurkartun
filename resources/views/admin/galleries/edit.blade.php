@extends('layouts.admin')

@section('title', 'Edit Karya Galeri')
@section('header_title', 'Perbarui Karya Galeri')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Edit Karya: {{ $gallery->title }}</h3>
            <a href="{{ route('admin.galleries.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="adm-form-group">
                <label for="title" class="adm-label">Judul Karya <span style="color: var(--adm-danger);">*</span></label>
                <input type="text" name="title" id="title" class="adm-input" value="{{ old('title', $gallery->title) }}" required>
                @error('title') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="category" class="adm-label">Pilih Kategori Yang Ada</label>
                    <select name="category" id="category" class="adm-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $gallery->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="new_category" class="adm-label">Atau Ubah / Tambah Kategori Baru</label>
                    <input type="text" name="new_category" id="new_category" class="adm-input" value="{{ old('new_category') }}" placeholder="Contoh: Komik Strip, Stiker WhatsApp">
                    <small style="color: var(--adm-text-muted);">Jika diisi, kategori ini yang akan dipakai.</small>
                    @error('new_category') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="adm-form-group">
                <label for="description" class="adm-label">Deskripsi / Konsep Karya</label>
                <textarea name="description" id="description" class="adm-textarea" rows="3">{{ old('description', $gallery->description) }}</textarea>
                @error('description') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="adm-label">Pratinjau Gambar Karya:</label>
                <div style="background: #F8FAFC; border: 1px dashed var(--adm-border); border-radius: 8px; padding: 1rem; text-align: center; margin-top: 0.5rem;">
                    <img id="imagePreview" src="{{ asset($gallery->image) }}" alt="Pratinjau Karya" style="max-height: 160px; border-radius: 8px; object-fit: contain;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="image_file" class="adm-label">Ganti Berkas Gambar (Opsional)</label>
                    <input type="file" name="image_file" id="image_file" class="adm-input" accept="image/*" onchange="previewGalleryImage(this)">
                    <small style="color: var(--adm-text-muted);">Maksimal 4MB (SVG/PNG/JPG/WebP)</small>
                    @error('image_file') <span class="adm-error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="adm-form-group">
                    <label for="image_url" class="adm-label">Atau Jalur Gambar Statis</label>
                    <input type="text" name="image_url" id="image_url" class="adm-input" value="{{ old('image_url', $gallery->image) }}" oninput="previewGalleryUrl(this.value)">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="sort_order" class="adm-label">Nomor Urutan Tampil <span style="color: var(--adm-danger);">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" class="adm-input" value="{{ old('sort_order', $gallery->sort_order) }}" min="0" required>
                </div>

                <div class="adm-form-group" style="display: flex; align-items: center; margin-top: 1.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $gallery->is_published) ? 'checked' : '' }}>
                        <span>Publikasikan Karya di Website</span>
                    </label>
                </div>
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="adm-btn adm-btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.galleries.index') }}" class="adm-btn adm-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewGalleryImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function previewGalleryUrl(url) {
            if (url) {
                document.getElementById('imagePreview').src = '/' + url.replace(/^\//, '');
            }
        }
    </script>
@endsection

