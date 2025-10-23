<?php

echo "=== Production Environment Check ===\n\n";

// Check PHP version
echo "PHP Version: " . PHP_VERSION . "\n";

// Check if we're in production
$isProduction = !file_exists('.env') || (file_exists('.env') && strpos(file_get_contents('.env'), 'APP_ENV=production') !== false);
echo "Environment: " . ($isProduction ? 'Production' : 'Development') . "\n\n";

// Check critical files
$criticalFiles = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'public/index.php',
    'vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php'
];

echo "Critical Files Check:\n";
foreach ($criticalFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file\n";
    } else {
        echo "❌ $file - MISSING!\n";
    }
}

echo "\n";

// Check if we can load the application
try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload loaded successfully\n";
    
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel application bootstrapped\n";
    
    // Test DomPDF service provider
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo "✅ DomPDF ServiceProvider class exists\n";
    } else {
        echo "❌ DomPDF ServiceProvider class NOT FOUND\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Check completed ===\n";
