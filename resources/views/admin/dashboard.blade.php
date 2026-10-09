@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Studio & Konten')

@section('content')
    <!-- Metric Summary Cards -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-info">
                <h6>Karya Galeri</h6>
                <h3>{{ $galleryCount }}</h3>
            </div>
            <div class="metric-icon-box bg-blue-light">🎨</div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Slide Aktif</h6>
                <h3>{{ $activeSlideCount }} <span style="font-size: 1rem; color: #94A3B8; font-weight: 500;">/ {{ $totalSlideCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-orange-light">🖼️</div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Ulasan Testimoni</h6>
                <h3>{{ $testimonialCount }}</h3>
            </div>
            <div class="metric-icon-box bg-purple-light">💬</div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Pesan Belum Dibaca</h6>
                <h3>{{ $unreadContactCount }} <span style="font-size: 1rem; color: #94A3B8; font-weight: 500;">/ {{ $totalContactCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-green-light">📬</div>
        </div>
    </div>

    <!-- Quick Action Bar -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
        <a href="{{ route('admin.galleries.create') }}" class="adm-btn adm-btn-primary">
            + Tambah Karya Galeri
        </a>
        <a href="{{ route('admin.slides.create') }}" class="adm-btn adm-btn-secondary">
            + Tambah Slide Hero
        </a>
        <a href="{{ route('admin.testimonials.create') }}" class="adm-btn adm-btn-secondary">
            + Tambah Testimoni
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2rem;">
        <!-- Recent Messages -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pesan Masuk Terbaru</h3>
                <a href="{{ route('admin.contacts.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                    Lihat Semua ({{ $totalContactCount }})
                </a>
            </div>

            @if($recentContacts->isEmpty())
                <p style="color: var(--adm-text-muted); padding: 1rem 0;">Belum ada pesan kontak yang masuk.</p>
            @else
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Subjek</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentContacts as $msg)
                                <tr>
                                    <td>
                                        <strong>{{ $msg->name }}</strong><br>
                                        <small style="color: var(--adm-text-muted);">{{ $msg->email }}</small>
                                    </td>
                                    <td>
                                        <span>{{ Str::limit($msg->subject ?? 'Pesan Masuk', 28) }}</span>
                                    </td>
                                    <td>
                                        @if(!$msg->is_read)
                                            <span class="badge badge-warning">Baru</span>
                                        @else
                                            <span class="badge badge-neutral">Dibaca</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.contacts.show', $msg) }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                                            Buka
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Recent Gallery Additions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Karya Galeri Terkini</h3>
                <a href="{{ route('admin.galleries.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                    Kelola
                </a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($recentGalleries as $art)
                    <div style="display: flex; align-items: center; gap: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--adm-border);">
                        <img src="{{ asset($art->image) }}" alt="" class="thumb-preview">
                        <div style="flex-grow: 1;">
                            <strong style="font-size: 0.95rem;">{{ $art->title }}</strong><br>
                            <span class="badge badge-neutral" style="font-size: 0.7rem;">{{ $art->category }}</span>
                        </div>
                        @if($art->is_published)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-warning">Draf</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
