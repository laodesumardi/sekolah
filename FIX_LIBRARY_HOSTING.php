<?php
/**
 * FIX LIBRARY HOSTING - Script untuk memperbaiki gambar perpustakaan di hosting
 * Akses: https://odetune.shop/FIX_LIBRARY_HOSTING.php
 */

echo "<h1>🔧 FIX LIBRARY HOSTING</h1>";
echo "<p>Memperbaiki masalah gambar perpustakaan di hosting...</p>";

// 1. Check current directory structure
echo "<h2>📁 Directory Structure Check</h2>";
echo "<p>Current directory: " . getcwd() . "</p>";

// Check if storage directory exists
$storageDir = 'storage';
if (is_dir($storageDir)) {
    echo "<p>✅ Storage directory exists</p>";
    
    // Check libraries subdirectory
    $librariesDir = $storageDir . '/libraries';
    if (is_dir($librariesDir)) {
        echo "<p>✅ Libraries directory exists</p>";
        
        // List files in libraries directory
        $files = scandir($librariesDir);
        echo "<p>Files in libraries directory:</p>";
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $librariesDir . '/' . $file;
                $fileSize = filesize($filePath);
                echo "<li>$file ($fileSize bytes)</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Libraries directory not found</p>";
    }
} else {
    echo "<p>❌ Storage directory not found</p>";
}

// 2. Check public directory
echo "<h2>📁 Public Directory Check</h2>";
$publicDir = 'public';
if (is_dir($publicDir)) {
    echo "<p>✅ Public directory exists</p>";
    
    // Check if struktur-organisasi-perpustakaan.png exists
    $imageFile = $publicDir . '/struktur-organisasi-perpustakaan.png';
    if (file_exists($imageFile)) {
        echo "<p>✅ Struktur organisasi image exists in public</p>";
        echo "<p>File size: " . filesize($imageFile) . " bytes</p>";
    } else {
        echo "<p>❌ Struktur organisasi image not found in public</p>";
    }
} else {
    echo "<p>❌ Public directory not found</p>";
}

// 3. Copy files from storage to public
echo "<h2>📋 Copy Files Process</h2>";

// Find the library image file
$libraryImageFile = null;
if (is_dir($storageDir . '/libraries')) {
    $files = scandir($storageDir . '/libraries');
    foreach ($files as $file) {
        if (strpos($file, '.png') !== false) {
            $libraryImageFile = $file;
            break;
        }
    }
}

if ($libraryImageFile) {
    echo "<p>Found library image: $libraryImageFile</p>";
    
    $sourceFile = $storageDir . '/libraries/' . $libraryImageFile;
    $targetFile = 'struktur-organisasi-perpustakaan.png';
    
    if (file_exists($sourceFile)) {
        if (copy($sourceFile, $targetFile)) {
            echo "<p>✅ Successfully copied to public directory</p>";
            echo "<p>Target file: $targetFile</p>";
            echo "<p>File size: " . filesize($targetFile) . " bytes</p>";
        } else {
            echo "<p>❌ Failed to copy file</p>";
        }
    } else {
        echo "<p>❌ Source file not found: $sourceFile</p>";
    }
} else {
    echo "<p>❌ No library image file found</p>";
}

// 4. Test image access
echo "<h2>🔍 Test Image Access</h2>";
$testUrl = 'https://odetune.shop/struktur-organisasi-perpustakaan.png';
echo "<p>Testing image access: <a href='$testUrl' target='_blank'>$testUrl</a></p>";

// 5. Create .htaccess for proper MIME types
echo "<h2>⚙️ Create .htaccess</h2>";
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

if (file_put_contents('.htaccess', $htaccessContent)) {
    echo "<p>✅ .htaccess created successfully</p>";
} else {
    echo "<p>❌ Failed to create .htaccess</p>";
}

// 6. Final test
echo "<h2>✅ Final Test</h2>";
echo "<p>Testing image display:</p>";
echo "<img src='struktur-organisasi-perpustakaan.png' alt='Struktur Organisasi Perpustakaan' style='max-width: 300px; height: auto; border: 1px solid #ccc;'>";

echo "<h2>🎉 Fix Complete!</h2>";
echo "<p>Library hosting fix completed. Check the image above to verify it's working.</p>";
echo "<p><a href='/perpustakaan' target='_blank'>Test Library Page</a></p>";
?>
