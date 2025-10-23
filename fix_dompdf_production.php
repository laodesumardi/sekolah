<?php

echo "=== DomPDF Production Fix Script ===\n\n";

// 1. Check if vendor directory exists
if (!is_dir('vendor')) {
    echo "❌ Vendor directory not found!\n";
    echo "Run: composer install\n";
    exit(1);
}

// 2. Check if DomPDF package exists
$dompdfPath = 'vendor/barryvdh/laravel-dompdf';
if (!is_dir($dompdfPath)) {
    echo "❌ DomPDF package not found!\n";
    echo "Run: composer require barryvdh/laravel-dompdf\n";
    exit(1);
}

// 3. Check if ServiceProvider file exists
$serviceProviderPath = $dompdfPath . '/src/ServiceProvider.php';
if (!file_exists($serviceProviderPath)) {
    echo "❌ ServiceProvider.php not found!\n";
    echo "Package installation corrupted. Run: composer install --no-cache\n";
    exit(1);
}

echo "✅ DomPDF package found\n";
echo "✅ ServiceProvider.php exists\n";

// 4. Check autoload files
$autoloadPath = 'vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    echo "❌ Autoload file not found!\n";
    echo "Run: composer dump-autoload\n";
    exit(1);
}

echo "✅ Autoload file exists\n";

// 5. Test if class can be loaded
try {
    require_once $autoloadPath;
    $serviceProvider = 'Barryvdh\\DomPDF\\ServiceProvider';
    if (class_exists($serviceProvider)) {
        echo "✅ ServiceProvider class can be loaded\n";
    } else {
        echo "❌ ServiceProvider class cannot be loaded\n";
        echo "Run: composer dump-autoload --optimize\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "❌ Error loading autoload: " . $e->getMessage() . "\n";
    exit(1);
}

// 6. Check Laravel bootstrap
$bootstrapPath = 'bootstrap/app.php';
if (!file_exists($bootstrapPath)) {
    echo "❌ Laravel bootstrap not found!\n";
    exit(1);
}

echo "✅ Laravel bootstrap exists\n";

// 7. Test Laravel application
try {
    $app = require_once $bootstrapPath;
    echo "✅ Laravel application can be bootstrapped\n";
} catch (Exception $e) {
    echo "❌ Laravel bootstrap error: " . $e->getMessage() . "\n";
    echo "Run: php artisan optimize:clear\n";
    exit(1);
}

echo "\n=== All checks passed! ===\n";
echo "If you still get errors, try these commands:\n";
echo "1. composer install --no-cache\n";
echo "2. composer dump-autoload --optimize\n";
echo "3. php artisan optimize:clear\n";
echo "4. php artisan config:cache\n";
echo "5. php artisan route:cache\n";
echo "6. php artisan view:cache\n";
