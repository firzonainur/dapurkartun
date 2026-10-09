@extends('layouts.admin')

@section('title', 'Pesan Kontak Masuk')
@section('header_title', 'Kotak Pesan Masuk Pengunjung')

@section('content')
    <div class="card">
        <div class="card-header" style="flex-wrap: wrap; gap: 1rem;">
            <h3 class="card-title">Daftar Pesan Kontak</h3>

            <!-- Status Filter Tabs -->
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <a href="{{ route('admin.contacts.index', array_merge(request()->except('filter', 'page'), [])) }}" class="adm-btn {{ !request('filter') ? 'adm-btn-primary' : 'adm-btn-secondary' }} adm-btn-sm">
                    Semua ({{ $totalCount ?? $messages->total() }})
                </a>
                <a href="{{ route('admin.contacts.index', array_merge(request()->except('page'), ['filter' => 'unread'])) }}" class="adm-btn {{ request('filter') === 'unread' ? 'adm-btn-primary' : 'adm-btn-secondary' }} adm-btn-sm">
                    Belum Dibaca ({{ $unreadCount }})
                </a>
                <a href="{{ route('admin.contacts.index', array_merge(request()->except('page'), ['filter' => 'read'])) }}" class="adm-btn {{ request('filter') === 'read' ? 'adm-btn-primary' : 'adm-btn-secondary' }} adm-btn-sm">
                    Sudah Dibaca
                </a>
            </div>
        </div>

        <!-- Pencarian Pesan -->
        <div style="background-color: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
            <form action="{{ route('admin.contacts.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
                @if(request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <div style="flex-grow: 1; min-width: 240px;">
                    <input 
                        type="text" 
                        name="search" 
                        class="adm-input" 
                        placeholder="Cari berdasarkan nama, email, subjek, atau kata kunci..." 
                        value="{{ request('search') }}">
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">
                        Cari Pesan
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.contacts.index', request('filter') ? ['filter' => request('filter')] : []) }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($messages->isEmpty())
            <div style="padding: 2.5rem 1rem; text-align: center; color: var(--adm-text-muted);">
                <p style="font-weight: 700; font-size: 1rem; margin-bottom: 0.35rem;">Tidak ada pesan kontak ditemukan.</p>
                <p style="font-size: 0.875rem;">Pesan dari pengunjung yang mengisi formulir kontak landing page akan tersimpan dan tampil di sini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Status</th>
                            <th>Nama Pengirim</th>
                            <th>Email</th>
                            <th>Nomor WhatsApp</th>
                            <th>Subjek</th>
                            <th>Tanggal Masuk</th>
                            <th style="text-align: right; min-width: 170px;">Aksi</th>
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
                                    <strong style="font-size: 0.95rem; color: var(--adm-text);">{{ $msg->name }}</strong>
                                </td>
                                <td>
                                    <a href="mailto:{{ $msg->email }}" style="color: var(--adm-primary); text-decoration: underline;" title="Kirim email ke {{ $msg->email }}">
                                        {{ $msg->email }}
                                    </a>
                                </td>
                                <td>
                                    @if($msg->phone)
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $msg->phone);
                                            if (str_starts_with($cleanPhone, '0')) {
                                                $cleanPhone = '62' . substr($cleanPhone, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($msg->name) }},%20terima%20kasih%20telah%20menghubungi%20Dapur%20Kartun." target="_blank" rel="noopener noreferrer" style="color: #16A34A; text-decoration: underline; font-weight: 600;" title="Buka percakapan WhatsApp">
                                            {{ $msg->phone }}
                                        </a>
                                    @else
                                        <span style="color: var(--adm-text-muted);">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight: 600;">{{ Str::limit($msg->subject ?? 'Pesan Masuk', 28) }}</span>
                                </td>
                                <td>
                                    <small style="color: var(--adm-text-muted);">{{ $msg->created_at->format('d M Y, H:i') }} WIB</small>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.4rem; align-items: center;">
                                        <a href="{{ route('admin.contacts.show', $msg) }}" class="adm-btn adm-btn-primary adm-btn-sm" title="Lihat detail isi pesan">
                                            Detail
                                        </a>

                                        <form action="{{ route('admin.contacts.toggle-read', $msg) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="adm-btn adm-btn-secondary adm-btn-sm" title="{{ $msg->is_read ? 'Tandai belum dibaca' : 'Tandai sudah dibaca' }}">
                                                {{ $msg->is_read ? 'Belum' : 'Baca' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan dari {{ $msg->name }}?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm" title="Hapus pesan kontak">
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

