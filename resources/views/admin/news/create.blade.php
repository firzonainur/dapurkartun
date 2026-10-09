@extends('layouts.admin')

@section('title', 'Tambah Artikel Berita')
@section('header_title', 'Tulis Artikel Berita Baru')

@section('content')
    <div class="card" style="max-width: 1040px; margin: 0 auto;">
        <div class="card-header" style="justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 class="card-title">Formulir Artikel Baru</h3>
                <p style="font-size: 0.875rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                    Tulis dan terbitkan berita, cerita karya, atau inspirasi untuk pembaca Dapur Kartun.
                </p>
            </div>
            <a href="{{ route('admin.news.index') }}" class="adm-btn adm-btn-secondary">
                &larr; Kembali ke Daftar
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                <strong style="display: block; margin-bottom: 0.5rem;">Mohon periksa kesalahan input berikut:</strong>
                <ul style="padding-left: 1.25rem; font-size: 0.9rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
            @csrf

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <!-- Kolom Kiri: Konten Utama -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- 1. Judul Artikel -->
                    <div>
                        <label for="title" class="adm-label" style="font-weight: 700;">
                            Judul Artikel <span style="color: var(--adm-danger);">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="adm-input @error('title') is-invalid @enderror" 
                            value="{{ old('title') }}" 
                            placeholder="Contoh: Mengintip Dapur Ide di Balik Karakter Orisinal" 
                            maxlength="255" 
                            required
                        >
                    </div>

                    <!-- 2. Slug -->
                    <div>
                        <label for="slug" class="adm-label">
                            Slug URL (Otomatis dibuat dari judul, dapat disesuaikan)
                        </label>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 0.85rem; color: var(--adm-text-muted); white-space: nowrap;">/news/</span>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug" 
                                class="adm-input @error('slug') is-invalid @enderror" 
                                value="{{ old('slug') }}" 
                                placeholder="judul-artikel-berita" 
                                maxlength="255"
                            >
                        </div>
                    </div>

                    <!-- 3. Ringkasan Artikel (Excerpt) -->
                    <div>
                        <label for="excerpt" class="adm-label" style="font-weight: 700;">
                            Ringkasan Singkat (Excerpt) <span style="color: var(--adm-danger);">*</span>
                        </label>
                        <textarea 
                            name="excerpt" 
                            id="excerpt" 
                            class="adm-textarea @error('excerpt') is-invalid @enderror" 
                            rows="3" 
                            maxlength="500" 
                            placeholder="Tuliskan 1-2 kalimat ringkasan yang menarik untuk ditampilkan pada kartu berita..." 
                            required
                        >{{ old('excerpt') }}</textarea>
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 0.35rem;">
                            <span>Maksimal 500 karakter.</span>
                            <span id="excerptCount">0 / 500</span>
                        </div>
                    </div>

                    <!-- 4. Isi Artikel (Rich Text Editor) -->
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <label class="adm-label" style="font-weight: 700; margin: 0;">
                                Isi Artikel Lengkap <span style="color: var(--adm-danger);">*</span>
                            </label>
                            <span style="font-size: 0.8rem; color: var(--adm-text-muted);">
                                Mendukung heading, daftar, kutipan, dan tautan
                            </span>
                        </div>

                        <!-- Rich Text Toolbar -->
                        <div class="editor-toolbar" style="display: flex; flex-wrap: wrap; gap: 0.35rem; padding: 0.5rem; background: #F1F5F9; border: 1px solid var(--adm-border); border-bottom: none; border-radius: 8px 8px 0 0;">
                            <button type="button" class="tool-btn" data-cmd="formatBlock" data-val="h2" title="Subjudul H2"><strong>H2</strong></button>
                            <button type="button" class="tool-btn" data-cmd="formatBlock" data-val="h3" title="Subjudul H3"><strong>H3</strong></button>
                            <button type="button" class="tool-btn" data-cmd="formatBlock" data-val="p" title="Paragraf">P</button>
                            <span style="border-right: 1px solid #CBD5E1; margin: 0 0.25rem;"></span>
                            <button type="button" class="tool-btn" data-cmd="bold" title="Tebal (Ctrl+B)"><strong>B</strong></button>
                            <button type="button" class="tool-btn" data-cmd="italic" title="Miring (Ctrl+I)"><em>I</em></button>
                            <button type="button" class="tool-btn" data-cmd="underline" title="Garis Bawah"><u>U</u></button>
                            <span style="border-right: 1px solid #CBD5E1; margin: 0 0.25rem;"></span>
                            <button type="button" class="tool-btn" data-cmd="insertUnorderedList" title="Daftar Bullet">&bull; List</button>
                            <button type="button" class="tool-btn" data-cmd="insertOrderedList" title="Daftar Nomor">1. List</button>
                            <button type="button" class="tool-btn" data-cmd="formatBlock" data-val="blockquote" title="Kutipan (Blockquote)">&ldquo; Kutip</button>
                            <span style="border-right: 1px solid #CBD5E1; margin: 0 0.25rem;"></span>
                            <button type="button" class="tool-btn" id="insertLinkBtn" title="Sisipkan Tautan">🔗 Link</button>
                            <button type="button" class="tool-btn" id="insertImageBtn" title="Sisipkan Gambar via URL">🖼️ Gambar</button>
                            <span style="border-right: 1px solid #CBD5E1; margin: 0 0.25rem;"></span>
                            <button type="button" class="tool-btn" id="toggleCodeBtn" title="Lihat Sumber HTML">&lt;/&gt; HTML</button>
                        </div>

                        <!-- Visual Editor Canvas -->
                        <div 
                            id="richEditor" 
                            contenteditable="true" 
                            style="min-height: 380px; max-height: 600px; overflow-y: auto; padding: 1.25rem; border: 1px solid var(--adm-border); border-radius: 0 0 8px 8px; background: #FFFFFF; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; font-size: 1rem; line-height: 1.75; color: #1E293B;"
                        >{!! old('content', '<p>Tuliskan cerita lengkap artikel di sini...</p>') !!}</div>

                        <!-- Raw Textarea synced with Visual Editor for Form Submission -->
                        <textarea name="content" id="contentInput" style="display: none;" required>{{ old('content') }}</textarea>
                    </div>

                    <!-- 5. Metadata SEO (Accordion / Card) -->
                    <div style="background: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.25rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--adm-text); margin-bottom: 0.75rem;">
                            Pengaturan SEO &amp; Open Graph (Opsional)
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label for="seo_title" class="adm-label">SEO Title</label>
                                <input 
                                    type="text" 
                                    name="seo_title" 
                                    id="seo_title" 
                                    class="adm-input" 
                                    value="{{ old('seo_title') }}" 
                                    placeholder="Biarkan kosong untuk menggunakan judul artikel bawaan"
                                    maxlength="255"
                                >
                            </div>
                            <div>
                                <label for="seo_description" class="adm-label">SEO Description</label>
                                <textarea 
                                    name="seo_description" 
                                    id="seo_description" 
                                    class="adm-textarea" 
                                    rows="2" 
                                    maxlength="500" 
                                    placeholder="Biarkan kosong untuk menggunakan ringkasan artikel bawaan"
                                >{{ old('seo_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Pengaturan & Publikasi -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Kotak Aksi & Status -->
                    <div style="background: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem; color: var(--adm-text); border-bottom: 1px solid var(--adm-border); padding-bottom: 0.5rem;">
                            Status &amp; Publikasi
                        </h4>

                        <!-- Status Radio / Select -->
                        <div style="margin-bottom: 1.25rem;">
                            <label class="adm-label" style="font-weight: 700;">Status Artikel</label>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.35rem;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.925rem;">
                                    <input type="radio" name="status" value="draft" id="statusDraft" {{ old('status') === 'draft' ? 'checked' : '' }}>
                                    <span><strong>Draft</strong> (Simpan pribadi, tidak tampil publik)</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.925rem;">
                                    <input type="radio" name="status" value="published" id="statusPublished" {{ old('status', 'published') === 'published' ? 'checked' : '' }}>
                                    <span><strong>Terbit</strong> (Langsung tampil di website publik)</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.925rem;">
                                    <input type="radio" name="status" value="scheduled" id="statusScheduled" {{ old('status') === 'scheduled' ? 'checked' : '' }}>
                                    <span><strong>Terjadwal</strong> (Rilis otomatis di masa depan)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal Publikasi -->
                        <div id="publishDateGroup" style="margin-bottom: 1.25rem;">
                            <label for="published_at" class="adm-label">
                                Waktu Rilis (Asia/Jakarta)
                            </label>
                            <input 
                                type="datetime-local" 
                                name="published_at" 
                                id="published_at" 
                                class="adm-input" 
                                value="{{ old('published_at', now('Asia/Jakarta')->format('Y-m-d\TH:i')) }}"
                            >
                            <p style="font-size: 0.775rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                                Zona waktu otomatis: WIB (Asia/Jakarta).
                            </p>
                        </div>

                        <!-- Featured Article Checkbox -->
                        <div style="margin-bottom: 1.5rem; padding: 0.75rem; background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 6px;">
                            <label style="display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="margin-top: 0.25rem;">
                                <span style="font-size: 0.875rem; color: #92400E; font-weight: 600;">
                                    Tandai sebagai Berita Unggulan (Tampil di hero banner halaman berita)
                                </span>
                            </label>
                        </div>

                        <!-- Penulis (Author) -->
                        <div style="margin-bottom: 1.5rem; font-size: 0.875rem; color: var(--adm-text-muted);">
                            <span>Penulis: </span>
                            <strong style="color: var(--adm-text);">{{ Auth::user()->name }}</strong>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                            <button type="submit" id="btnPublish" class="adm-btn adm-btn-primary" style="width: 100%; justify-content: center;">
                                🚀 Terbitkan Artikel
                            </button>
                            <button type="button" id="btnDraftAction" class="adm-btn adm-btn-secondary" style="width: 100%; justify-content: center;">
                                💾 Simpan sebagai Draft
                            </button>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div style="background: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <label for="category_id" class="adm-label" style="font-weight: 700; margin: 0;">
                                Kategori
                            </label>
                            <a href="{{ route('admin.news-categories.index') }}" target="_blank" style="font-size: 0.8rem; color: var(--adm-primary); text-decoration: none;">
                                + Kelola Kategori
                            </a>
                        </div>
                        <select name="category_id" id="category_id" class="adm-select">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gambar Thumbnail -->
                    <div style="background: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.25rem;">
                        <label class="adm-label" style="font-weight: 700;">
                            Gambar Thumbnail
                        </label>
                        <p style="font-size: 0.8rem; color: var(--adm-text-muted); margin-bottom: 0.75rem;">
                            Unggah gambar utama kartu (JPG, PNG, WebP, SVG, maks 4MB).
                        </p>

                        <!-- Live Preview Box -->
                        <div id="thumbPreviewBox" style="width: 100%; aspect-ratio: 16/10; background: #F1F5F9; border: 1px dashed var(--adm-border); border-radius: 6px; overflow: hidden; margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: center;">
                            <img id="thumbPreviewImg" src="{{ asset('images/slides/slide-1-dapur-imajinasi.svg') }}" alt="Pratinjau" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <input 
                            type="file" 
                            name="thumbnail_file" 
                            id="thumbnail_file" 
                            accept="image/*"
                            class="adm-input" 
                            style="padding: 0.4rem; font-size: 0.85rem;"
                        >

                        <div style="margin-top: 0.75rem;">
                            <label for="thumbnail_url" style="font-size: 0.8rem; color: var(--adm-text-muted); display: block; margin-bottom: 0.25rem;">
                                Atau gunakan URL / path gambar:
                            </label>
                            <input 
                                type="text" 
                                name="thumbnail_url" 
                                id="thumbnail_url" 
                                class="adm-input" 
                                value="{{ old('thumbnail_url') }}"
                                placeholder="images/gallery/artwork-1-petualangan-awan.svg"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<style>
.tool-btn {
    padding: 0.3rem 0.6rem;
    font-size: 0.85rem;
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    border-radius: 4px;
    cursor: pointer;
    color: #334155;
    transition: all 0.15s ease;
}
.tool-btn:hover {
    background: #E2E8F0;
    color: #0F172A;
}
#richEditor:focus {
    outline: 2px solid var(--adm-primary);
    outline-offset: -1px;
}
#richEditor h2 { font-size: 1.5rem; font-weight: 800; margin: 1rem 0 0.5rem 0; color: #1F1135; }
#richEditor h3 { font-size: 1.25rem; font-weight: 700; margin: 0.85rem 0 0.4rem 0; color: #1F1135; }
#richEditor p { margin-bottom: 0.85rem; }
#richEditor blockquote { border-left: 4px solid #FF6B35; padding: 0.5rem 1rem; margin: 1rem 0; background: #FFF7ED; font-style: italic; }
#richEditor ul, #richEditor ol { padding-left: 1.5rem; margin-bottom: 0.85rem; }
#richEditor img { max-width: 100%; border-radius: 6px; margin: 1rem 0; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const excerptInput = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerptCount');
    const richEditor = document.getElementById('richEditor');
    const contentInput = document.getElementById('contentInput');
    const newsForm = document.getElementById('newsForm');
    const thumbFileInput = document.getElementById('thumbnail_file');
    const thumbUrlInput = document.getElementById('thumbnail_url');
    const thumbPreviewImg = document.getElementById('thumbPreviewImg');
    const btnPublish = document.getElementById('btnPublish');
    const btnDraftAction = document.getElementById('btnDraftAction');
    const statusDraft = document.getElementById('statusDraft');
    const statusPublished = document.getElementById('statusPublished');
    const statusScheduled = document.getElementById('statusScheduled');

    // Auto-generate slug from title
    let manualSlug = false;
    slugInput.addEventListener('input', function() {
        manualSlug = this.value.trim().length > 0;
    });

    titleInput.addEventListener('input', function() {
        if (!manualSlug) {
            slugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

    // Excerpt character counter
    function updateExcerptCount() {
        excerptCount.textContent = excerptInput.value.length + ' / 500';
    }
    excerptInput.addEventListener('input', updateExcerptCount);
    updateExcerptCount();

    // Rich Text Editor Commands
    document.querySelectorAll('.tool-btn[data-cmd]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const cmd = this.dataset.cmd;
            const val = this.dataset.val || null;
            document.execCommand(cmd, false, val);
            richEditor.focus();
        });
    });

    // Insert Link
    document.getElementById('insertLinkBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const url = prompt('Masukkan URL tautan (http/https):', 'https://');
        if (url && url !== 'https://') {
            document.execCommand('createLink', false, url);
        }
        richEditor.focus();
    });

    // Insert Image
    document.getElementById('insertImageBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const url = prompt('Masukkan URL gambar:', '');
        if (url) {
            document.execCommand('insertImage', false, url);
        }
        richEditor.focus();
    });

    // Toggle Code view
    let isHtmlMode = false;
    document.getElementById('toggleCodeBtn').addEventListener('click', function(e) {
        e.preventDefault();
        isHtmlMode = !isHtmlMode;
        if (isHtmlMode) {
            richEditor.textContent = richEditor.innerHTML;
            this.style.background = '#CBD5E1';
        } else {
            richEditor.innerHTML = richEditor.textContent;
            this.style.background = '#FFFFFF';
        }
        richEditor.focus();
    });

    // Sync visual editor to hidden input on submit
    newsForm.addEventListener('submit', function() {
        if (isHtmlMode) {
            contentInput.value = richEditor.textContent;
        } else {
            contentInput.value = richEditor.innerHTML;
        }
    });

    // Button Save as Draft quick click
    btnDraftAction.addEventListener('click', function() {
        statusDraft.checked = true;
        updateButtonLabels();
        newsForm.submit();
    });

    // Dynamic button label based on status
    function updateButtonLabels() {
        if (statusDraft.checked) {
            btnPublish.innerHTML = '💾 Simpan sebagai Draft';
        } else if (statusScheduled.checked) {
            btnPublish.innerHTML = '⏰ Jadwalkan Artikel';
        } else {
            btnPublish.innerHTML = '🚀 Terbitkan Artikel';
        }
    }

    [statusDraft, statusPublished, statusScheduled].forEach(r => {
        r.addEventListener('change', updateButtonLabels);
    });
    updateButtonLabels();

    // Image file preview
    thumbFileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbPreviewImg.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // URL preview fallback
    thumbUrlInput.addEventListener('input', function() {
        if (this.value.trim().length > 0 && (!thumbFileInput.files || !thumbFileInput.files[0])) {
            thumbPreviewImg.src = this.value;
        }
    });
});
</script>
@endsection
