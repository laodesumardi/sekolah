<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    protected $fillable = [
        'gallery_id',
        'title',
        'description',
        'image',
        'video_url',
        'type',
        'is_featured',
        'is_active',
        'sort_order',
        'metadata',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'width',
        'height',
        'duration',
        'thumbnail_path'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    // Relationships
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-gallery-item.png');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, 'gallery-items/')) {
            return asset('storage/' . $this->image);
        }
        
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }
        
        if (!str_starts_with($this->image, 'gallery-items/') && 
            !str_starts_with($this->image, 'storage/')) {
            return asset('storage/' . $this->image);
        }
        
        return asset('images/default-gallery-item.png');
    }

    public function getTypeLabelAttribute()
    {
        $types = [
            'image' => 'Gambar',
            'video' => 'Video',
            'document' => 'Dokumen'
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    // Methods
    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isVideo()
    {
        return $this->type === 'video';
    }

    public function isDocument()
    {
        return $this->type === 'document';
    }

    // Additional accessors for view compatibility
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
                return $this->file_path;
            }
            
            if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
                return $this->file_path;
            }
            
            if (str_starts_with($this->file_path, 'gallery-items/')) {
                return asset('storage/' . $this->file_path);
            }
            
            if (str_starts_with($this->file_path, 'storage/')) {
                return asset($this->file_path);
            }
            
            return asset('storage/' . $this->file_path);
        }
        
        return $this->image_url;
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) {
            return null;
        }
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getDurationFormattedAttribute()
    {
        if (!$this->duration) {
            return null;
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        if ($minutes > 0) {
            return sprintf('%d:%02d', $minutes, $seconds);
        }
        
        return sprintf('0:%02d', $seconds);
    }
}