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
            return null;
        }
        
        // Check if it's already a full URL
        if (filter_var($this->organization_chart, FILTER_VALIDATE_URL)) {
            return $this->organization_chart;
        }
        
        // Check if it's a storage path
        if (str_starts_with($this->organization_chart, 'libraries/')) {
            // Check if file exists in public storage
            $publicPath = public_path('storage/' . $this->organization_chart);
            if (file_exists($publicPath)) {
                return get_correct_asset_url('storage/' . $this->organization_chart);
            }
            
            // Check if file exists in storage/app/public
            $storagePath = storage_path('app/public/' . $this->organization_chart);
            if (file_exists($storagePath)) {
                // Try to copy file to public storage
                $publicDir = dirname($publicPath);
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }
                copy($storagePath, $publicPath);
                return get_correct_asset_url('storage/' . $this->organization_chart);
            }
            
            // Fallback to default image
            return get_correct_asset_url('images/default-struktur.png');
        }
        
        // Check if it's a storage path with storage/ prefix
        if (str_starts_with($this->organization_chart, 'storage/')) {
            return get_correct_asset_url($this->organization_chart);
        }
        
        // Check if it's a public file (not in storage)
        if (!str_starts_with($this->organization_chart, 'libraries/') && 
            !str_starts_with($this->organization_chart, 'storage/')) {
            // It's a public file
            return get_correct_asset_url($this->organization_chart);
        }
        
        // Default fallback
        return get_correct_asset_url('images/default-struktur.png');
    }
}
