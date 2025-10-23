<?php

echo "=== Quick DomPDF Fix for Production ===\n\n";

// Step 1: Clear everything
echo "1. Clearing all caches and temporary files...\n";
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

// Step 2: Reinstall dependencies
echo "2. Reinstalling dependencies...\n";
exec('composer install --no-dev --optimize-autoloader --no-cache', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Dependencies reinstalled\n";
} else {
    echo "❌ Failed to reinstall dependencies\n";
    exit(1);
}

// Step 3: Regenerate autoload
echo "3. Regenerating autoload...\n";
exec('composer dump-autoload --optimize', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Autoload regenerated\n";
} else {
    echo "❌ Failed to regenerate autoload\n";
    exit(1);
}

// Step 4: Test the fix
echo "4. Testing DomPDF ServiceProvider...\n";
try {
    require_once 'vendor/autoload.php';
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo "✅ SUCCESS: DomPDF ServiceProvider is now available!\n";
    } else {
        echo "❌ FAILED: DomPDF ServiceProvider still not found\n";
        echo "Trying manual fix...\n";
        
        // Manual fix: directly require the service provider
        $spPath = 'vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php';
        if (file_exists($spPath)) {
            require_once $spPath;
            echo "✅ Manually loaded ServiceProvider\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Quick fix completed! ===\n";
echo "Try accessing your website now.\n";
