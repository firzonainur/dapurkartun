@extends('layouts.admin')

@section('title', 'Kelola Kategori Berita')
@section('header_title', 'Kelola Kategori Berita & Artikel')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: flex-start; max-width: 1100px; margin: 0 auto;">
        <!-- Kolom Kiri: Form Tambah Kategori -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" id="formHeaderTitle">Tambah Kategori Baru</h3>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 1.25rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="margin-bottom: 1.25rem;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 1.25rem;">
                    <ul style="padding-left: 1.25rem; font-size: 0.85rem;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.news-categories.store') }}" method="POST" id="categoryForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div style="margin-bottom: 1.25rem;">
                    <label for="name" class="adm-label" style="font-weight: 700;">
                        Nama Kategori <span style="color: var(--adm-danger);">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="catName" 
                        class="adm-input @error('name') is-invalid @enderror" 
                        value="{{ old('name') }}" 
                        placeholder="Contoh: Lokakarya Kreatif" 
                        maxlength="100" 
                        required
                    >
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label for="slug" class="adm-label">
                        Slug URL (Otomatis jika kosong)
                    </label>
                    <input 
                        type="text" 
                        name="slug" 
                        id="catSlug" 
                        class="adm-input @error('slug') is-invalid @enderror" 
                        value="{{ old('slug') }}" 
                        placeholder="lokakarya-kreatif" 
                        maxlength="120"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="description" class="adm-label">
                        Deskripsi (Opsional)
                    </label>
                    <textarea 
                        name="description" 
                        id="catDesc" 
                        class="adm-textarea @error('description') is-invalid @enderror" 
                        rows="3" 
                        maxlength="500" 
                        placeholder="Penjelasan singkat mengenai kategori ini..."
                    >{{ old('description') }}</textarea>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" id="btnSubmitCat" class="adm-btn adm-btn-primary" style="flex-grow: 1; justify-content: center;">
                        + Simpan Kategori
                    </button>
                    <button type="button" id="btnCancelEdit" class="adm-btn adm-btn-secondary" style="display: none;">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Daftar Kategori -->
        <div class="card">
            <div class="card-header" style="justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                <div>
                    <h3 class="card-title">Daftar Kategori</h3>
                    <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
                        Total {{ $categories->total() }} kategori terdaftar.
                    </p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                    &larr; Ke Daftar Artikel
                </a>
            </div>

            <!-- Pencarian Kategori -->
            <div style="margin-bottom: 1.25rem;">
                <form action="{{ route('admin.news-categories.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                    <input 
                        type="text" 
                        name="search" 
                        class="adm-input" 
                        placeholder="Cari nama atau deskripsi kategori..." 
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.news-categories.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if($categories->isEmpty())
                <p style="text-align: center; color: var(--adm-text-muted); padding: 2rem 0;">
                    Belum ada kategori yang terdaftar.
                </p>
            @else
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th style="text-align: center;">Jumlah Artikel</th>
                                <th style="text-align: right; min-width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $item)
                                <tr>
                                    <td>
                                        <strong style="font-size: 0.95rem; color: var(--adm-text);">{{ $item->name }}</strong>
                                        @if($item->description)
                                            <p style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                                {{ Str::limit($item->description, 60) }}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        <code style="font-size: 0.8rem; background: #F1F5F9; padding: 0.15rem 0.4rem; border-radius: 4px; color: #475569;">
                                            {{ $item->slug }}
                                        </code>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('admin.news.index', ['category_id' => $item->id]) }}" class="badge badge-neutral" style="text-decoration: none;" title="Lihat artikel pada kategori ini">
                                            {{ $item->news_count }} artikel
                                        </a>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 0.35rem; justify-content: flex-end;">
                                            <!-- Tombol Edit Mode -->
                                            <button 
                                                type="button" 
                                                class="adm-btn adm-btn-secondary adm-btn-sm" 
                                                onclick="editCategory({{ json_encode($item) }})"
                                                title="Edit Kategori"
                                            >
                                                ✏️ Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            @if($item->news_count > 0)
                                                <button 
                                                    type="button" 
                                                    class="adm-btn adm-btn-danger adm-btn-sm" 
                                                    disabled 
                                                    style="opacity: 0.45; cursor: not-allowed;" 
                                                    title="Tidak dapat dihapus karena masih digunakan oleh {{ $item->news_count }} artikel."
                                                >
                                                    🗑️
                                                </button>
                                            @else
                                                <form action="{{ route('admin.news-categories.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ addslashes($item->name) }}\'?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm" title="Hapus Kategori">
                                                        🗑️
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1.25rem; display: flex; justify-content: center;">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

<script>
const categoryForm = document.getElementById('categoryForm');
const formMethod = document.getElementById('formMethod');
const formHeaderTitle = document.getElementById('formHeaderTitle');
const catName = document.getElementById('catName');
const catSlug = document.getElementById('catSlug');
const catDesc = document.getElementById('catDesc');
const btnSubmitCat = document.getElementById('btnSubmitCat');
const btnCancelEdit = document.getElementById('btnCancelEdit');

const storeUrl = "{{ route('admin.news-categories.store') }}";

function editCategory(cat) {
    formHeaderTitle.textContent = 'Edit Kategori: ' + cat.name;
    categoryForm.action = "{{ url('admin/news-categories') }}/" + cat.id;
    formMethod.value = 'PUT';

    catName.value = cat.name;
    catSlug.value = cat.slug;
    catDesc.value = cat.description || '';

    btnSubmitCat.innerHTML = '💾 Perbarui Kategori';
    btnCancelEdit.style.display = 'inline-block';

    catName.focus();
}

btnCancelEdit.addEventListener('click', function() {
    formHeaderTitle.textContent = 'Tambah Kategori Baru';
    categoryForm.action = storeUrl;
    formMethod.value = 'POST';

    catName.value = '';
    catSlug.value = '';
    catDesc.value = '';

    btnSubmitCat.innerHTML = '+ Simpan Kategori';
    btnCancelEdit.style.display = 'none';
});

// Auto-generate slug on typing name if adding new
catName.addEventListener('input', function() {
    if (formMethod.value === 'POST') {
        catSlug.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});
</script>
@endsection
