<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'phone',
        'email',
        'opening_hours',
        'services',
        'rules',
        'librarian_name',
        'librarian_phone',
        'librarian_email',
        'organization_chart',
        'facilities',
        'collection_info',
        'membership_info',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getOrganizationChartUrlAttribute()
    {
        if (!$this->organization_chart) {
            return asset('struktur-organisasi-perpustakaan.png');
        }
        
        // Check if it's already a full URL
        if (filter_var($this->organization_chart, FILTER_VALIDATE_URL)) {
            return $this->organization_chart;
        }
        
        // Check if it's a storage path
        if (str_starts_with($this->organization_chart, 'libraries/')) {
            // Check if file exists in public storage symlink
            $publicStoragePath = public_path('storage/' . $this->organization_chart);
            if (file_exists($publicStoragePath)) {
                return asset('storage/' . $this->organization_chart);
            }

            // Check if file exists in public/libraries (direct symlink mapping)
            $publicLibrariesPath = public_path($this->organization_chart);
            if (file_exists($publicLibrariesPath)) {
                return asset($this->organization_chart);
            }
            
            // Check if file exists in storage/app/public
            $storagePath = storage_path('app/public/' . $this->organization_chart);
            if (file_exists($storagePath)) {
                // Try to copy file to public storage for hosting without symlink
                $publicDir = dirname($publicStoragePath);
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }
                @copy($storagePath, $publicStoragePath);
                return asset('storage/' . $this->organization_chart);
            }
            
            // Fallback to public file
            return asset('struktur-organisasi-perpustakaan.png');
        }
        
        // Check if it's a storage path with storage/ prefix
        if (str_starts_with($this->organization_chart, 'storage/')) {
            return asset($this->organization_chart);
        }
        
        // Check if it's a public file (not in storage)
        if (!str_starts_with($this->organization_chart, 'libraries/') && 
            !str_starts_with($this->organization_chart, 'storage/')) {
            // It's a public file
            return asset($this->organization_chart);
        }
        
        // Default fallback
        return asset('struktur-organisasi-perpustakaan.png');
    }
}
