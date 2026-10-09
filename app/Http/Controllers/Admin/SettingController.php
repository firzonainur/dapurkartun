<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:100',
            'site_tagline' => 'nullable|string|max:200',
            'meta_title' => 'nullable|string|max:150',
            'meta_description' => 'nullable|string|max:300',
            'contact_email' => 'required|email|max:100',
            'contact_phone' => 'nullable|string|max:30',
            'whatsapp_number' => 'required|string|max:30',
            'studio_address' => 'nullable|string|max:255',
            'footer_info' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'behance_url' => 'nullable|url|max:255',
            'about_title' => 'nullable|string|max:150',
            'about_story' => 'nullable|string|max:2000',
            'stat_illustrations' => 'nullable|string|max:50',
            'stat_characters' => 'nullable|string|max:50',
            'stat_animations' => 'nullable|string|max:50',
            'stat_creators' => 'nullable|string|max:50',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'favicon_file' => 'nullable|image|mimes:jpeg,png,ico,svg|max:1024',
        ]);

        // Handle Logo upload
        if ($request->hasFile('logo_file')) {
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo && str_starts_with($oldLogo, 'storage/settings/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldLogo));
            }
            $path = $request->file('logo_file')->store('settings', 'public');
            SiteSetting::set('site_logo', 'storage/' . $path);
        }

        // Handle Favicon upload
        if ($request->hasFile('favicon_file')) {
            $oldFav = SiteSetting::get('site_favicon');
            if ($oldFav && str_starts_with($oldFav, 'storage/settings/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldFav));
            }
            $path = $request->file('favicon_file')->store('settings', 'public');
            SiteSetting::set('site_favicon', 'storage/' . $path);
        }

        unset($validated['logo_file'], $validated['favicon_file']);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan website Dapur Kartun berhasil diperbarui.');
    }
}
