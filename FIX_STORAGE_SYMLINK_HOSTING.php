<?php
/**
 * FIX STORAGE SYMLINK HOSTING - Script untuk memperbaiki masalah storage symlink di hosting
 * Akses: https://odetune.shop/FIX_STORAGE_SYMLINK_HOSTING.php
 */

echo "<h1>🔗 FIX STORAGE SYMLINK HOSTING</h1>";
echo "<p>Memperbaiki masalah storage symlink di hosting...</p>";

// 1. Check current storage structure
echo "<h2>📁 Storage Structure Check</h2>";

$storageDir = 'storage/app/public';
$publicStorageDir = 'public/storage';

if (is_dir($storageDir)) {
    echo "<p>✅ Storage directory exists: $storageDir</p>";
    
    // List files in storage
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storageDir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($storageDir . '/', '', $file->getPathname());
            $files[] = $relativePath;
        }
    }
    
    echo "<p>Found " . count($files) . " files in storage:</p>";
    echo "<ul>";
    foreach (array_slice($files, 0, 10) as $file) {
        echo "<li>$file</li>";
    }
    if (count($files) > 10) {
        echo "<li>... and " . (count($files) - 10) . " more files</li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ Storage directory not found: $storageDir</p>";
}

// 2. Check public storage directory
echo "<h2>📁 Public Storage Check</h2>";

if (is_dir($publicStorageDir)) {
    echo "<p>✅ Public storage directory exists: $publicStorageDir</p>";
} else {
    echo "<p>❌ Public storage directory not found: $publicStorageDir</p>";
    echo "<p>Creating public storage directory...</p>";
    
    if (mkdir($publicStorageDir, 0755, true)) {
        echo "<p>✅ Created public storage directory</p>";
    } else {
        echo "<p>❌ Failed to create public storage directory</p>";
    }
}

// 3. Copy files from storage to public
echo "<h2>📋 Copy Files Process</h2>";

if (is_dir($storageDir) && is_dir($publicStorageDir)) {
    $copiedCount = 0;
    $failedCount = 0;
    
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
            if (copy($sourcePath, $destinationPath)) {
                $copiedCount++;
            } else {
                $failedCount++;
                echo "<p>❌ Failed to copy: $relativePath</p>";
            }
        }
    }
    
    echo "<p>✅ Copied $copiedCount files</p>";
    if ($failedCount > 0) {
        echo "<p>❌ Failed to copy $failedCount files</p>";
    }
} else {
    echo "<p>❌ Cannot copy files - directories not found</p>";
}

// 4. Create .htaccess for storage
echo "<h2>⚙️ Create .htaccess for Storage</h2>";

$htaccessContent = '
# MIME types for images and files
<IfModule mod_mime.c>
    AddType image/png .png
    AddType image/jpeg .jpg .jpeg
    AddType image/gif .gif
    AddType image/webp .webp
    AddType application/pdf .pdf
    AddType application/msword .doc
    AddType application/vnd.openxmlformats-officedocument.wordprocessingml.document .docx
    AddType application/vnd.ms-excel .xls
    AddType application/vnd.openxmlformats-officedocument.spreadsheetml.sheet .xlsx
</IfModule>

# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE image/png
    AddOutputFilterByType DEFLATE image/jpeg
    AddOutputFilterByType DEFLATE image/gif
    AddOutputFilterByType DEFLATE application/pdf
</IfModule>

# Cache control
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 week"
</IfModule>

# Security headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options nosniff
    Header set X-Frame-Options DENY
</IfModule>
';

$htaccessFile = $publicStorageDir . '/.htaccess';
if (file_put_contents($htaccessFile, $htaccessContent)) {
    echo "<p>✅ Created .htaccess for storage directory</p>";
} else {
    echo "<p>❌ Failed to create .htaccess for storage directory</p>";
}

// 5. Test file access
echo "<h2>🔍 Test File Access</h2>";

if (is_dir($publicStorageDir)) {
    $testFiles = glob($publicStorageDir . '/*');
    if (count($testFiles) > 0) {
        echo "<p>Testing file access:</p>";
        echo "<ul>";
        foreach (array_slice($testFiles, 0, 5) as $file) {
            $relativePath = str_replace($publicStorageDir . '/', '', $file);
            $testUrl = 'https://odetune.shop/storage/' . $relativePath;
            echo "<li><a href='$testUrl' target='_blank'>$relativePath</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ No files found in public storage directory</p>";
    }
}

// 6. Create auto-sync script
echo "<h2>🔄 Create Auto-Sync Script</h2>";

$autoSyncScript = '<?php
/**
 * AUTO SYNC STORAGE - Script untuk sinkronisasi otomatis storage ke public
 * Jalankan script ini secara berkala untuk memastikan file ter-sync
 */

$storageDir = "storage/app/public";
$publicStorageDir = "public/storage";

if (is_dir($storageDir) && is_dir($publicStorageDir)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storageDir));
    $syncedCount = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($storageDir . "/", "", $file->getPathname());
            $sourcePath = $file->getPathname();
            $destinationPath = $publicStorageDir . "/" . $relativePath;
            $destinationDir = dirname($destinationPath);
            
            // Create destination directory if it doesn\'t exist
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            
            // Copy file if source is newer or destination doesn\'t exist
            if (!file_exists($destinationPath) || filemtime($sourcePath) > filemtime($destinationPath)) {
                copy($sourcePath, $destinationPath);
                $syncedCount++;
            }
        }
    }
    
    echo "Synced $syncedCount files";
} else {
    echo "Storage directories not found";
}
?>';

if (file_put_contents('AUTO_SYNC_STORAGE.php', $autoSyncScript)) {
    echo "<p>✅ Created AUTO_SYNC_STORAGE.php</p>";
    echo "<p>Jalankan script ini secara berkala: <a href='/AUTO_SYNC_STORAGE.php' target='_blank'>AUTO_SYNC_STORAGE.php</a></p>";
} else {
    echo "<p>❌ Failed to create auto-sync script</p>";
}

echo "<h2>🎉 STORAGE SYMLINK FIX COMPLETE!</h2>";
echo "<p>Storage files should now be accessible via public/storage/</p>";
echo "<p>Run AUTO_SYNC_STORAGE.php periodically to keep files in sync.</p>";
?>
