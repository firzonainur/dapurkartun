<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $news = $this->route('news');
        $newsId = is_object($news) ? $news->id : $news;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('news', 'slug')->ignore($newsId)],
            'category_id' => ['nullable', 'exists:news_categories,id'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'thumbnail_url' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,scheduled'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['nullable', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul artikel maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan oleh artikel lain.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'excerpt.required' => 'Ringkasan artikel wajib diisi untuk kartu berita.',
            'excerpt.max' => 'Ringkasan artikel maksimal 500 karakter.',
            'content.required' => 'Isi artikel tidak boleh kosong.',
            'thumbnail_file.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail_file.mimes' => 'Format gambar harus JPEG, PNG, JPG, WebP, atau SVG.',
            'thumbnail_file.max' => 'Ukuran gambar thumbnail maksimal 4MB.',
            'status.required' => 'Status artikel wajib dipilih.',
            'status.in' => 'Status artikel harus bernilai Draft, Terbit, atau Terjadwal.',
            'published_at.date' => 'Format tanggal publikasi tidak valid.',
        ];
    }
}
