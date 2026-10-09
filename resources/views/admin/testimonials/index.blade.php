@extends('layouts.admin')

@section('title', 'Kelola Testimoni')
@section('header_title', 'Kelola Ulasan Pelanggan / Sahabat')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Testimoni</h3>
            <a href="{{ route('admin.testimonials.create') }}" class="adm-btn adm-btn-primary">
                + Tambah Testimoni Baru
            </a>
        </div>

        @if($testimonials->isEmpty())
            <p style="color: var(--adm-text-muted); padding: 1.5rem 0; text-align: center;">Belum ada testimoni. Klik tombol di atas untuk menambahkan testimoni baru.</p>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Avatar</th>
                            <th>Nama &amp; Peran</th>
                            <th>Ulasan</th>
                            <th>Rating</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testi)
                            <tr>
                                <td>
                                    <img src="{{ asset($testi->avatar ?? 'images/avatars/avatar-1.svg') }}" alt="" class="thumb-preview" style="width: 44px; height: 44px; border-radius: 50%;">
                                </td>
                                <td>
                                    <strong>{{ $testi->customer_name }}</strong><br>
                                    <small style="color: var(--adm-text-muted);">{{ $testi->role }}</small>
                                </td>
                                <td>
                                    <p style="font-size: 0.85rem; color: var(--adm-text); max-width: 320px;">
                                        &ldquo;{{ Str::limit($testi->message, 80) }}&rdquo;
                                    </p>
                                </td>
                                <td>
                                    <span style="color: var(--adm-warning); font-weight: 700;">★ {{ $testi->rating }} / 5</span>
                                </td>
                                <td>
                                    <strong>{{ $testi->sort_order }}</strong>
                                </td>
                                <td>
                                    <form action="{{ route('admin.testimonials.toggle-publish', $testi) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="badge {{ $testi->is_published ? 'badge-success' : 'badge-warning' }}" style="cursor: pointer; border: none;">
                                            {{ $testi->is_published ? 'Aktif' : 'Disembunyikan' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.testimonials.edit', $testi) }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testi) }}" method="POST" onsubmit="return confirm('Hapus ulasan testimoni ini?');" style="margin: 0;">
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
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
@endsection
