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
        $activeSlideCount = Slide::where('is_active', true)->count();
        $totalSlideCount = Slide::count();

        $publishedGalleryCount = Gallery::where('is_published', true)->count();
        $totalGalleryCount = Gallery::count();

        $publishedTestimonialCount = Testimonial::where('is_published', true)->count();
        $totalTestimonialCount = Testimonial::count();

        $unreadContactCount = Contact::where('is_read', false)->count();
        $totalContactCount = Contact::count();

        $recentContacts = Contact::orderBy('created_at', 'desc')->take(5)->get();

        // Aktivitas pengelolaan konten terbaru
        $recentActivities = collect();

        foreach (Gallery::latest('updated_at')->take(4)->get() as $item) {
            $recentActivities->push([
                'type' => 'Galeri',
                'badge' => 'Galeri',
                'title' => $item->title,
                'status' => $item->is_published ? 'Dipublikasikan' : 'Draf',
                'status_class' => $item->is_published ? 'badge-success' : 'badge-warning',
                'time' => $item->updated_at,
                'edit_url' => route('admin.galleries.edit', $item->id),
            ]);
        }

        foreach (Slide::latest('updated_at')->take(4)->get() as $item) {
            $recentActivities->push([
                'type' => 'Slider',
                'badge' => 'Slide',
                'title' => $item->title,
                'status' => $item->is_active ? 'Aktif' : 'Nonaktif',
                'status_class' => $item->is_active ? 'badge-success' : 'badge-warning',
                'time' => $item->updated_at,
                'edit_url' => route('admin.slides.edit', $item->id),
            ]);
        }

        foreach (Testimonial::latest('updated_at')->take(4)->get() as $item) {
            $recentActivities->push([
                'type' => 'Testimoni',
                'badge' => 'Testimoni',
                'title' => $item->customer_name . ' (' . $item->role . ')',
                'status' => $item->is_published ? 'Aktif' : 'Disembunyikan',
                'status_class' => $item->is_published ? 'badge-success' : 'badge-warning',
                'time' => $item->updated_at,
                'edit_url' => route('admin.testimonials.edit', $item->id),
            ]);
        }

        $recentActivities = $recentActivities->sortByDesc('time')->take(5);

        return view('admin.dashboard', compact(
            'activeSlideCount',
            'totalSlideCount',
            'publishedGalleryCount',
            'totalGalleryCount',
            'publishedTestimonialCount',
            'totalTestimonialCount',
            'unreadContactCount',
            'totalContactCount',
            'recentContacts',
            'recentActivities'
        ));
    }
}

