<?php
/**
 * QUICK STORAGE FIX - Script cepat untuk memperbaiki masalah storage
 * Akses: https://odetune.shop/QUICK_STORAGE_FIX.php
 */

echo "<h1>🚀 QUICK STORAGE FIX</h1>";

$storageDir = 'storage/app/public';
$publicStorageDir = 'public/storage';

// 1. Create public storage directory if it doesn't exist
if (!is_dir($publicStorageDir)) {
    mkdir($publicStorageDir, 0755, true);
    echo "<p>✅ Created public storage directory</p>";
}

// 2. Copy all files from storage to public
if (is_dir($storageDir)) {
    $copiedCount = 0;
    
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storageDir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($storageDir . '/', '', $file->getPathname());
            $sourcePath = $file->getPathname();
            $destinationPath = $publicStorageDir . '/' . $relativePath;
            $destinationDir = dirname($destinationPath);
            
            // Create destination directory if it doesn't exist
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            
            // Copy file
            copy($sourcePath, $destinationPath);
            $copiedCount++;
        }
    }
    
    echo "<p>✅ Copied $copiedCount files from storage to public</p>";
} else {
    echo "<p>❌ Storage directory not found</p>";
}

// 3. Create .htaccess for storage
$htaccessContent = '
# MIME types
<IfModule mod_mime.c>
    AddType image/png .png
    AddType image/jpeg .jpg .jpeg
    AddType image/gif .gif
    AddType image/webp .webp
    AddType application/pdf .pdf
</IfModule>

# Cache control
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
</IfModule>
';

file_put_contents($publicStorageDir . '/.htaccess', $htaccessContent);
echo "<p>✅ Created .htaccess for storage</p>";

// 4. Test some files
echo "<h2>🔍 Test Files</h2>";
$testFiles = glob($publicStorageDir . '/*');
if (count($testFiles) > 0) {
    echo "<p>Testing file access:</p>";
    foreach (array_slice($testFiles, 0, 3) as $file) {
        $relativePath = str_replace($publicStorageDir . '/', '', $file);
        $testUrl = 'https://odetune.shop/storage/' . $relativePath;
        echo "<p><a href='$testUrl' target='_blank'>$relativePath</a></p>";
    }
}

echo "<h2>✅ QUICK FIX COMPLETE!</h2>";
echo "<p>Storage files should now be accessible!</p>";
echo "<p><strong>IMPORTANT:</strong> Jalankan script ini setiap kali ada upload/edit gambar baru!</p>";
?>
