<?php
/**
 * FIX GALLERY IMAGES HOSTING - Script untuk memperbaiki gambar gallery di hosting
 * Akses: https://odetune.shop/FIX_GALLERY_IMAGES_HOSTING.php
 */

echo "<h1>🖼️ FIX GALLERY IMAGES HOSTING</h1>";
echo "<p>Memperbaiki masalah gambar gallery di hosting...</p>";

// 1. Check if default-gallery.png exists
echo "<h2>📁 Check Default Gallery Image</h2>";
$defaultGalleryFile = 'images/default-gallery.png';
if (file_exists($defaultGalleryFile)) {
    echo "<p>✅ default-gallery.png exists</p>";
    echo "<p>File size: " . filesize($defaultGalleryFile) . " bytes</p>";
} else {
    echo "<p>❌ default-gallery.png not found</p>";
    
    // Create a simple default gallery image
    echo "<p>Creating default gallery image...</p>";
    
    // Create images directory if it doesn't exist
    if (!is_dir('images')) {
        mkdir('images', 0755, true);
        echo "<p>✅ Created images directory</p>";
    }
    
    // Create a simple placeholder image using GD
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
}

// 2. Check other default images
echo "<h2>📁 Check Other Default Images</h2>";
$defaultImages = [
    'images/default-gallery-item.png',
    'images/default-gallery.jpg',
    'images/default-facility.png',
    'images/default-news.png',
    'images/default-school-profile.png'
];

foreach ($defaultImages as $image) {
    if (file_exists($image)) {
        echo "<p>✅ $image exists</p>";
    } else {
        echo "<p>❌ $image missing</p>";
    }
}

// 3. Test image access
echo "<h2>🔍 Test Image Access</h2>";
$testUrl = 'https://odetune.shop/images/default-gallery.png';
echo "<p>Testing image access: <a href='$testUrl' target='_blank'>$testUrl</a></p>";

// 4. Create .htaccess for images directory
echo "<h2>⚙️ Create .htaccess for Images</h2>";
$htaccessContent = '
# MIME types for images
<IfModule mod_mime.c>
    AddType image/png .png
    AddType image/jpeg .jpg .jpeg
    AddType image/gif .gif
    AddType image/webp .webp
</IfModule>

# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE image/png
    AddOutputFilterByType DEFLATE image/jpeg
    AddOutputFilterByType DEFLATE image/gif
</IfModule>

# Cache control
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
</IfModule>
';

$htaccessFile = 'images/.htaccess';
if (file_put_contents($htaccessFile, $htaccessContent)) {
    echo "<p>✅ Created .htaccess for images directory</p>";
} else {
    echo "<p>❌ Failed to create .htaccess for images directory</p>";
}

// 5. Test all default images
echo "<h2>🧪 Test All Default Images</h2>";
$testImages = [
    'default-gallery.png',
    'default-gallery-item.png',
    'default-facility.png',
    'default-news.png',
    'default-school-profile.png'
];

foreach ($testImages as $image) {
    $imagePath = "images/$image";
    if (file_exists($imagePath)) {
        echo "<p>✅ <a href='$imagePath' target='_blank'>$image</a> - " . filesize($imagePath) . " bytes</p>";
    } else {
        echo "<p>❌ $image not found</p>";
    }
}

echo "<h2>🎉 GALLERY IMAGES FIX COMPLETE!</h2>";
echo "<p>Default gallery images should now be accessible.</p>";
echo "<p>Check the test links above to verify images are working.</p>";
?>
