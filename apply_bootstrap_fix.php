<?php

echo "=== Bootstrap DomPDF Fix Application ===\n\n";

// Check if we're in the right directory
if (!file_exists('composer.json')) {
    echo "❌ composer.json not found. Please run from project root.\n";
    exit(1);
}

// Check if bootstrap/app.php exists
$bootstrapFile = 'bootstrap/app.php';
if (!file_exists($bootstrapFile)) {
    echo "❌ bootstrap/app.php not found.\n";
    exit(1);
}

// Backup original bootstrap/app.php
$backupFile = 'bootstrap/app.php.backup';
if (!file_exists($backupFile)) {
    copy($bootstrapFile, $backupFile);
    echo "✅ Original bootstrap/app.php backed up to bootstrap/app.php.backup\n";
} else {
    echo "✅ Backup already exists\n";
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

// Read the current bootstrap/app.php
$bootstrapContent = file_get_contents($bootstrapFile);
if ($bootstrapContent === false) {
    echo "❌ Failed to read bootstrap/app.php\n";
    exit(1);
}

// Check if the fix is already applied
if (strpos($bootstrapContent, 'EMERGENCY FIX: Manually load DomPDF ServiceProvider') !== false) {
    echo "✅ Bootstrap fix already applied\n";
} else {
    // Apply the fix
    echo "Applying bootstrap fix...\n";
    
    // Find the line with "use Illuminate\Foundation\Application;"
    $lines = explode("\n", $bootstrapContent);
    $newLines = [];
    $fixApplied = false;
    
    foreach ($lines as $line) {
        $newLines[] = $line;
        
        // Add the fix after the use statements
        if (strpos($line, 'use Illuminate\Foundation\Configuration\Middleware;') !== false && !$fixApplied) {
            $newLines[] = '';
            $newLines[] = '// EMERGENCY FIX: Manually load DomPDF ServiceProvider';
            $newLines[] = '$dompdfServiceProviderPath = __DIR__.\'/../vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php\';';
            $newLines[] = 'if (file_exists($dompdfServiceProviderPath)) {';
            $newLines[] = '    require_once $dompdfServiceProviderPath;';
            $newLines[] = '}';
            $newLines[] = '';
            $fixApplied = true;
        }
    }
    
    $newContent = implode("\n", $newLines);
    
    // Write the fixed bootstrap/app.php
    if (file_put_contents($bootstrapFile, $newContent)) {
        echo "✅ Bootstrap fix applied to bootstrap/app.php\n";
    } else {
        echo "❌ Failed to apply bootstrap fix to bootstrap/app.php\n";
        exit(1);
    }
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

echo "\n=== Bootstrap fix applied! ===\n";
echo "The bootstrap/app.php file has been modified to manually load the DomPDF ServiceProvider.\n";
echo "This should resolve the 'Class not found' error.\n";
echo "If you need to revert, restore from bootstrap/app.php.backup\n";
