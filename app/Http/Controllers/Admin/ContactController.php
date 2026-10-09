<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contact::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->get('filter') === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->get('filter') === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $unreadCount = Contact::where('is_read', false)->count();
        $totalCount = Contact::count();

        return view('admin.contacts.index', compact('messages', 'unreadCount', 'totalCount'));
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
        return back()->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    public function toggleRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => !$contact->is_read]);
        $status = $contact->is_read ? 'sudah dibaca' : 'belum dibaca';
        return back()->with('success', "Status pesan berhasil diubah menjadi {$status}.");
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
