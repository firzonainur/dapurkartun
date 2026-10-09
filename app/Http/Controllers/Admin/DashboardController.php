<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Slide;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $galleryCount = Gallery::count();
        $activeSlideCount = Slide::where('is_active', true)->count();
        $totalSlideCount = Slide::count();
        $testimonialCount = Testimonial::count();
        $unreadContactCount = Contact::where('is_read', false)->count();
        $totalContactCount = Contact::count();

        $recentContacts = Contact::orderBy('created_at', 'desc')->take(5)->get();
        $recentGalleries = Gallery::orderBy('created_at', 'desc')->take(4)->get();

        return view('admin.dashboard', compact(
            'galleryCount',
            'activeSlideCount',
            'totalSlideCount',
            'testimonialCount',
            'unreadContactCount',
            'totalContactCount',
            'recentContacts',
            'recentGalleries'
        ));
    }
}
