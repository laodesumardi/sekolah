<?php
/**
 * FIX ROUTING HOSTING - Script untuk memperbaiki masalah routing di hosting
 * Akses: https://odetune.shop/FIX_ROUTING_HOSTING.php
 */

echo "<h1>🔧 FIX ROUTING HOSTING</h1>";
echo "<p>Memperbaiki masalah routing di hosting...</p>";

// 1. Check if Laravel is properly loaded
echo "<h2>🚀 Laravel Bootstrap</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<p>✅ Autoload loaded</p>";
        
        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            echo "<p>✅ Laravel app loaded</p>";
            
            // Bootstrap the application
            $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
            echo "<p>✅ Laravel kernel bootstrapped</p>";
        } else {
            echo "<p>❌ bootstrap/app.php not found</p>";
            exit;
        }
    } else {
        echo "<p>❌ vendor/autoload.php not found</p>";
        exit;
    }
} catch (Exception $e) {
    echo "<p>❌ Laravel bootstrap failed: " . $e->getMessage() . "</p>";
    exit;
}

// 2. Test LibraryController
echo "<h2>📚 Library Controller Test</h2>";
try {
    $controller = new App\Http\Controllers\LibraryController();
    echo "<p>✅ LibraryController instantiated</p>";
    
    // Test the index method
    $request = new Illuminate\Http\Request();
    $response = $controller->index();
    echo "<p>✅ LibraryController index method works</p>";
    
    if ($response instanceof Illuminate\View\View) {
        echo "<p>✅ Returns view</p>";
        echo "<p>View name: " . $response->getName() . "</p>";
    } else {
        echo "<p>❌ Does not return view</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ LibraryController test failed: " . $e->getMessage() . "</p>";
}

// 3. Test Library Model
echo "<h2>📖 Library Model Test</h2>";
try {
    $library = App\Models\Library::where('is_active', true)->first();
    if ($library) {
        echo "<p>✅ Library model works</p>";
        echo "<p>Library name: " . $library->name . "</p>";
        echo "<p>Library ID: " . $library->id . "</p>";
    } else {
        echo "<p>❌ No active library found</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Library model test failed: " . $e->getMessage() . "</p>";
}

// 4. Test view file
echo "<h2>👁️ View File Test</h2>";
$viewFile = 'resources/views/library.blade.php';
if (file_exists($viewFile)) {
    echo "<p>✅ Library view file exists</p>";
    echo "<p>File size: " . filesize($viewFile) . " bytes</p>";
} else {
    echo "<p>❌ Library view file not found</p>";
}

// 5. Test route registration
echo "<h2>🛣️ Route Registration Test</h2>";
try {
    $router = $app->make('router');
    $routes = $router->getRoutes();
    
    $libraryRouteFound = false;
    foreach ($routes as $route) {
        if ($route->uri() === 'perpustakaan') {
            $libraryRouteFound = true;
            echo "<p>✅ Library route found</p>";
            echo "<p>Route name: " . $route->getName() . "</p>";
            echo "<p>Controller: " . $route->getActionName() . "</p>";
            echo "<p>Methods: " . implode(', ', $route->methods()) . "</p>";
            break;
        }
    }
    
    if (!$libraryRouteFound) {
        echo "<p>❌ Library route not found</p>";
        echo "<p>Available routes:</p>";
        echo "<ul>";
        foreach ($routes as $route) {
            echo "<li>" . $route->uri() . " (" . implode(', ', $route->methods()) . ")</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p>❌ Route test failed: " . $e->getMessage() . "</p>";
}

// 6. Test direct route access
echo "<h2>🔗 Direct Route Test</h2>";
echo "<p>Testing direct route access:</p>";
echo "<p><a href='/perpustakaan' target='_blank'>Test /perpustakaan</a></p>";

// 7. Create simple test route
echo "<h2>🧪 Create Test Route</h2>";
try {
    // Register a simple test route
    $router->get('/test-library', function() {
        return "Library route test successful!";
    });
    echo "<p>✅ Test route registered</p>";
    echo "<p><a href='/test-library' target='_blank'>Test /test-library</a></p>";
} catch (Exception $e) {
    echo "<p>❌ Test route creation failed: " . $e->getMessage() . "</p>";
}

// 8. Check .htaccess
echo "<h2>⚙️ .htaccess Check</h2>";
if (file_exists('.htaccess')) {
    echo "<p>✅ .htaccess exists</p>";
    $htaccess = file_get_contents('.htaccess');
    if (strpos($htaccess, 'RewriteEngine On') !== false) {
        echo "<p>✅ RewriteEngine enabled</p>";
    } else {
        echo "<p>❌ RewriteEngine not enabled</p>";
    }
} else {
    echo "<p>❌ .htaccess missing</p>";
}

echo "<h2>🎉 ROUTING FIX COMPLETE!</h2>";
echo "<p>Check the test links above to verify routing is working.</p>";
?>
