<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use App\Services\HtmlSanitizer;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::with(['category', 'author']);

        // Search by title or excerpt
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $news = $query->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(10)
            ->withQueryString();

        $categories = NewsCategory::orderBy('name', 'asc')->get();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create(): View
    {
        $categories = NewsCategory::orderBy('name', 'asc')->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $slug = !empty($validated['slug'])
            ? News::generateUniqueSlug($validated['slug'])
            : News::generateUniqueSlug($validated['title']);

        // Thumbnail resolution
        $thumbnail = 'images/slides/slide-1-dapur-imajinasi.svg';
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('news', 'public');
            $thumbnail = 'storage/' . $path;
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnail = $validated['thumbnail_url'];
        }

        // Publication date & status resolution
        $status = $validated['status'];
        $publishedAt = null;

        if ($status === 'published') {
            $publishedAt = !empty($validated['published_at'])
                ? Carbon::parse($validated['published_at'], 'Asia/Jakarta')
                : Carbon::now('Asia/Jakarta');
        } elseif ($status === 'scheduled') {
            $publishedAt = !empty($validated['published_at'])
                ? Carbon::parse($validated['published_at'], 'Asia/Jakarta')
                : Carbon::now('Asia/Jakarta')->addDay();
        } elseif (!empty($validated['published_at'])) {
            $publishedAt = Carbon::parse($validated['published_at'], 'Asia/Jakarta');
        }

        // Sanitize rich text content against XSS
        $cleanContent = HtmlSanitizer::clean($validated['content']);

        $news = News::create([
            'category_id' => $validated['category_id'] ?? null,
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content' => $cleanContent,
            'thumbnail' => $thumbnail,
            'status' => $status,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
            'seo_title' => !empty($validated['seo_title']) ? $validated['seo_title'] : $validated['title'],
            'seo_description' => !empty($validated['seo_description']) ? $validated['seo_description'] : $validated['excerpt'],
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', "Artikel '{$news->title}' berhasil disimpan.");
    }

    public function edit(News $news): View
    {
        $categories = NewsCategory::orderBy('name', 'asc')->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $validated = $request->validated();

        $slug = !empty($validated['slug'])
            ? News::generateUniqueSlug($validated['slug'], $news->id)
            : News::generateUniqueSlug($validated['title'], $news->id);

        $thumbnail = $news->thumbnail;

        if ($request->hasFile('thumbnail_file')) {
            // Delete old uploaded thumbnail safely if stored in public storage
            if (!empty($news->thumbnail) && Str::startsWith($news->thumbnail, 'storage/news/')) {
                $oldPath = Str::after($news->thumbnail, 'storage/');
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('thumbnail_file')->store('news', 'public');
            $thumbnail = 'storage/' . $path;
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnail = $validated['thumbnail_url'];
        }

        // Publication date & status resolution
        $status = $validated['status'];
        $publishedAt = $news->published_at;

        if ($status === 'published') {
            $publishedAt = !empty($validated['published_at'])
                ? Carbon::parse($validated['published_at'], 'Asia/Jakarta')
                : ($news->published_at ?? Carbon::now('Asia/Jakarta'));
        } elseif ($status === 'scheduled') {
            $publishedAt = !empty($validated['published_at'])
                ? Carbon::parse($validated['published_at'], 'Asia/Jakarta')
                : Carbon::now('Asia/Jakarta')->addDay();
        } elseif (!empty($validated['published_at'])) {
            $publishedAt = Carbon::parse($validated['published_at'], 'Asia/Jakarta');
        }

        // Sanitize rich text content against XSS
        $cleanContent = HtmlSanitizer::clean($validated['content']);

        $news->update([
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content' => $cleanContent,
            'thumbnail' => $thumbnail,
            'status' => $status,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
            'seo_title' => !empty($validated['seo_title']) ? $validated['seo_title'] : $validated['title'],
            'seo_description' => !empty($validated['seo_description']) ? $validated['seo_description'] : $validated['excerpt'],
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', "Artikel '{$news->title}' berhasil diperbarui.");
    }

    public function destroy(News $news): RedirectResponse
    {
        $title = $news->title;

        // Clean up uploaded thumbnail
        if (!empty($news->thumbnail) && Str::startsWith($news->thumbnail, 'storage/news/')) {
            $path = Str::after($news->thumbnail, 'storage/');
            Storage::disk('public')->delete($path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', "Artikel '{$title}' berhasil dihapus.");
    }

    public function preview(News $news): View
    {
        $relatedNews = News::where('id', '!=', $news->id)
            ->when($news->category_id, fn ($q) => $q->where('category_id', $news->category_id))
            ->latest('created_at')
            ->take(3)
            ->get();

        $isPreview = true;

        return view('news.show', compact('news', 'relatedNews', 'isPreview'));
    }
}
