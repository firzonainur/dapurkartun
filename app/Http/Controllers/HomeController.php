<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Slide;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $slides = Slide::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $galleries = Gallery::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $latestNews = News::published()
            ->with(['category', 'author'])
            ->orderByRaw('CASE WHEN is_featured = 1 THEN 0 ELSE 1 END')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        $categories = [
            'Semua',
            'Ilustrasi Kartun',
            'Karakter',
            'Animasi',
            'Desain Kreatif',
        ];

        return view('home', compact('slides', 'galleries', 'testimonials', 'latestNews', 'settings', 'categories'));
    }
}
