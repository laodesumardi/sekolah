<?php
/**
 * QUICK GALLERY FIX - Script cepat untuk memperbaiki gambar gallery
 * Akses: https://odetune.shop/QUICK_GALLERY_FIX.php
 */

echo "<h1>🚀 QUICK GALLERY FIX</h1>";

// 1. Check and create default-gallery.png
$defaultGalleryFile = 'images/default-gallery.png';

if (!file_exists($defaultGalleryFile)) {
    echo "<p>Creating default-gallery.png...</p>";
    
    // Create images directory if it doesn't exist
    if (!is_dir('images')) {
        mkdir('images', 0755, true);
    }
    
    // Create a simple placeholder image
    if (function_exists('imagecreate')) {
        $width = 300;
        $height = 200;
        $image = imagecreate($width, $height);
        
        // Set colors
        $bg_color = imagecolorallocate($image, 240, 240, 240);
        $text_color = imagecolorallocate($image, 100, 100, 100);
        $border_color = imagecolorallocate($image, 200, 200, 200);
        
        // Fill background
        imagefill($image, 0, 0, $bg_color);
        
        // Draw border
        imagerectangle($image, 0, 0, $width-1, $height-1, $border_color);
        
        // Add text
        $text = "Gallery Image";
        $font_size = 5;
        $text_width = imagefontwidth($font_size) * strlen($text);
        $text_height = imagefontheight($font_size);
        $x = ($width - $text_width) / 2;
        $y = ($height - $text_height) / 2;
        imagestring($image, $font_size, $x, $y, $text, $text_color);
        
        // Save image
        if (imagepng($image, $defaultGalleryFile)) {
            echo "<p>✅ Created default-gallery.png</p>";
        } else {
            echo "<p>❌ Failed to create default-gallery.png</p>";
        }
        
        imagedestroy($image);
    } else {
        echo "<p>❌ GD extension not available</p>";
    }
} else {
    echo "<p>✅ default-gallery.png already exists</p>";
}

// 2. Test image
echo "<h2>🖼️ Test Image</h2>";
if (file_exists($defaultGalleryFile)) {
    echo "<p>File size: " . filesize($defaultGalleryFile) . " bytes</p>";
    echo "<img src='$defaultGalleryFile' alt='Default Gallery Image' style='max-width: 300px; height: auto; border: 2px solid #007bff;'>";
    echo "<p>✅ SUCCESS! Default gallery image is now accessible!</p>";
} else {
    echo "<p>❌ Failed to create default gallery image</p>";
}

echo "<h2>🎉 QUICK FIX COMPLETE!</h2>";
echo "<p>Default gallery image should now be accessible.</p>";
?>
