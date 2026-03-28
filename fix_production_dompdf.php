<?php

echo "=== DomPDF Production Fix Script ===\n\n";

// Check if we're in the right directory
if (!file_exists('composer.json')) {
    echo "❌ composer.json not found. Please run this script from the project root.\n";
    exit(1);
}

echo "✅ Found composer.json\n";

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

// Clear all Laravel caches
echo "\nClearing Laravel caches...\n";
$commands = [
    'php artisan optimize:clear',
    'php artisan config:clear',
    'php artisan route:clear',
    'php artisan view:clear',
    'php artisan cache:clear'
];

foreach ($commands as $command) {
    echo "Running: $command\n";
    exec($command, $output, $returnCode);
    if ($returnCode !== 0) {
        echo "⚠️  Warning: $command failed (this might be normal in some environments)\n";
    }
}

// Regenerate autoload
echo "\nRegenerating autoload...\n";
exec('composer dump-autoload --optimize', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Autoload regenerated\n";
} else {
    echo "❌ Failed to regenerate autoload\n";
    exit(1);
}

// Run package discovery
echo "\nRunning package discovery...\n";
exec('php artisan package:discover', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Package discovery completed\n";
} else {
    echo "⚠️  Package discovery failed (this might be normal in some environments)\n";
}

// Publish DomPDF config
echo "\nPublishing DomPDF configuration...\n";
exec('php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --tag=config', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ DomPDF configuration published\n";
} else {
    echo "⚠️  DomPDF configuration publish failed (might already exist)\n";
}

// Test if the class can be loaded
echo "\nTesting DomPDF ServiceProvider...\n";
try {
    require_once 'vendor/autoload.php';
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo "✅ DomPDF ServiceProvider class can be loaded\n";
    } else {
        echo "❌ DomPDF ServiceProvider class still cannot be loaded\n";
        echo "Trying alternative fix...\n";
        
        // Try to manually require the service provider
        $serviceProviderPath = 'vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php';
        if (file_exists($serviceProviderPath)) {
            require_once $serviceProviderPath;
            echo "✅ Manually loaded ServiceProvider\n";
        } else {
            echo "❌ ServiceProvider file not found at: $serviceProviderPath\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Error loading ServiceProvider: " . $e->getMessage() . "\n";
}

// Cache configuration for production
echo "\nCaching configuration for production...\n";
$cacheCommands = [
    'php artisan config:cache',
    'php artisan route:cache',
    'php artisan view:cache'
];

foreach ($cacheCommands as $command) {
    echo "Running: $command\n";
    exec($command, $output, $returnCode);
    if ($returnCode === 0) {
        echo "✅ $command completed\n";
    } else {
        echo "⚠️  $command failed (this might be normal in some environments)\n";
    }
}

echo "\n=== Fix completed! ===\n";
echo "If you still get errors, try these additional steps:\n";
echo "1. Check file permissions: chmod -R 755 storage bootstrap/cache\n";
echo "2. Check if PHP version is >= 8.1\n";
echo "3. Verify .env file exists and is properly configured\n";
echo "4. Check server error logs for more details\n";
