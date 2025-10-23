<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class SchoolProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = SchoolProfile::orderBy('sort_order')->get();
        return view('admin.school-profile.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string|max:255|unique:school_profiles,section_key',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $data = $request->all();

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
                // Store directly in storage (public disk)
                $path = $image->storeAs('school-profiles', $imageName, 'public');
                $data['image'] = $path;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        SchoolProfile::create($data);

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profile.show', compact('schoolProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolProfile $schoolProfile)
    {
        // Check if this is the visi-misi section (ID 3)
        if ($schoolProfile->id == 3 && $schoolProfile->section_key == 'visi-misi') {
            return view('admin.school-profile.edit-visi-misi', compact('schoolProfile'));
        }
        
        // Determine if this is a section-based profile or complete profile
        $isSectionBased = !empty($schoolProfile->section_key);
        
        if ($isSectionBased) {
            // For section-based profiles, use the section edit form
            return view('admin.school-profile.edit-section', compact('schoolProfile'));
        } else {
            // For complete profiles, use the full edit form
            return view('admin.school-profile.edit', compact('schoolProfile'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolProfile $schoolProfile)
    {
        // Check if this is the visi-misi section (ID 3) - only allow image upload
        if ($schoolProfile->id == 3 && $schoolProfile->section_key == 'visi-misi') {
            $request->validate([
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_alt' => 'nullable|string|max:255',
            ], [
                'image.file' => 'The image must be a valid file.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
                'image.max' => 'The image may not be greater than 5MB.',
            ]);

            // Only update image-related fields, preserve all other content
            $data = [];
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Validate file
                if (!$image->isValid()) {
                    return redirect()->back()->withErrors(['image' => 'File gambar tidak valid.']);
                }
                
                // Delete old image if exists (normalize path)
                if ($schoolProfile->image) {
                    $oldPath = $schoolProfile->image;
                    if (str_starts_with($oldPath, 'storage/')) {
                        $oldPath = str_replace('storage/', '', $oldPath);
                    }
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                // Store new image in storage (public disk)
                $imagePath = $image->store('school-profiles', 'public');
                $data['image'] = $imagePath;
            }
            
            if ($request->filled('image_alt')) {
                $data['image_alt'] = $request->image_alt;
            }
            
            // Update only the image fields
            if (!empty($data)) {
                $schoolProfile->update($data);
            }
            
            return redirect()->route('admin.school-profile.index')
                ->with('success', 'Gambar Visi & Misi berhasil diperbarui!');
        }
        
        // Determine if this is a section-based profile or complete profile
        $isSectionBased = !empty($schoolProfile->section_key);
        
        if ($isSectionBased) {
            // Handle section-based profile update
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_alt' => 'nullable|string|max:255',
                'image_2' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_2_alt' => 'nullable|string|max:255',
                'image_3' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_3_alt' => 'nullable|string|max:255',
                'image_4' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_4_alt' => 'nullable|string|max:255',
                'is_active' => 'boolean'
            ], [
                'image.file' => 'The image must be a valid file.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
                'image.max' => 'The image may not be greater than 5MB.',
                'image_2.file' => 'The image 2 must be a valid file.',
                'image_2.mimes' => 'The image 2 must be a file of type: jpeg, png, jpg, gif, svg, webp.',
                'image_2.max' => 'The image 2 may not be greater than 5MB.',
                'image_3.file' => 'The image 3 must be a valid file.',
                'image_3.mimes' => 'The image 3 must be a file of type: jpeg, png, jpg, gif, svg, webp.',
                'image_3.max' => 'The image 3 may not be greater than 5MB.',
                'image_4.file' => 'The image 4 must be a valid file.',
                'image_4.mimes' => 'The image 4 must be a file of type: jpeg, png, jpg, gif, svg, webp.',
                'image_4.max' => 'The image 4 may not be greater than 5MB.',
            ]);

            $data = $request->all();

            // Handle image upload for section-based profiles
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Validate file
                if (!$image->isValid()) {
                    return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
                }
                
                // Delete old image if exists (storage only)
                if ($schoolProfile->image) {
                    $oldPath = $schoolProfile->image;
                    if (str_starts_with($oldPath, 'storage/')) {
                        $oldPath = str_replace('storage/', '', $oldPath);
                    } elseif (str_starts_with($oldPath, 'uploads/school-profiles/')) {
                        $oldPath = 'school-profiles/' . basename($oldPath);
                    }
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                // Generate safe filename
                $originalName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                $imageName = time() . '_' . $safeName . '.' . $extension;
                
                try {
                    // Store directly in storage (public disk)
                    $path = $image->storeAs('school-profiles', $imageName, 'public');
                    $data['image'] = $path;
                } catch (Exception $e) {
                    return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
                }
            }

            // Handle additional image uploads
            $additionalImages = ['image_2', 'image_3', 'image_4'];
            foreach ($additionalImages as $imageField) {
                if ($request->hasFile($imageField)) {
                    $image = $request->file($imageField);
                    
                    // Validate file
                    if (!$image->isValid()) {
                        return redirect()->back()->withErrors([$imageField => 'Invalid file upload.']);
                    }
                    
                    // Delete old image if exists (storage only)
                    $oldImagePath = $schoolProfile->$imageField;
                    if ($oldImagePath) {
                        $normalized = $oldImagePath;
                        if (str_starts_with($normalized, 'storage/')) {
                            $normalized = str_replace('storage/', '', $normalized);
                        } elseif (str_starts_with($normalized, 'uploads/school-profiles/')) {
                            $normalized = 'school-profiles/' . basename($normalized);
                        }
                        if (Storage::disk('public')->exists($normalized)) {
                            Storage::disk('public')->delete($normalized);
                        }
                    }
                    
                    // Generate safe filename
                    $originalName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $imageName = time() . '_' . $imageField . '_' . $safeName . '.' . $extension;
                    
                    try {
                        // Store directly in storage (public disk)
                        $path = $image->storeAs('school-profiles', $imageName, 'public');
                        $data[$imageField] = $path;
                    } catch (Exception $e) {
                        return redirect()->back()->withErrors([$imageField => 'Failed to upload image: ' . $e->getMessage()]);
                    }
                }
            }

            $schoolProfile->update($data);

            // Files served via storage symlink; no manual copy to public needed.

            // Files served via storage symlink; no manual copy to public needed for additional images.

            return redirect()->route('admin.school-profile.index')
                ->with('success', 'Section berhasil diperbarui!');
        } else {
            // Handle complete profile update
            $request->validate([
                'school_name' => 'required|string|max:255',
                'history' => 'required|string',
                'established_year' => 'required|string',
                'location' => 'required|string|max:255',
                'vision' => 'required|string',
                'mission' => 'required|string',
                'headmaster_name' => 'required|string|max:255',
                'headmaster_position' => 'required|string|max:255',
                'headmaster_education' => 'required|string|max:255',
                'accreditation_status' => 'required|string|max:255',
                'accreditation_number' => 'required|string|max:255',
                'accreditation_year' => 'required|string',
                'accreditation_score' => 'required|integer',
                'accreditation_valid_until' => 'required|string',
            ]);

            $schoolProfile->update($request->all());

            return redirect()->route('admin.school-profile.index')
                ->with('success', 'Profil sekolah berhasil diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolProfile $schoolProfile)
    {
        $schoolProfile->delete();

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil dihapus!');
    }

    /**
     * Edit hero section specifically
     */
    public function editHero()
    {
        $heroSection = SchoolProfile::where('section_key', 'hero')->first();
        
        if (!$heroSection) {
            // Create hero section if doesn't exist
            $heroSection = SchoolProfile::create([
                'section_key' => 'hero',
                'title' => 'Hero Section',
                'content' => 'Welcome to SMP Negeri 01 Namrole',
                'is_active' => true,
                'sort_order' => 0
            ]);
        }
        
        return view('admin.school-profile.edit-hero', compact('heroSection'));
    }

    /**
     * Update hero section
     */
    public function updateHero(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $heroSection = SchoolProfile::where('section_key', 'hero')->first();
        
        if (!$heroSection) {
            return redirect()->back()->withErrors(['error' => 'Hero section not found.']);
        }

        $data = $request->all();

        // Handle image upload for hero section
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Delete old image if exists
            if ($heroSection->image && Storage::disk('public')->exists($heroSection->image)) {
                Storage::disk('public')->delete($heroSection->image);
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store in storage using Laravel Storage facade (no copy to public)
                $path = $image->storeAs('school-profiles', $imageName, 'public');
                $data['image'] = $path;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        $heroSection->update($data);

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Hero section updated successfully.');
    }

    /**
     * Edit struktur organisasi section
     */
    public function editStruktur()
    {
        $strukturSection = SchoolProfile::where('section_key', 'struktur')->first();
        
        if (!$strukturSection) {
            // Create struktur section if doesn't exist
            $strukturSection = SchoolProfile::create([
                'section_key' => 'struktur',
                'title' => 'Struktur Organisasi SMP Negeri 01 Namrole',
                'content' => 'Struktur organisasi sekolah yang menunjukkan hierarki kepemimpinan dan pembagian tugas di SMP Negeri 01 Namrole.',
                'image' => 'Struktur Organisasi.png',
                'is_active' => true,
                'sort_order' => 3
            ]);
        }
        
        return view('admin.school-profile.edit-struktur', compact('strukturSection'));
    }

    /**
     * Update struktur organisasi section
     */
    public function updateStruktur(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $strukturSection = SchoolProfile::where('section_key', 'struktur')->first();
        
        if (!$strukturSection) {
            return redirect()->back()->withErrors(['error' => 'Struktur organisasi section not found.']);
        }

        $data = $request->all();

        // Handle image upload for struktur section
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Delete old image if exists (storage only)
            if ($strukturSection->image) {
                $oldPath = $strukturSection->image;
                if (str_starts_with($oldPath, 'storage/')) {
                    $oldPath = str_replace('storage/', '', $oldPath);
                } elseif (str_starts_with($oldPath, 'uploads/school-profiles/')) {
                    $oldPath = 'school-profiles/' . basename($oldPath);
                }
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store directly in storage (public disk)
                $path = $image->storeAs('school-profiles', $imageName, 'public');
                $data['image'] = $path;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        $strukturSection->update($data);

        // Files served via storage symlink; no manual copy to public needed.

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Struktur organisasi updated successfully.');
    }
}
