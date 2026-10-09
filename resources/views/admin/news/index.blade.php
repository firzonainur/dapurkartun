@extends('layouts.admin')

@section('title', 'Kelola News / Artikel')
@section('header_title', 'Kelola Berita & Artikel Studio')

@section('content')
    <div class="card">
        <div class="card-header" style="flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between;">
            <div>
                <h3 class="card-title">Daftar Artikel Berita</h3>
                <p style="font-size: 0.875rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                    Kelola publikasi cerita, inspirasi, dan kabar terkini Dapur Kartun.
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="{{ route('admin.news-categories.index') }}" class="adm-btn adm-btn-secondary">
                    📁 Kelola Kategori ({{ $categories->count() }})
                </a>
                <a href="{{ route('admin.news.create') }}" class="adm-btn adm-btn-primary">
                    + Tambah Artikel Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter & Pencarian Toolbar -->
        <div style="background-color: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
            <form action="{{ route('admin.news.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
                <!-- Search input -->
                <div style="flex-grow: 1; min-width: 220px;">
                    <input 
                        type="text" 
                        name="search" 
                        class="adm-input" 
                        placeholder="Cari judul artikel atau ringkasan..." 
                        value="{{ request('search') }}"
                    >
                </div>

                <!-- Category filter -->
                <div style="min-width: 170px;">
                    <select name="category_id" class="adm-select">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status filter -->
                <div style="min-width: 150px;">
                    <select name="status" class="adm-select">
                        <option value="all">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Terbit</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    </select>
                </div>

                <!-- Submit & Reset -->
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">
                        Filter
                    </button>
                    @if(request('search') || (request('category_id') && request('category_id') !== 'all') || (request('status') && request('status') !== 'all'))
                        <a href="{{ route('admin.news.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($news->isEmpty())
            <div style="text-align: center; padding: 3rem 1.5rem; color: var(--adm-text-muted);">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📰</div>
                <h4 style="font-weight: 700; color: var(--adm-text); margin-bottom: 0.5rem;">Belum ada artikel yang cocok</h4>
                <p style="font-size: 0.9rem; margin-bottom: 1.25rem;">Silakan tambahkan artikel baru atau ubah kriteria filter pencarian.</p>
                <a href="{{ route('admin.news.create') }}" class="adm-btn adm-btn-primary adm-btn-sm">
                    Buat Artikel Baru
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Thumbnail</th>
                            <th>Judul Artikel</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th>Tanggal Publikasi</th>
                            <th>Terakhir Diperbarui</th>
                            <th style="text-align: right; min-width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->thumbnail_url }}" alt="" class="thumb-preview" style="width: 54px; height: 42px; object-fit: cover; border-radius: 6px; border: 1px solid var(--adm-border);">
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <strong style="font-size: 0.95rem; color: var(--adm-text);">{{ $item->title }}</strong>
                                        @if($item->is_featured)
                                            <span style="background: #FEF3C7; color: #92400E; font-size: 0.7rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: 9999px;">
                                                ⭐ Unggulan
                                            </span>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
                                        /news/{{ $item->slug }}
                                    </div>
                                </td>
                                <td>
                                    @if($item->category)
                                        <span class="badge badge-neutral">{{ $item->category->name }}</span>
                                    @else
                                        <span style="color: var(--adm-text-muted); font-size: 0.85rem;">Tanpa Kategori</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-size: 0.875rem;">{{ $item->author ? $item->author->name : '-' }}</span>
                                </td>
                                <td>
                                    @if($item->status === 'published')
                                        <span class="badge badge-success">Terbit</span>
                                    @elseif($item->status === 'scheduled')
                                        <span class="badge badge-warning" style="background: #E0E7FF; color: #3730A3;">Terjadwal</span>
                                    @else
                                        <span class="badge badge-neutral" style="background: #F1F5F9; color: #64748B;">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->published_at)
                                        <div style="font-size: 0.85rem; font-weight: 600;">
                                            {{ $item->published_at->timezone('Asia/Jakarta')->format('d M Y') }}
                                        </div>
                                        <div style="font-size: 0.775rem; color: var(--adm-text-muted);">
                                            {{ $item->published_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                        </div>
                                    @else
                                        <span style="color: var(--adm-text-muted); font-size: 0.85rem;">-</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.85rem; color: var(--adm-text-muted);">
                                    {{ $item->updated_at->timezone('Asia/Jakarta')->diffForHumans() }}
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.4rem; justify-content: flex-end;">
                                        <a href="{{ route('admin.news.preview', $item->id) }}" target="_blank" class="adm-btn adm-btn-secondary adm-btn-sm" title="Pratinjau Tampilan Publik">
                                            👁️
                                        </a>
                                        <a href="{{ route('admin.news.edit', $item->id) }}" class="adm-btn adm-btn-secondary adm-btn-sm" title="Edit Artikel">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel \'{{ addslashes($item->title) }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm" title="Hapus Artikel">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                {{ $news->links() }}
            </div>
        @endif
    </div>
@endsection
