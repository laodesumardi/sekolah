<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'description',
        'image',
        'image_alt',
        'image_position',
        'button_text',
        'button_link',
        'background_color',
        'text_color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Remove 'public/' prefix if it exists
            $imagePath = str_replace('public/', '', $this->image);
            
            // Check if file exists in public storage
            $publicPath = public_path('storage/' . $imagePath);
            if (file_exists($publicPath)) {
                return asset('storage/' . $imagePath);
            }
            
            // Fallback: check if file exists in storage/app/public
            $storagePath = storage_path('app/public/' . $imagePath);
            if (file_exists($storagePath)) {
                // Try to copy file to public storage
                $publicDir = dirname($publicPath);
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }
                copy($storagePath, $publicPath);
                return asset('storage/' . $imagePath);
            }
        }
        return null;
    }
}