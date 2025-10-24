<?php

echo "=== Emergency DomPDF Fix ===\n\n";

// This script will manually fix the DomPDF ServiceProvider issue
// by directly requiring the service provider file

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
}

// Check if ServiceProvider file exists
$serviceProviderPath = $dompdfPath . '/src/ServiceProvider.php';
if (!file_exists($serviceProviderPath)) {
    echo "❌ ServiceProvider file not found: $serviceProviderPath\n";
    exit(1);
}

echo "✅ ServiceProvider file exists\n";

// Try to load the service provider directly
echo "Loading ServiceProvider directly...\n";
try {
    require_once $serviceProviderPath;
    echo "✅ ServiceProvider loaded directly\n";
} catch (Exception $e) {
    echo "❌ Error loading ServiceProvider: " . $e->getMessage() . "\n";
    exit(1);
}

// Test if class exists
if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
    echo "✅ ServiceProvider class is now available\n";
} else {
    echo "❌ ServiceProvider class still not found\n";
    exit(1);
}

// Now try to load the autoloader
echo "Loading autoloader...\n";
try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoloader loaded\n";
} catch (Exception $e) {
    echo "❌ Error loading autoloader: " . $e->getMessage() . "\n";
    exit(1);
}

// Test if class can be loaded via autoloader
if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
    echo "✅ ServiceProvider class can be loaded via autoloader\n";
} else {
    echo "❌ ServiceProvider class cannot be loaded via autoloader\n";
    echo "This might be an autoloader issue. Trying to fix...\n";
    
    // Try to regenerate autoloader
    exec('composer dump-autoload --optimize', $output, $returnCode);
    if ($returnCode === 0) {
        echo "✅ Autoloader regenerated\n";
        
        // Test again
        if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
            echo "✅ ServiceProvider class now available via autoloader\n";
        } else {
            echo "❌ ServiceProvider class still not available via autoloader\n";
            echo "This is likely an autoloader configuration issue.\n";
        }
    } else {
        echo "❌ Failed to regenerate autoloader\n";
    }
}

echo "\n=== Emergency fix completed ===\n";
echo "If the issue persists, the problem is likely with the autoloader configuration.\n";
echo "Try running: composer dump-autoload --optimize\n";
