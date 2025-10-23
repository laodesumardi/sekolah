<?php
/**
 * QUICK LIBRARY FIX - Script cepat untuk memperbaiki gambar perpustakaan
 * Akses: https://odetune.shop/QUICK_LIBRARY_FIX.php
 */

echo "<h1>🚀 QUICK LIBRARY FIX</h1>";

// 1. Find and copy library image
$sourceFile = null;
$targetFile = 'struktur-organisasi-perpustakaan.png';

// Check storage/libraries directory
if (is_dir('storage/libraries')) {
    $files = scandir('storage/libraries');
    foreach ($files as $file) {
        if (strpos($file, '.png') !== false) {
            $sourceFile = 'storage/libraries/' . $file;
            break;
        }
    }
}

if ($sourceFile && file_exists($sourceFile)) {
    if (copy($sourceFile, $targetFile)) {
        echo "<p>✅ Image copied successfully!</p>";
        echo "<p>Source: $sourceFile</p>";
        echo "<p>Target: $targetFile</p>";
        echo "<p>Size: " . filesize($targetFile) . " bytes</p>";
        
        // Test image
        echo "<h2>🖼️ Image Test</h2>";
        echo "<img src='$targetFile' alt='Library Organization Chart' style='max-width: 400px; height: auto; border: 2px solid #007bff;'>";
        
        echo "<h2>✅ SUCCESS!</h2>";
        echo "<p>Library image is now accessible!</p>";
        echo "<p><a href='/perpustakaan' target='_blank'>Test Library Page</a></p>";
    } else {
        echo "<p>❌ Failed to copy image</p>";
    }
} else {
    echo "<p>❌ No library image found in storage/libraries</p>";
    echo "<p>Available files:</p>";
    if (is_dir('storage/libraries')) {
        $files = scandir('storage/libraries');
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo "<p>- $file</p>";
            }
        }
    }
}
?>
