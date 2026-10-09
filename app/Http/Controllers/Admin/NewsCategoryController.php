<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsCategoryRequest;
use App\Http\Requests\Admin\UpdateNewsCategoryRequest;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = NewsCategory::withCount('news');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('name', 'asc')->paginate(15)->withQueryString();

        return view('admin.news.categories', compact('categories'));
    }

    public function store(StoreNewsCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $slug = !empty($validated['slug'])
            ? NewsCategory::generateUniqueSlug($validated['slug'])
            : NewsCategory::generateUniqueSlug($validated['name']);

        NewsCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.news-categories.index')
            ->with('success', "Kategori '{$validated['name']}' berhasil ditambahkan.");
    }

    public function update(UpdateNewsCategoryRequest $request, NewsCategory $newsCategory): RedirectResponse
    {
        $validated = $request->validated();

        $slug = !empty($validated['slug'])
            ? NewsCategory::generateUniqueSlug($validated['slug'], $newsCategory->id)
            : NewsCategory::generateUniqueSlug($validated['name'], $newsCategory->id);

        $newsCategory->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.news-categories.index')
            ->with('success', "Kategori '{$validated['name']}' berhasil diperbarui.");
    }

    public function destroy(NewsCategory $newsCategory): RedirectResponse
    {
        $count = $newsCategory->news()->count();

        if ($count > 0) {
            return redirect()->route('admin.news-categories.index')
                ->with('error', "Kategori '{$newsCategory->name}' tidak dapat dihapus karena masih digunakan oleh {$count} artikel. Silakan pindahkan artikel ke kategori lain terlebih dahulu.");
        }

        $name = $newsCategory->name;
        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus.");
    }
}
