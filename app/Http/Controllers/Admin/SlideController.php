<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SlideController extends Controller
{
    public function index(): View
    {
        $slides = Slide::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.slides.index', compact('slides'));
    }

    public function create(): View
    {
        return view('admin.slides.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3072',
            'image_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:60',
            'button_url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul slide wajib diisi.',
            'image_file.image' => 'Berkas harus berupa gambar valid.',
            'image_file.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        $imagePath = 'images/slides/slide-1-dapur-imajinasi.svg';

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('slides', 'public');
            $imagePath = 'storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        Slide::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'image' => $imagePath,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(Slide $slide): View
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3072',
            'image_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:60',
            'button_url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $slide->image;

        if ($request->hasFile('image_file')) {
            // Delete old uploaded image if in storage
            if (str_starts_with($slide->image, 'storage/slides/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $slide->image));
            }
            $path = $request->file('image_file')->store('slides', 'public');
            $imagePath = 'storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        $slide->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'image' => $imagePath,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        if (str_starts_with($slide->image, 'storage/slides/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $slide->image));
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide berhasil dihapus.');
    }

    public function toggleActive(Slide $slide): RedirectResponse
    {
        $slide->update(['is_active' => !$slide->is_active]);
        $status = $slide->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status slide berhasil {$status}.");
    }
}
