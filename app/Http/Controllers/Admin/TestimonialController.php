<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'role' => 'nullable|string|max:100',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'avatar_url' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
            'sort_order' => 'required|integer|min:0',
            'is_published' => 'nullable|boolean',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'message.required' => 'Isi testimoni wajib diisi.',
            'rating.required' => 'Rating wajib dipilih antara 1 sampai 5.',
        ]);

        $avatarPath = 'images/avatars/avatar-1.svg';

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('testimonials', 'public');
            $avatarPath = 'storage/' . $path;
        } elseif (!empty($validated['avatar_url'])) {
            $avatarPath = $validated['avatar_url'];
        }

        Testimonial::create([
            'customer_name' => $validated['customer_name'],
            'role' => $validated['role'] ?? null,
            'avatar' => $avatarPath,
            'message' => $validated['message'],
            'rating' => $validated['rating'],
            'sort_order' => $validated['sort_order'],
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'role' => 'nullable|string|max:100',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'avatar_url' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
            'sort_order' => 'required|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);

        $avatarPath = $testimonial->avatar;

        if ($request->hasFile('avatar_file')) {
            if (str_starts_with($testimonial->avatar, 'storage/testimonials/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $testimonial->avatar));
            }
            $path = $request->file('avatar_file')->store('testimonials', 'public');
            $avatarPath = 'storage/' . $path;
        } elseif (!empty($validated['avatar_url'])) {
            $avatarPath = $validated['avatar_url'];
        }

        $testimonial->update([
            'customer_name' => $validated['customer_name'],
            'role' => $validated['role'] ?? null,
            'avatar' => $avatarPath,
            'message' => $validated['message'],
            'rating' => $validated['rating'],
            'sort_order' => $validated['sort_order'],
            'is_published' => $request->boolean('is_published', false),
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if (str_starts_with($testimonial->avatar, 'storage/testimonials/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $testimonial->avatar));
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }

    public function togglePublish(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_published' => !$testimonial->is_published]);
        $status = $testimonial->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Status testimoni berhasil {$status}.");
    }
}
