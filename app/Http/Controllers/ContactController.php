<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Anti-spam Honeypot check
        if (!empty($request->input('website_trap'))) {
            // Silently redirect spam bot
            return back()->with('success', 'Pesan Anda telah berhasil dikirimkan!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|min:5|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'message.required' => 'Pesan tidak boleh kosong.',
            'message.min' => 'Pesan minimal terdiri dari 5 karakter.',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Pesan Baru dari Website',
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return redirect()->to(url()->previous() . '#kontak')
            ->with('success', 'Terima kasih! Pesan Anda telah tersimpan dan tim Dapur Kartun akan segera merespons.');
    }
}
