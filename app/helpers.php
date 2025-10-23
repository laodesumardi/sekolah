<?php
use Illuminate\Support\Facades\Storage;

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

if (!function_exists('get_correct_asset_url')) {
    /**
     * Build a correct asset URL that works on hosting (HTTPS, no symlink)
     *
     * - Accepts relative paths like `images/foo.png`, `libraries/file.jpg`, or `storage/libraries/file.jpg`
     * - If `public/storage` symlink is missing, attempts to copy from `storage/app/public`
     * - Forces HTTPS when app URL or proxy indicates secure requests
     *
     * @param string $path
     * @return string
     */
    function get_correct_asset_url($path)
    {
        if (!$path) {
            return asset('images/default-section.png');
        }

        // Already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $trimmed = ltrim($path, '/');

        // Helper to decide HTTPS vs HTTP
        $useHttps = false;
        if (function_exists('config') && is_string(config('app.url')) && str_starts_with((string)config('app.url'), 'https://')) {
            $useHttps = true;
        }
        // Respect proxy headers if present
        if (!$useHttps && function_exists('request')) {
            $proto = request()->header('X-Forwarded-Proto');
            if ($proto && strtolower($proto) === 'https') {
                $useHttps = true;
            }
        }

        // If the path starts with storage/, ensure file exists in public/storage
        if (str_starts_with($trimmed, 'storage/')) {
            $subPath = substr($trimmed, strlen('storage/'));
            $publicFile = public_path($trimmed);
            if (!file_exists($publicFile)) {
                // Try to copy from storage/app/public
                @copy_storage_to_public($subPath);
                // Fallback: serve from legacy public/uploads if exists
                $legacyPath = str_starts_with($subPath, 'uploads/')
                    ? public_path($subPath)
                    : public_path('uploads/' . $subPath);
                if (file_exists($legacyPath)) {
                    $legacyUrl = str_starts_with($subPath, 'uploads/')
                        ? $subPath
                        : 'uploads/' . $subPath;
                    return $useHttps ? secure_asset($legacyUrl) : asset($legacyUrl);
                }
            }
            return $useHttps ? secure_asset($trimmed) : asset($trimmed);
        }

        // Handle legacy uploads paths explicitly (e.g., uploads/school-profiles/...)
        if (str_starts_with($trimmed, 'uploads/')) {
            $publicDirectFile = public_path($trimmed);
            if (file_exists($publicDirectFile)) {
                return $useHttps ? secure_asset($trimmed) : asset($trimmed);
            }
            // Attempt to map to storage if direct file missing
            $maybeStorage = preg_replace('#^uploads/#', 'storage/', $trimmed);
            $publicStorageFile = public_path($maybeStorage);
            if (file_exists($publicStorageFile)) {
                return $useHttps ? secure_asset($maybeStorage) : asset($maybeStorage);
            }
            // Try copying from storage/app/public when uploads was previously mirrored
            $storageSubPath = preg_replace('#^uploads/#', '', $trimmed);
            @copy_storage_to_public($storageSubPath);
            return $useHttps ? secure_asset('storage/' . $storageSubPath) : asset('storage/' . $storageSubPath);
        }

        // Common upload directories that should be served from public/storage
        $uploadDirs = [
            'libraries', 'gallery', 'gallery-items', 'galleries', 'school-profiles', 'teachers',
            'students', 'admins', 'facilities', 'home-sections', 'documents'
        ];
        foreach ($uploadDirs as $dir) {
            if (str_starts_with($trimmed, $dir . '/')) {
                $publicStorageFile = public_path('storage/' . $trimmed);
                if (file_exists($publicStorageFile)) {
                    return $useHttps ? secure_asset('storage/' . $trimmed) : asset('storage/' . $trimmed);
                }

                // If the file exists directly under public (in case of manual upload), use it
                $publicDirectFile = public_path($trimmed);
                if (file_exists($publicDirectFile)) {
                    return $useHttps ? secure_asset($trimmed) : asset($trimmed);
                }

                // Attempt to copy from storage to public/storage for hosts without symlink support
                @copy_storage_to_public($trimmed);
                return $useHttps ? secure_asset('storage/' . $trimmed) : asset('storage/' . $trimmed);
            }
        }

        // Default: treat as a normal public asset
        return $useHttps ? secure_asset($trimmed) : asset($trimmed);
    }
}