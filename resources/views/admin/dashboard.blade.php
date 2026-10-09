@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Dashboard Studio')

@section('content')
    <!-- Administrator Greeting Banner -->
    <div style="background-color: #FFFFFF; border: 1px solid var(--adm-border); border-radius: var(--adm-radius); padding: 1.5rem 1.75rem; margin-bottom: 1.75rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.35rem; font-weight: 800; color: #1F1135; margin-bottom: 0.25rem;">
                Halo, {{ Auth::user()->name ?? 'Administrator' }}!
            </h1>
            <p style="color: var(--adm-text-muted); font-size: 0.925rem;">
                Berikut ringkasan data langsung dari database SQLite dan status publikasi website Dapur Kartun.
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('admin.news.create') }}" class="adm-btn adm-btn-primary adm-btn-sm">
                + Tulis Artikel
            </a>
            <a href="{{ route('admin.galleries.create') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                + Tambah Karya
            </a>
            <a href="{{ route('admin.slides.create') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                + Buat Slide
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                Lihat Pesan Masuk
            </a>
        </div>
    </div>

    <!-- Main Metric Stats from SQLite Database -->
    <div class="metrics-grid" style="grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));">
        <div class="metric-card">
            <div class="metric-info">
                <h6>Artikel Berita</h6>
                <h3>{{ $publishedNewsCount }} <span style="font-size: 0.95rem; color: #94A3B8; font-weight: 500;">/ {{ $totalNewsCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-orange-light">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Slide Aktif</h6>
                <h3>{{ $activeSlideCount }} <span style="font-size: 0.95rem; color: #94A3B8; font-weight: 500;">/ {{ $totalSlideCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-orange-light">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Karya Dipublikasikan</h6>
                <h3>{{ $publishedGalleryCount }} <span style="font-size: 0.95rem; color: #94A3B8; font-weight: 500;">/ {{ $totalGalleryCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-blue-light">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                    <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                    <path d="M2 2l7.586 7.586"></path>
                    <circle cx="11" cy="11" r="2"></circle>
                </svg>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Testimoni Dipublikasikan</h6>
                <h3>{{ $publishedTestimonialCount }} <span style="font-size: 0.95rem; color: #94A3B8; font-weight: 500;">/ {{ $totalTestimonialCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-purple-light">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <h6>Pesan Belum Dibaca</h6>
                <h3>{{ $unreadContactCount }} <span style="font-size: 0.95rem; color: #94A3B8; font-weight: 500;">/ {{ $totalContactCount }}</span></h3>
            </div>
            <div class="metric-icon-box bg-green-light">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
        </div>
    </div>

    <!-- Content Sections Grid -->
    <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 1.75rem; align-items: start;">
        <!-- Recent Messages from Contacts -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title" style="font-size: 1.1rem;">Pesan Kontak Terbaru</h2>
                <a href="{{ route('admin.contacts.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                    Lihat Semua ({{ $totalContactCount }})
                </a>
            </div>

            @if($recentContacts->isEmpty())
                <div style="padding: 2rem 1rem; text-align: center; color: var(--adm-text-muted);">
                    <p style="font-weight: 600; margin-bottom: 0.25rem;">Belum ada pesan kontak masuk.</p>
                    <p style="font-size: 0.85rem;">Pesan dari formulir kontak pengunjung di landing page akan otomatis tampil di sini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Subjek</th>
                                <th>Status</th>
                                <th style="text-align: right;">Aksi</th>
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
                                        <span>{{ Str::limit($msg->subject ?? 'Pesan Masuk', 26) }}</span>
                                    </td>
                                    <td>
                                        @if(!$msg->is_read)
                                            <span class="badge badge-warning">Baru</span>
                                        @else
                                            <span class="badge badge-neutral">Dibaca</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
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

        <!-- Recent Content Management Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title" style="font-size: 1.1rem;">Aktivitas Konten Terbaru</h2>
                <span style="font-size: 0.8rem; color: var(--adm-text-muted);">Pembaruan Terkini</span>
            </div>

            @if($recentActivities->isEmpty())
                <div style="padding: 2rem 1rem; text-align: center; color: var(--adm-text-muted);">
                    <p style="font-weight: 600; margin-bottom: 0.25rem;">Belum ada aktivitas konten.</p>
                    <p style="font-size: 0.85rem;">Aktivitas pengelolaan slider, galeri, dan testimoni akan tercatat di sini.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 0.9rem;">
                    @foreach($recentActivities as $act)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid var(--adm-border); gap: 0.75rem;">
                            <div style="flex-grow: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                                    <span class="badge badge-neutral" style="font-size: 0.7rem;">{{ $act['badge'] }}</span>
                                    <span class="badge {{ $act['status_class'] }}" style="font-size: 0.7rem;">{{ $act['status'] }}</span>
                                </div>
                                <strong style="font-size: 0.9rem; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--adm-text);">
                                    {{ $act['title'] }}
                                </strong>
                                <small style="color: var(--adm-text-muted); font-size: 0.75rem;">
                                    {{ $act['time']->diffForHumans() }}
                                </small>
                            </div>
                            <a href="{{ $act['edit_url'] }}" class="adm-btn adm-btn-secondary adm-btn-sm" style="flex-shrink: 0;">
                                Kelola
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

