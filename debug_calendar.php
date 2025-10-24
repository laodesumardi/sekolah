<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUGGING CALENDAR IMAGE ISSUE ===\n\n";

// Check academic calendar section
$section = App\Models\HomeSection::where('section_key', 'academic-calendar')->first();

if ($section) {
    echo "✅ Section found:\n";
    echo "ID: " . $section->id . "\n";
    echo "Title: " . $section->title . "\n";
    echo "Image: " . $section->image . "\n";
    echo "Is Active: " . ($section->is_active ? 'Yes' : 'No') . "\n";
    echo "Created: " . $section->created_at . "\n";
    echo "Updated: " . $section->updated_at . "\n\n";
    
    // Check image file
    if ($section->image) {
        $imagePath = public_path('uploads/' . $section->image);
        echo "Image Path: " . $imagePath . "\n";
        
        if (file_exists($imagePath)) {
            echo "✅ Image file exists\n";
            echo "File size: " . filesize($imagePath) . " bytes\n";
            
            // Test asset URL
            $assetUrl = asset('uploads/' . $section->image);
            echo "Asset URL: " . $assetUrl . "\n";
            
        } else {
            echo "❌ Image file not found at: " . $imagePath . "\n";
        }
    } else {
        echo "❌ No image set in database\n";
    }
} else {
    echo "❌ Section not found\n";
}

echo "\n=== CHECKING VIEW LOGIC ===\n";
if ($section && $section->image) {
    echo "View will use: asset('uploads/" . $section->image . "')\n";
    echo "Full path: " . asset('uploads/' . $section->image) . "\n";
} else {
    echo "View will use fallback: asset('images/default-hero.png')\n";
    echo "Fallback path: " . asset('images/default-hero.png') . "\n";
}

echo "\n=== CHECKING FALLBACK IMAGE ===\n";
$fallbackPath = public_path('images/default-hero.png');
if (file_exists($fallbackPath)) {
    echo "✅ Fallback image exists: " . $fallbackPath . "\n";
    echo "Fallback size: " . filesize($fallbackPath) . " bytes\n";
} else {
    echo "❌ Fallback image not found: " . $fallbackPath . "\n";
}
?>



