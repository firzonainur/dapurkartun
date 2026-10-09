@extends('layouts.admin')

@section('title', 'Pesan Kontak Masuk')
@section('header_title', 'Kotak Pesan Masuk')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pesan Masuk</h3>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.contacts.index') }}" class="adm-btn {{ !request('filter') ? 'adm-btn-primary' : 'adm-btn-secondary' }} adm-btn-sm">
                    Semua
                </a>
                <a href="{{ route('admin.contacts.index', ['filter' => 'unread']) }}" class="adm-btn {{ request('filter') === 'unread' ? 'adm-btn-primary' : 'adm-btn-secondary' }} adm-btn-sm">
                    Belum Dibaca ({{ $unreadCount }})
                </a>
                <a href="{{ route('admin.contacts.index', ['filter' => 'read']) }}" class="adm-btn {{ request('filter') === 'read' ? 'adm-btn-primary' : 'adm-btn-secondary' }} adm-btn-sm">
                    Sudah Dibaca
                </a>
            </div>
        </div>

        @if($messages->isEmpty())
            <p style="color: var(--adm-text-muted); padding: 2rem 0; text-align: center;">Tidak ada pesan kontak ditemukan.</p>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Pengirim</th>
                            <th>Kontak</th>
                            <th>Subjek &amp; Pesan</th>
                            <th>Tanggal</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $msg)
                            <tr style="{{ !$msg->is_read ? 'background-color: #FEFCE8;' : '' }}">
                                <td>
                                    @if(!$msg->is_read)
                                        <span class="badge badge-warning">Baru</span>
                                    @else
                                        <span class="badge badge-neutral">Dibaca</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="font-size: 0.95rem;">{{ $msg->name }}</strong>
                                </td>
                                <td>
                                    <span>{{ $msg->email }}</span><br>
                                    <small style="color: var(--adm-text-muted);">{{ $msg->phone ?? '-' }}</small>
                                </td>
                                <td>
                                    <strong>{{ $msg->subject ?? 'Pesan Umum' }}</strong>
                                    <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
                                        {{ Str::limit($msg->message, 60) }}
                                    </p>
                                </td>
                                <td>
                                    <small style="color: var(--adm-text-muted);">{{ $msg->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.contacts.show', $msg) }}" class="adm-btn adm-btn-primary adm-btn-sm">
                                            Buka Pesan
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan kontak ini?');" style="margin: 0;">
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
                {{ $messages->links() }}
            </div>
        @endif
    </div>
@endsection
