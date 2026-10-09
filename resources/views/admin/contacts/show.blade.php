@extends('layouts.admin')

@section('title', 'Detail Pesan Masuk')
@section('header_title', 'Detail Pesan Masuk')

@section('content')
    <div class="card" style="max-width: 750px; margin: 0 auto;">
        <div class="card-header">
            <div>
                <h3 class="card-title">{{ $contact->subject ?? 'Pesan Masuk dari Website' }}</h3>
                <small style="color: var(--adm-text-muted);">Diterima pada {{ $contact->created_at->format('d F Y, Pukul H:i') }} WIB</small>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="adm-btn adm-btn-secondary adm-btn-sm">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div style="background-color: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nama Pengirim:</span>
                    <p style="font-weight: 700; font-size: 1.05rem; color: var(--adm-text);">{{ $contact->name }}</p>
                </div>

                <div>
                    <span style="font-size: 0.8rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Email:</span>
                    <p style="font-weight: 600; color: var(--adm-text);">
                        <a href="mailto:{{ $contact->email }}" style="color: var(--adm-primary); text-decoration: underline;">
                            {{ $contact->email }}
                        </a>
                    </p>
                </div>

                <div>
                    <span style="font-size: 0.8rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nomor Telepon / WhatsApp:</span>
                    <p style="font-weight: 600; color: var(--adm-text);">
                        @if($contact->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" target="_blank" style="color: #16A34A; text-decoration: underline;">
                                {{ $contact->phone }} (Buka WA)
                            </a>
                        @else
                            <span style="color: var(--adm-text-muted);">-</span>
                        @endif
                    </p>
                </div>

                <div>
                    <span style="font-size: 0.8rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Status:</span>
                    <p>
                        <span class="badge badge-success">Sudah Dibaca</span>
                    </p>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.9rem; text-transform: uppercase; color: var(--adm-text-muted); margin-bottom: 0.5rem; font-weight: 800;">Isi Pesan:</h4>
            <div style="background-color: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.5rem; font-size: 1rem; line-height: 1.7; white-space: pre-wrap; color: #1E293B;">{{ $contact->message }}</div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--adm-border); padding-top: 1.25rem;">
            <div style="display: flex; gap: 0.75rem;">
                <a href="mailto:{{ $contact->email }}?subject=Balasan: {{ urlencode($contact->subject ?? 'Dapur Kartun') }}" class="adm-btn adm-btn-primary">
                    Balas via Email
                </a>
                @if($contact->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}?text=Halo%20{{ urlencode($contact->name) }},%20terima%20kasih%20telah%20menghubungi%20Dapur%20Kartun." target="_blank" class="adm-btn adm-btn-secondary" style="color: #16A34A;">
                        Balas via WhatsApp
                    </a>
                @endif
            </div>

            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Hapus pesan kontak ini secara permanen?');" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="adm-btn adm-btn-danger">
                    Hapus Pesan
                </button>
            </form>
        </div>
    </div>
@endsection
