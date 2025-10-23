<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'school_name',
        'history',
        'established_year',
        'location',
        'vision',
        'mission',
        'headmaster_name',
        'headmaster_position',
        'headmaster_education',
        'accreditation_status',
        'accreditation_number',
        'accreditation_year',
        'accreditation_score',
        'accreditation_valid_until',
        'section_key',
        'title',
        'content',
        'subtitle',
        'description',
        'image',
        'image_alt',
        'image_2',
        'image_2_alt',
        'image_3',
        'image_3_alt',
        'image_4',
        'image_4_alt',
        'button_text',
        'button_link',
        'background_color',
        'text_color',
        'is_active',
        'sort_order',
        'extra_data'
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySection($query, $sectionKey)
    {
        return $query->where('section_key', $sectionKey);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return get_correct_asset_url('images/default-school-profile.png');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        
        if (str_starts_with($this->image, 'storage/')) {
            return get_correct_asset_url($this->image);
        }
        
        if (str_starts_with($this->image, 'school-profiles/')) {
            return get_correct_asset_url('storage/' . $this->image);
        }
        
        if (str_starts_with($this->image, 'uploads/school-profiles/')) {
            return get_correct_asset_url(str_replace('uploads/school-profiles/', 'storage/school-profiles/', $this->image));
        }
        
        if (!str_contains($this->image, '/')) {
            return get_correct_asset_url('storage/school-profiles/' . $this->image);
        }
        
        return get_correct_asset_url('images/default-school-profile.png');
    }

    public function getImage2UrlAttribute()
    {
        if (!$this->image_2) {
            return null;
        }
        
        if (filter_var($this->image_2, FILTER_VALIDATE_URL)) {
            return $this->image_2;
        }
        
        if (str_starts_with($this->image_2, 'http://') || str_starts_with($this->image_2, 'https://')) {
            return $this->image_2;
        }
        
        if (str_starts_with($this->image_2, 'storage/')) {
            return get_correct_asset_url($this->image_2);
        }
        
        if (str_starts_with($this->image_2, 'school-profiles/')) {
            return get_correct_asset_url('storage/' . $this->image_2);
        }
        
        if (str_starts_with($this->image_2, 'uploads/school-profiles/')) {
            return get_correct_asset_url(str_replace('uploads/school-profiles/', 'storage/school-profiles/', $this->image_2));
        }
        
        if (!str_contains($this->image_2, '/')) {
            return get_correct_asset_url('storage/school-profiles/' . $this->image_2);
        }
        
        return null;
    }

    public function getImage3UrlAttribute()
    {
        if (!$this->image_3) {
            return null;
        }
        
        if (filter_var($this->image_3, FILTER_VALIDATE_URL)) {
            return $this->image_3;
        }
        
        if (str_starts_with($this->image_3, 'http://') || str_starts_with($this->image_3, 'https://')) {
            return $this->image_3;
        }
        
        if (str_starts_with($this->image_3, 'storage/')) {
            return get_correct_asset_url($this->image_3);
        }
        
        if (str_starts_with($this->image_3, 'school-profiles/')) {
            return get_correct_asset_url('storage/' . $this->image_3);
        }
        
        if (str_starts_with($this->image_3, 'uploads/school-profiles/')) {
            return get_correct_asset_url(str_replace('uploads/school-profiles/', 'storage/school-profiles/', $this->image_3));
        }
        
        if (!str_contains($this->image_3, '/')) {
            return get_correct_asset_url('storage/school-profiles/' . $this->image_3);
        }
        
        return null;
    }

    public function getImage4UrlAttribute()
    {
        if (!$this->image_4) {
            return null;
        }
        
        if (filter_var($this->image_4, FILTER_VALIDATE_URL)) {
            return $this->image_4;
        }
        
        if (str_starts_with($this->image_4, 'http://') || str_starts_with($this->image_4, 'https://')) {
            return $this->image_4;
        }
        
        if (str_starts_with($this->image_4, 'storage/')) {
            return get_correct_asset_url($this->image_4);
        }
        
        if (str_starts_with($this->image_4, 'school-profiles/')) {
            return get_correct_asset_url('storage/' . $this->image_4);
        }
        
        if (str_starts_with($this->image_4, 'uploads/school-profiles/')) {
            return get_correct_asset_url(str_replace('uploads/school-profiles/', 'storage/school-profiles/', $this->image_4));
        }
        
        if (!str_contains($this->image_4, '/')) {
            return get_correct_asset_url('storage/school-profiles/' . $this->image_4);
        }
        
        return null;
    }
}
