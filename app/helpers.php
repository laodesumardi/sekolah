<?php

if (!function_exists('vision_mission_image_url')) {
    /**
     * Get the URL for a vision mission image
     * 
     * @param string|null $imagePath
     * @return string|null
     */
    function vision_mission_image_url($imagePath)
    {
        if (!$imagePath) {
            return null;
        }
        
        // Check if file exists in storage
        if (Storage::disk('public')->exists($imagePath)) {
            return Storage::url($imagePath);
        }
        
        // Fallback: try to access via public path
        $publicPath = public_path('storage/' . $imagePath);
        if (file_exists($publicPath)) {
            return asset('storage/' . $imagePath);
        }
        
        return null;
    }
}

if (!function_exists('copy_storage_to_public')) {
    /**
     * Copy file from storage to public directory
     * 
     * @param string $storagePath
     * @return bool
     */
    function copy_storage_to_public($storagePath)
    {
        $sourcePath = storage_path('app/public/' . $storagePath);
        $destPath = public_path('storage/' . $storagePath);
        $destDir = dirname($destPath);
        
        // Create destination directory if it doesn't exist
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }
        
        // Copy file if source exists
        if (file_exists($sourcePath)) {
            return copy($sourcePath, $destPath);
        }
        
        return false;
    }
}