<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'contact_email' => 'required|email|max:100',
            'contact_phone' => 'nullable|string|max:30',
            'whatsapp_number' => 'required|string|max:30',
            'studio_address' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'behance_url' => 'nullable|url|max:255',
            'about_title' => 'nullable|string|max:150',
            'about_story' => 'nullable|string|max:2000',
            'stat_illustrations' => 'nullable|string|max:50',
            'stat_characters' => 'nullable|string|max:50',
            'stat_animations' => 'nullable|string|max:50',
            'stat_creators' => 'nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan situs Dapur Kartun berhasil diperbarui.');
    }
}
