@extends('layouts.admin')

@section('title', 'Tambah Testimoni')
@section('header_title', 'Tambah Testimoni Baru')

@section('content')
    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Formulir Testimoni Baru</h3>
            <a href="{{ route('admin.testimonials.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="adm-form-group">
                <label for="customer_name" class="adm-label">Nama Pelanggan / Mitra <span style="color: var(--adm-danger);">*</span></label>
                <input type="text" name="customer_name" id="customer_name" class="adm-input" value="{{ old('customer_name') }}" placeholder="Contoh: Budi Wicaksono" required>
                @error('customer_name') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="role" class="adm-label">Peran / Organisasi / Judul Proyek</label>
                <input type="text" name="role" id="role" class="adm-input" value="{{ old('role') }}" placeholder="Contoh: Penerbit Buku Anak Mentari (Data Contoh)">
                @error('role') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="message" class="adm-label">Isi Ulasan Testimoni <span style="color: var(--adm-danger);">*</span></label>
                <textarea name="message" id="message" class="adm-textarea" rows="4" placeholder="Tuliskan pengalaman atau tanggapan terkait hasil karya..." required>{{ old('message') }}</textarea>
                @error('message') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="rating" class="adm-label">Penilaian Bintang (1 - 5) <span style="color: var(--adm-danger);">*</span></label>
                    <select name="rating" id="rating" class="adm-select" required>
                        <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Bintang (Sempurna)</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Bintang (Sangat Baik)</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Bintang (Cukup)</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Bintang</option>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Bintang</option>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="sort_order" class="adm-label">Urutan Tampil <span style="color: var(--adm-danger);">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" class="adm-input" value="{{ old('sort_order', 1) }}" min="0" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="avatar_file" class="adm-label">Unggah Foto / Avatar (Opsional)</label>
                    <input type="file" name="avatar_file" id="avatar_file" class="adm-input" accept="image/*">
                </div>

                <div class="adm-form-group">
                    <label for="avatar_url" class="adm-label">Atau Gunakan Avatar Kartun Default</label>
                    <input type="text" name="avatar_url" id="avatar_url" class="adm-input" value="{{ old('avatar_url', 'images/avatars/avatar-1.svg') }}">
                </div>
            </div>

            <div class="adm-form-group" style="margin-top: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                    <span>Tampilkan Testimoni di Landing Page</span>
                </label>
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="adm-btn adm-btn-primary">
                    Simpan Testimoni
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="adm-btn adm-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
