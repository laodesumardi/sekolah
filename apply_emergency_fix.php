<?php

echo "=== Emergency DomPDF Fix Application ===\n\n";

// Check if we're in the right directory
if (!file_exists('composer.json')) {
    echo "❌ composer.json not found. Please run from project root.\n";
    exit(1);
}

// Check if we're in the public directory or need to go there
$publicDir = 'public';
if (!is_dir($publicDir)) {
    echo "❌ public directory not found. Please run from project root.\n";
    exit(1);
}

// Backup original index.php
$originalIndex = $publicDir . '/index.php';
$backupIndex = $publicDir . '/index.php.backup';

if (file_exists($originalIndex)) {
    if (!file_exists($backupIndex)) {
        copy($originalIndex, $backupIndex);
        echo "✅ Original index.php backed up to index.php.backup\n";
    } else {
        echo "✅ Backup already exists\n";
    }
} else {
    echo "❌ index.php not found in public directory\n";
    exit(1);
}

// Check if DomPDF package exists
$dompdfPath = 'vendor/barryvdh/laravel-dompdf';
if (!is_dir($dompdfPath)) {
    echo "❌ DomPDF package not found. Installing...\n";
    exec('composer require barryvdh/laravel-dompdf', $output, $returnCode);
    if ($returnCode !== 0) {
        echo "❌ Failed to install DomPDF package\n";
        exit(1);
    }
    echo "✅ DomPDF package installed\n";
} else {
    echo "✅ DomPDF package exists\n";
}

// Check if ServiceProvider file exists
$serviceProviderPath = $dompdfPath . '/src/ServiceProvider.php';
if (!file_exists($serviceProviderPath)) {
    echo "❌ ServiceProvider file not found: $serviceProviderPath\n";
    exit(1);
}
echo "✅ ServiceProvider file exists\n";

// Apply the emergency fix
echo "Applying emergency fix to index.php...\n";

$fixedIndexContent = '<?php

// Emergency fix for DomPDF ServiceProvider not found error
// This file should replace the original index.php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define(\'LARAVEL_START\', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.\'/../storage/framework/maintenance.php\')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We\'ll simply require it
| into the script here so we don\'t need to manually load our classes.
|
*/

require __DIR__.\'/../vendor/autoload.php\';

/*
|--------------------------------------------------------------------------
| EMERGENCY FIX: Manually Load DomPDF ServiceProvider
|--------------------------------------------------------------------------
|
| This is an emergency fix for the DomPDF ServiceProvider not found error.
| We manually require the service provider file to ensure it\'s loaded.
|
*/

$dompdfServiceProviderPath = __DIR__.\'/../vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php\';
if (file_exists($dompdfServiceProviderPath)) {
    require_once $dompdfServiceProviderPath;
    echo "<!-- DomPDF ServiceProvider loaded manually -->\n";
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application\'s HTTP kernel. Then, we will send the response back
| to this client\'s browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.\'/../bootstrap/app.php\';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);';

// Write the fixed index.php
if (file_put_contents($originalIndex, $fixedIndexContent)) {
    echo "✅ Emergency fix applied to index.php\n";
} else {
    echo "❌ Failed to apply emergency fix to index.php\n";
    exit(1);
}

// Test the fix
echo "Testing the fix...\n";
try {
    // Test if the service provider can be loaded
    require_once $serviceProviderPath;
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo "✅ ServiceProvider class can be loaded\n";
    } else {
        echo "❌ ServiceProvider class still not found\n";
    }
} catch (Exception $e) {
    echo "❌ Error testing ServiceProvider: " . $e->getMessage() . "\n";
}

echo "\n=== Emergency fix applied! ===\n";
echo "The index.php file has been modified to manually load the DomPDF ServiceProvider.\n";
echo "This should resolve the 'Class not found' error.\n";
echo "If you need to revert, restore from index.php.backup\n";
