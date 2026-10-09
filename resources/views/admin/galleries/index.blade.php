@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('header_title', 'Kelola Portofolio Karya')

@section('content')
    <div class="card">
        <div class="card-header" style="flex-wrap: wrap; gap: 1rem;">
            <h3 class="card-title">Daftar Karya Galeri</h3>
            <a href="{{ route('admin.galleries.create') }}" class="adm-btn adm-btn-primary">
                + Tambah Karya Baru
            </a>
        </div>

        <!-- Filter & Pencarian Toolbar -->
        <div style="background-color: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
            <form action="{{ route('admin.galleries.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
                <div style="flex-grow: 1; min-width: 220px;">
                    <input 
                        type="text" 
                        name="search" 
                        class="adm-input" 
                        placeholder="Cari karya berdasarkan judul atau deskripsi..." 
                        value="{{ request('search') }}">
                </div>

                <div style="min-width: 180px;">
                    <select name="category" class="adm-select">
                        <option value="Semua">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">
                        Terapkan
                    </button>
                    @if(request('search') || (request('category') && request('category') !== 'Semua'))
                        <a href="{{ route('admin.galleries.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>


        @if($galleries->isEmpty())
            <p style="color: var(--adm-text-muted); padding: 1.5rem 0; text-align: center;">Belum ada karya galeri pada kategori ini.</p>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Pratinjau</th>
                            <th>Judul Karya</th>
                            <th>Kategori</th>
                            <th>Urutan</th>
                            <th>Publikasi</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($galleries as $art)
                            <tr>
                                <td>
                                    <img src="{{ asset($art->image) }}" alt="" class="thumb-preview">
                                </td>
                                <td>
                                    <strong style="font-size: 1rem;">{{ $art->title }}</strong>
                                    @if($art->description)
                                        <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-top: 0.2rem;">{{ Str::limit($art->description, 50) }}</p>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-neutral">{{ $art->category }}</span>
                                </td>
                                <td>
                                    <strong>{{ $art->sort_order }}</strong>
                                </td>
                                <td>
                                    <form action="{{ route('admin.galleries.toggle-publish', $art) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="badge {{ $art->is_published ? 'badge-success' : 'badge-warning' }}" style="cursor: pointer; border: none;">
                                            {{ $art->is_published ? 'Dipublikasikan' : 'Disembunyikan' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.galleries.edit', $art) }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.galleries.destroy', $art) }}" method="POST" onsubmit="return confirm('Hapus karya galeri ini?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
@endsection
