<?php
/**
 * INTEGRATE STORAGE FIX - Script untuk mengintegrasikan fix storage ke upload process
 * Akses: https://odetune.shop/INTEGRATE_STORAGE_FIX.php
 */

echo "<h1>🔧 INTEGRATE STORAGE FIX</h1>";
echo "<p>Mengintegrasikan fix storage ke upload process...</p>";

// 1. Create helper function for storage sync
$helperFunction = '<?php
/**
 * Helper function untuk sync storage ke public
 * Tambahkan function ini ke app/helpers.php
 */

if (!function_exists("sync_storage_to_public")) {
    function sync_storage_to_public($filePath = null) {
        $storageDir = storage_path("app/public");
        $publicStorageDir = public_path("storage");
        
        // Create public storage directory if it doesn\'t exist
        if (!is_dir($publicStorageDir)) {
            mkdir($publicStorageDir, 0755, true);
        }
        
        if ($filePath) {
            // Sync specific file
            $sourcePath = $storageDir . "/" . $filePath;
            $destinationPath = $publicStorageDir . "/" . $filePath;
            $destinationDir = dirname($destinationPath);
            
            if (file_exists($sourcePath)) {
                if (!is_dir($destinationDir)) {
                    mkdir($destinationDir, 0755, true);
                }
                copy($sourcePath, $destinationPath);
                return true;
            }
        } else {
            // Sync all files
            if (is_dir($storageDir)) {
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storageDir));
                $syncedCount = 0;
                
                foreach ($iterator as $file) {
                    if ($file->isFile()) {
                        $relativePath = str_replace($storageDir . "/", "", $file->getPathname());
                        $sourcePath = $file->getPathname();
                        $destinationPath = $publicStorageDir . "/" . $relativePath;
                        $destinationDir = dirname($destinationPath);
                        
                        if (!is_dir($destinationDir)) {
                            mkdir($destinationDir, 0755, true);
                        }
                        
                        copy($sourcePath, $destinationPath);
                        $syncedCount++;
                    }
                }
                
                return $syncedCount;
            }
        }
        
        return false;
    }
}

if (!function_exists("get_storage_url")) {
    function get_storage_url($filePath) {
        $publicPath = "storage/" . $filePath;
        $publicFilePath = public_path($publicPath);
        
        // If file doesn\'t exist in public, try to sync it
        if (!file_exists($publicFilePath)) {
            sync_storage_to_public($filePath);
        }
        
        return asset($publicPath);
    }
}
?>';

// Save helper function
if (file_put_contents('storage_helper_functions.php', $helperFunction)) {
    echo "<p>✅ Created storage helper functions</p>";
    echo "<p>Copy the content of storage_helper_functions.php to app/helpers.php</p>";
} else {
    echo "<p>❌ Failed to create helper functions</p>";
}

// 2. Create middleware for auto-sync
$middlewareContent = '<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AutoSyncStorage
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Auto-sync storage on every request (only in production)
        if (app()->environment("production")) {
            $this->syncStorage();
        }
        
        return $next($request);
    }
    
    private function syncStorage()
    {
        $storageDir = storage_path("app/public");
        $publicStorageDir = public_path("storage");
        
        if (is_dir($storageDir) && is_dir($publicStorageDir)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($storageDir));
            
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $relativePath = str_replace($storageDir . "/", "", $file->getPathname());
                    $sourcePath = $file->getPathname();
                    $destinationPath = $publicStorageDir . "/" . $relativePath;
                    $destinationDir = dirname($destinationPath);
                    
                    if (!is_dir($destinationDir)) {
                        mkdir($destinationDir, 0755, true);
                    }
                    
                    // Copy if source is newer or destination doesn\'t exist
                    if (!file_exists($destinationPath) || filemtime($sourcePath) > filemtime($destinationPath)) {
                        copy($sourcePath, $destinationPath);
                    }
                }
            }
        }
    }
}';

if (file_put_contents('AutoSyncStorageMiddleware.php', $middlewareContent)) {
    echo "<p>✅ Created AutoSyncStorage middleware</p>";
    echo "<p>Copy this file to app/Http/Middleware/AutoSyncStorage.php</p>";
} else {
    echo "<p>❌ Failed to create middleware</p>";
}

// 3. Create cron job script
$cronScript = '<?php
/**
 * CRON JOB SCRIPT - Jalankan script ini setiap 5 menit via cron job
 * */5 * * * * php /path/to/your/project/CRON_SYNC_STORAGE.php
 */

require_once "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$app->make("Illuminate\Contracts\Console\Kernel")->bootstrap();

$storageDir = storage_path("app/public");
$publicStorageDir = public_path("storage");

if (is_dir($storageDir) && is_dir($publicStorageDir)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storageDir));
    $syncedCount = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($storageDir . "/", "", $file->getPathname());
            $sourcePath = $file->getPathname();
            $destinationPath = $publicStorageDir . "/" . $relativePath;
            $destinationDir = dirname($destinationPath);
            
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            
            if (!file_exists($destinationPath) || filemtime($sourcePath) > filemtime($destinationPath)) {
                copy($sourcePath, $destinationPath);
                $syncedCount++;
            }
        }
    }
    
    echo "Synced $syncedCount files at " . date("Y-m-d H:i:s") . "\n";
} else {
    echo "Storage directories not found\n";
}
?>';

if (file_put_contents('CRON_SYNC_STORAGE.php', $cronScript)) {
    echo "<p>✅ Created cron job script</p>";
    echo "<p>Setup cron job: */5 * * * * php /path/to/your/project/CRON_SYNC_STORAGE.php</p>";
} else {
    echo "<p>❌ Failed to create cron script</p>";
}

echo "<h2>📋 Integration Steps</h2>";
echo "<ol>";
echo "<li>Copy storage_helper_functions.php content to app/helpers.php</li>";
echo "<li>Copy AutoSyncStorageMiddleware.php to app/Http/Middleware/AutoSyncStorage.php</li>";
echo "<li>Register middleware in bootstrap/app.php</li>";
echo "<li>Setup cron job with CRON_SYNC_STORAGE.php</li>";
echo "<li>Update your upload controllers to use sync_storage_to_public()</li>";
echo "</ol>";

echo "<h2>🎉 INTEGRATION COMPLETE!</h2>";
echo "<p>Storage sync will now be automatic!</p>";
?>
