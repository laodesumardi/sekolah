<?php
/**
 * DIAGNOSE HOSTING - Script untuk mendiagnosis masalah hosting
 * Akses: https://odetune.shop/DIAGNOSE_HOSTING.php
 */

echo "<h1>🔍 HOSTING DIAGNOSIS</h1>";
echo "<p>Mendiagnosis masalah hosting...</p>";

// 1. Check PHP version
echo "<h2>🐘 PHP Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// 2. Check directory structure
echo "<h2>📁 Directory Structure</h2>";
$directories = [
    'app',
    'app/Http/Controllers',
    'resources',
    'resources/views',
    'routes',
    'vendor',
    'public',
    'storage',
    'bootstrap'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "<p>✅ $dir exists</p>";
    } else {
        echo "<p>❌ $dir missing</p>";
    }
}

// 3. Check key files
echo "<h2>📄 Key Files Check</h2>";
$files = [
    'app/Http/Controllers/LibraryController.php',
    'resources/views/library.blade.php',
    'routes/web.php',
    'public/index.php',
    'vendor/autoload.php',
    'bootstrap/app.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p>✅ $file exists</p>";
    } else {
        echo "<p>❌ $file missing</p>";
    }
}

// 4. Check Laravel bootstrap
echo "<h2>🚀 Laravel Bootstrap Test</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<p>✅ Autoload loaded</p>";
        
        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            echo "<p>✅ Laravel app loaded</p>";
            
            // Test route
            $router = $app->make('router');
            $routes = $router->getRoutes();
            $libraryRoute = null;
            
            foreach ($routes as $route) {
                if ($route->uri() === 'perpustakaan') {
                    $libraryRoute = $route;
                    break;
                }
            }
            
            if ($libraryRoute) {
                echo "<p>✅ Library route found</p>";
                echo "<p>Route name: " . $libraryRoute->getName() . "</p>";
                echo "<p>Controller: " . $libraryRoute->getActionName() . "</p>";
            } else {
                echo "<p>❌ Library route not found</p>";
            }
        } else {
            echo "<p>❌ bootstrap/app.php not found</p>";
        }
    } else {
        echo "<p>❌ vendor/autoload.php not found</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Laravel bootstrap failed: " . $e->getMessage() . "</p>";
}

// 5. Check .htaccess
echo "<h2>⚙️ .htaccess Check</h2>";
if (file_exists('.htaccess')) {
    echo "<p>✅ .htaccess exists</p>";
    $htaccess = file_get_contents('.htaccess');
    if (strpos($htaccess, 'RewriteEngine') !== false) {
        echo "<p>✅ RewriteEngine enabled</p>";
    } else {
        echo "<p>❌ RewriteEngine not found</p>";
    }
} else {
    echo "<p>❌ .htaccess missing</p>";
}

// 6. Check public directory
echo "<h2>🌐 Public Directory Check</h2>";
if (is_dir('public')) {
    echo "<p>✅ Public directory exists</p>";
    
    $publicFiles = [
        'public/index.php',
        'public/.htaccess'
    ];
    
    foreach ($publicFiles as $file) {
        if (file_exists($file)) {
            echo "<p>✅ $file exists</p>";
        } else {
            echo "<p>❌ $file missing</p>";
        }
    }
} else {
    echo "<p>❌ Public directory missing</p>";
}

// 7. Test specific route
echo "<h2>🔗 Route Test</h2>";
echo "<p>Testing library route access:</p>";
echo "<p><a href='/perpustakaan' target='_blank'>Test /perpustakaan</a></p>";

// 8. Check database connection
echo "<h2>🗄️ Database Check</h2>";
try {
    if (file_exists('vendor/autoload.php') && file_exists('bootstrap/app.php')) {
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        $db = $app->make('db');
        $connection = $db->connection();
        $connection->getPdo();
        echo "<p>✅ Database connection successful</p>";
        
        // Check if libraries table exists
        $tables = $connection->select("SHOW TABLES LIKE 'libraries'");
        if (count($tables) > 0) {
            echo "<p>✅ Libraries table exists</p>";
            
            // Check library data
            $libraries = $connection->select("SELECT * FROM libraries WHERE is_active = 1");
            if (count($libraries) > 0) {
                echo "<p>✅ Active library data found (" . count($libraries) . " records)</p>";
            } else {
                echo "<p>❌ No active library data found</p>";
            }
        } else {
            echo "<p>❌ Libraries table not found</p>";
        }
    }
} catch (Exception $e) {
    echo "<p>❌ Database check failed: " . $e->getMessage() . "</p>";
}

echo "<h2>📋 Summary</h2>";
echo "<p>Diagnosis complete. Check the results above to identify the issue.</p>";
echo "<p>Common issues:</p>";
echo "<ul>";
echo "<li>Missing files or directories</li>";
echo "<li>Laravel not properly configured</li>";
echo "<li>Database connection issues</li>";
echo "<li>Route not registered</li>";
echo "<li>.htaccess configuration problems</li>";
echo "</ul>";
?>
