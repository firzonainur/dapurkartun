<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// Admin Authentication (Guest only)
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Admin Panel (Protected by Auth Middleware)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Slides CRUD
    Route::resource('slides', SlideController::class)->except(['show']);
    Route::post('slides/{slide}/toggle-active', [SlideController::class, 'toggleActive'])->name('slides.toggle-active');

    // Galleries CRUD (Supports both /admin/gallery and /admin/galleries)
    Route::resource('galleries', GalleryController::class)->except(['show']);
    Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('galleries/{gallery}/toggle-publish', [GalleryController::class, 'togglePublish'])->name('galleries.toggle-publish');
    Route::post('gallery/{gallery}/toggle-publish', [GalleryController::class, 'togglePublish'])->name('gallery.toggle-publish');

    // Testimonials CRUD
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::post('testimonials/{testimonial}/toggle-publish', [TestimonialController::class, 'togglePublish'])->name('testimonials.toggle-publish');

    // Contact Messages
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/mark-read', [AdminContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::post('contacts/{contact}/toggle-read', [AdminContactController::class, 'toggleRead'])->name('contacts.toggle-read');
    Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // Site Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

