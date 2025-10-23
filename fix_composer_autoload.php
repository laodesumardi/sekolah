<?php

echo "=== Composer Autoload Fix ===\n\n";

// Check if we're in the right directory
if (!file_exists('composer.json')) {
    echo "❌ composer.json not found. Please run from project root.\n";
    exit(1);
}

// Check if vendor directory exists
if (!is_dir('vendor')) {
    echo "❌ vendor directory not found. Installing dependencies...\n";
    exec('composer install --no-dev --optimize-autoloader', $output, $returnCode);
    if ($returnCode !== 0) {
        echo "❌ Failed to install dependencies\n";
        exit(1);
    }
    echo "✅ Dependencies installed\n";
} else {
    echo "✅ vendor directory exists\n";
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

// Clear all caches
echo "Clearing all caches...\n";
$clearCommands = [
    'rm -rf bootstrap/cache/*',
    'rm -rf storage/framework/cache/*',
    'rm -rf storage/framework/sessions/*',
    'rm -rf storage/framework/views/*',
    'rm -rf storage/logs/*'
];

foreach ($clearCommands as $cmd) {
    exec($cmd);
}

// Remove vendor directory to force clean reinstall
echo "Removing vendor directory for clean reinstall...\n";
exec('rm -rf vendor/');

// Reinstall dependencies
echo "Reinstalling dependencies...\n";
exec('composer install --no-dev --optimize-autoloader --no-cache', $output, $returnCode);
if ($returnCode !== 0) {
    echo "❌ Failed to reinstall dependencies\n";
    exit(1);
}
echo "✅ Dependencies reinstalled\n";

// Regenerate autoload
echo "Regenerating autoload...\n";
exec('composer dump-autoload --optimize', $output, $returnCode);
if ($returnCode !== 0) {
    echo "❌ Failed to regenerate autoload\n";
    exit(1);
}
echo "✅ Autoload regenerated\n";

// Run package discovery
echo "Running package discovery...\n";
exec('php artisan package:discover', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Package discovery completed\n";
} else {
    echo "⚠️  Package discovery failed (this might be normal in some environments)\n";
}

// Test if the class can be loaded
echo "Testing DomPDF ServiceProvider...\n";
try {
    require_once 'vendor/autoload.php';
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo "✅ SUCCESS: DomPDF ServiceProvider is now available!\n";
    } else {
        echo "❌ FAILED: DomPDF ServiceProvider still not found\n";
        echo "This might be a deeper autoloader issue.\n";
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Composer autoload fix completed! ===\n";
echo "If the issue persists, there might be a deeper problem with the autoloader.\n";
echo "Try running: composer dump-autoload --optimize\n";
