@extends('layouts.admin')

@section('title', 'Kelola Slider')
@section('header_title', 'Kelola Slider Hero Utama')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Slide Hero</h3>
            <a href="{{ route('admin.slides.create') }}" class="adm-btn adm-btn-primary">
                + Tambah Slide Baru
            </a>
        </div>

        @if($slides->isEmpty())
            <p style="color: var(--adm-text-muted); padding: 1.5rem 0; text-align: center;">Belum ada data slide. Klik tombol di atas untuk menambahkan slide baru.</p>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Pratinjau</th>
                            <th>Judul &amp; Subjudul</th>
                            <th>Tombol Aksi</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slides as $slide)
                            <tr>
                                <td>
                                    <img src="{{ asset($slide->image) }}" alt="" class="thumb-preview">
                                </td>
                                <td>
                                    <strong style="font-size: 1rem;">{{ $slide->title }}</strong>
                                    @if($slide->subtitle)
                                        <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-top: 0.2rem;">{{ Str::limit($slide->subtitle, 60) }}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($slide->button_text)
                                        <span class="badge badge-neutral">{{ $slide->button_text }} &rarr; {{ $slide->button_url }}</span>
                                    @else
                                        <span style="color: var(--adm-text-muted); font-size: 0.85rem;">Tanpa Tombol</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $slide->sort_order }}</strong>
                                </td>
                                <td>
                                    <form action="{{ route('admin.slides.toggle-active', $slide) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="badge {{ $slide->is_active ? 'badge-success' : 'badge-warning' }}" style="cursor: pointer; border: none;">
                                            {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.slides.edit', $slide) }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini?');" style="margin: 0;">
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
                {{ $slides->links() }}
            </div>
        @endif
    </div>
@endsection
