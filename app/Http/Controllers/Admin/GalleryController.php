<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    private function getAvailableCategories(): array
    {
        $defaults = ['Ilustrasi Kartun', 'Karakter', 'Animasi', 'Desain Kreatif'];
        $fromDb = Gallery::distinct()->pluck('category')->filter()->toArray();
        return array_values(array_unique(array_merge($defaults, $fromDb)));
    }

    public function index(Request $request): View
    {
        $query = Gallery::query();

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        $galleries = $query->orderBy('sort_order', 'asc')->paginate(12)->withQueryString();
        $categories = $this->getAvailableCategories();

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    public function create(): View
    {
        $categories = $this->getAvailableCategories();
        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:50',
            'new_category' => 'nullable|string|max:50',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:4096',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul karya wajib diisi.',
            'image_file.image' => 'Berkas harus berupa gambar yang valid (JPG, PNG, WebP, SVG).',
            'image_file.max' => 'Ukuran file gambar maksimal 4MB.',
        ]);

        $category = !empty($validated['new_category']) 
            ? trim($validated['new_category']) 
            : ($validated['category'] ?? 'Ilustrasi Kartun');

        $imagePath = 'images/gallery/artwork-1-petualangan-awan.svg';

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('gallery', 'public');
            $imagePath = 'storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        Gallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => $category,
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'],
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Karya galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        $categories = $this->getAvailableCategories();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:50',
            'new_category' => 'nullable|string|max:50',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:4096',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);

        $category = !empty($validated['new_category']) 
            ? trim($validated['new_category']) 
            : ($validated['category'] ?? $gallery->category);

        $imagePath = $gallery->image;

        if ($request->hasFile('image_file')) {
            if (str_starts_with($gallery->image, 'storage/gallery/')) {
                $isUsedElsewhere = Gallery::where('id', '!=', $gallery->id)->where('image', $gallery->image)->exists()
                    || \App\Models\Slide::where('image', $gallery->image)->exists();
                if (!$isUsedElsewhere) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image));
                }
            }
            $path = $request->file('image_file')->store('gallery', 'public');
            $imagePath = 'storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        $gallery->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => $category,
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'],
            'is_published' => $request->boolean('is_published', false),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Karya galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if (str_starts_with($gallery->image, 'storage/gallery/')) {
            $isUsedElsewhere = Gallery::where('id', '!=', $gallery->id)->where('image', $gallery->image)->exists()
                || \App\Models\Slide::where('image', $gallery->image)->exists();
            if (!$isUsedElsewhere) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image));
            }
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Karya galeri berhasil dihapus.');
    }


    public function togglePublish(Gallery $gallery): RedirectResponse
    {
        $gallery->update(['is_published' => !$gallery->is_published]);
        $status = $gallery->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Status karya berhasil {$status}.");
    }
}
