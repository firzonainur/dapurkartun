@extends('layouts.admin')

@section('title', 'Edit Testimoni')
@section('header_title', 'Perbarui Testimoni')

@section('content')
    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">Edit Testimoni: {{ $testimonial->customer_name }}</h3>
            <a href="{{ route('admin.testimonials.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="adm-form-group">
                <label for="customer_name" class="adm-label">Nama Pelanggan / Mitra <span style="color: var(--adm-danger);">*</span></label>
                <input type="text" name="customer_name" id="customer_name" class="adm-input" value="{{ old('customer_name', $testimonial->customer_name) }}" required>
                @error('customer_name') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="role" class="adm-label">Peran / Organisasi / Judul Proyek</label>
                <input type="text" name="role" id="role" class="adm-input" value="{{ old('role', $testimonial->role) }}">
                @error('role') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="adm-form-group">
                <label for="message" class="adm-label">Isi Ulasan Testimoni <span style="color: var(--adm-danger);">*</span></label>
                <textarea name="message" id="message" class="adm-textarea" rows="4" required>{{ old('message', $testimonial->message) }}</textarea>
                @error('message') <span class="adm-error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="rating" class="adm-label">Penilaian Bintang (1 - 5) <span style="color: var(--adm-danger);">*</span></label>
                    <select name="rating" id="rating" class="adm-select" required>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} Bintang
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="adm-form-group">
                    <label for="sort_order" class="adm-label">Urutan Tampil <span style="color: var(--adm-danger);">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" class="adm-input" value="{{ old('sort_order', $testimonial->sort_order) }}" min="0" required>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label class="adm-label">Avatar Saat Ini:</label>
                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem;">
                    <img src="{{ asset($testimonial->avatar ?? 'images/avatars/avatar-1.svg') }}" alt="" style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid var(--adm-border);">
                    <span style="font-size: 0.85rem; color: var(--adm-text-muted);">{{ $testimonial->avatar }}</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="adm-form-group">
                    <label for="avatar_file" class="adm-label">Ganti Berkas Avatar (Opsional)</label>
                    <input type="file" name="avatar_file" id="avatar_file" class="adm-input" accept="image/*">
                </div>

                <div class="adm-form-group">
                    <label for="avatar_url" class="adm-label">Atau Jalur Avatar Statis</label>
                    <input type="text" name="avatar_url" id="avatar_url" class="adm-input" value="{{ old('avatar_url', $testimonial->avatar) }}">
                </div>
            </div>

            <div class="adm-form-group" style="margin-top: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $testimonial->is_published) ? 'checked' : '' }}>
                    <span>Tampilkan Testimoni di Landing Page</span>
                </label>
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="adm-btn adm-btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="adm-btn adm-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
