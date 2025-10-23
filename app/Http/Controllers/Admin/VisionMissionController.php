<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VisionMissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visionMissions = VisionMission::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vision-missions.index', compact('visionMissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vision-missions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vision' => 'required|string',
            'missions' => 'required|array|min:1',
            'missions.*' => 'required|string|max:500',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store in storage using Laravel Storage facade
                $path = $image->storeAs('vision-missions', $imageName, 'public');
                $data['image'] = $path;
                
                // Copy to public directory for immediate access
                copy_storage_to_public($path);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        VisionMission::create($data);

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Visi & Misi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VisionMission $visionMission)
    {
        return view('admin.vision-missions.show', compact('visionMission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisionMission $visionMission)
    {
        return view('admin.vision-missions.edit', compact('visionMission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisionMission $visionMission)
    {
        $request->validate([
            'vision' => 'required|string',
            'missions' => 'required|array|min:1',
            'missions.*' => 'required|string|max:500',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Delete old image if exists
            if ($visionMission->image && Storage::disk('public')->exists($visionMission->image)) {
                Storage::disk('public')->delete($visionMission->image);
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store in storage using Laravel Storage facade
                $path = $image->storeAs('vision-missions', $imageName, 'public');
                $data['image'] = $path;
                
                // Copy to public directory for immediate access
                copy_storage_to_public($path);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        $visionMission->update($data);

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisionMission $visionMission)
    {
        // Delete image if exists
        if ($visionMission->image && Storage::disk('public')->exists($visionMission->image)) {
            Storage::disk('public')->delete($visionMission->image);
        }

        $visionMission->delete();

        return redirect()->route('admin.vision-missions.index')
            ->with('success', 'Visi & Misi berhasil dihapus.');
    }
}