<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::published()->with(['category', 'author']);

        // Search by title or excerpt
        if ($request->filled('search')) {
            $search = trim($request->get('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category slug
        $activeCategory = null;
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $categorySlug = $request->kategori;
            $activeCategory = NewsCategory::where('slug', $categorySlug)->first();

            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        // Identify featured news for the hero banner when not searching and on page 1
        $featuredNews = null;
        if (!$request->filled('search') && (!$request->filled('page') || $request->page == 1) && !$activeCategory) {
            $featuredNews = News::published()
                ->where('is_featured', true)
                ->latest('published_at')
                ->first();

            // If a featured article is selected, exclude it from main list so it does not repeat
            if ($featuredNews) {
                $query->where('id', '!=', $featuredNews->id);
            }
        }

        $newsList = $query->orderBy('published_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        // Get categories with count of published articles
        $categories = NewsCategory::withCount(['news' => function ($q) {
            $q->published();
        }])->orderBy('name', 'asc')->get();

        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('news.index', compact('newsList', 'featuredNews', 'categories', 'activeCategory', 'settings'));
    }

    public function show(string $slug): View
    {
        // Public users can ONLY view published articles whose time has arrived
        $news = News::published()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Related articles: same category preferred, max 3
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->when($news->category_id, fn ($q) => $q->where('category_id', $news->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedNews->count() < 3) {
            $existingIds = $relatedNews->pluck('id')->push($news->id)->toArray();
            $moreNews = News::published()
                ->whereNotIn('id', $existingIds)
                ->latest('published_at')
                ->take(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->concat($moreNews);
        }

        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('news.show', compact('news', 'relatedNews', 'settings'));
    }
}
