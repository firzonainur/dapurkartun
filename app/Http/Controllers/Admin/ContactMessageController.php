<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contact::query();

        if ($request->get('filter') === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->get('filter') === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = Contact::where('is_read', false)->count();

        return view('admin.contacts.index', compact('messages', 'unreadCount'));
    }

    public function show(Contact $contact): View
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function markAsRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Pesan telah ditandai sebagai sudah dibaca.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
