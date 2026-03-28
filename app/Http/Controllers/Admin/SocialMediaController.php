<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display social media management page
     */
    public function index()
    {
        $socialMedia = SocialMedia::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.social-media.index', compact('socialMedia'));
    }

    /**
     * Show the form for creating a new social media
     */
    public function create()
    {
        return view('admin.social-media.create');
    }

    /**
     * Store a newly created social media
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'color' => 'required|string|max:7',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['icon'] = $data['name']; // Set icon same as name for now
        $data['is_active'] = $request->has('is_active');

        SocialMedia::create($data);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Sosial media berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified social media
     */
    public function edit(SocialMedia $social_medium)
    {
        return view('admin.social-media.edit', compact('social_medium'));
    }

    /**
     * Update the specified social media
     */
    public function update(Request $request, SocialMedia $social_medium)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'color' => 'required|string|max:7',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['icon'] = $data['name']; // Set icon same as name for now
        $data['is_active'] = $request->has('is_active');

        $social_medium->update($data);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Sosial media berhasil diperbarui!');
    }

    /**
     * Remove the specified social media
     */
    public function destroy(SocialMedia $social_medium)
    {
        $social_medium->delete();

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Sosial media berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(SocialMedia $social_medium)
    {
        $oldStatus = $social_medium->is_active;
        $social_medium->update(['is_active' => !$social_medium->is_active]);

        $status = $oldStatus ? 'dinonaktifkan' : 'diaktifkan';
        return redirect()->route('admin.social-media.index')
            ->with('success', "Sosial media {$social_medium->name} berhasil {$status}!");
    }
}
