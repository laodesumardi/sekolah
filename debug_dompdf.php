<?php

echo "=== DomPDF Debug Information ===\n\n";

// Check PHP version
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PHP SAPI: " . php_sapi_name() . "\n\n";

// Check if we're in the right directory
if (!file_exists('composer.json')) {
    echo "❌ composer.json not found. Please run from project root.\n";
    exit(1);
}

// Check vendor directory
if (!is_dir('vendor')) {
    echo "❌ vendor directory not found!\n";
    exit(1);
}

// Check autoload file
if (!file_exists('vendor/autoload.php')) {
    echo "❌ vendor/autoload.php not found!\n";
    exit(1);
}

echo "✅ Basic files exist\n\n";

// Try to load autoload
echo "Loading autoload...\n";
try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload loaded successfully\n";
} catch (Exception $e) {
    echo "❌ Error loading autoload: " . $e->getMessage() . "\n";
    exit(1);
}

// Check if DomPDF directory exists
$dompdfDir = 'vendor/barryvdh/laravel-dompdf';
if (!is_dir($dompdfDir)) {
    echo "❌ DomPDF directory not found: $dompdfDir\n";
    exit(1);
}
echo "✅ DomPDF directory exists\n";

// Check ServiceProvider file
$spFile = $dompdfDir . '/src/ServiceProvider.php';
if (!file_exists($spFile)) {
    echo "❌ ServiceProvider file not found: $spFile\n";
    exit(1);
}
echo "✅ ServiceProvider file exists\n";

// Check if class can be loaded
echo "\nTesting class loading...\n";
if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
    echo "✅ ServiceProvider class can be loaded via autoload\n";
} else {
    echo "❌ ServiceProvider class cannot be loaded via autoload\n";
    echo "Trying direct require...\n";
    
    try {
        require_once $spFile;
        if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
            echo "✅ ServiceProvider class loaded directly\n";
        } else {
            echo "❌ ServiceProvider class still not found after direct require\n";
        }
    } catch (Exception $e) {
        echo "❌ Error loading ServiceProvider directly: " . $e->getMessage() . "\n";
    }
}

// Check Laravel bootstrap
echo "\nTesting Laravel bootstrap...\n";
try {
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel application bootstrapped\n";
} catch (Exception $e) {
    echo "❌ Laravel bootstrap error: " . $e->getMessage() . "\n";
}

// Check if we can create a DomPDF instance
echo "\nTesting DomPDF instantiation...\n";
try {
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        $sp = new Barryvdh\DomPDF\ServiceProvider(app());
        echo "✅ ServiceProvider can be instantiated\n";
    } else {
        echo "❌ Cannot instantiate ServiceProvider (class not found)\n";
    }
} catch (Exception $e) {
    echo "❌ Error instantiating ServiceProvider: " . $e->getMessage() . "\n";
}

echo "\n=== Debug completed ===\n";
