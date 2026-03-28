#!/bin/bash

echo "=== DomPDF Production Fix Script ==="
echo "This script will fix the 'Class Barryvdh\DomPDF\ServiceProvider not found' error"
echo ""

# Check if we're in the right directory
if [ ! -f "composer.json" ]; then
    echo "❌ composer.json not found. Please run this script from the project root."
    exit 1
fi

echo "✅ Found composer.json"

# Step 1: Remove all cache and temporary files
echo ""
echo "Step 1: Clearing all cache and temporary files..."
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf storage/logs/*

# Remove vendor directory to force clean reinstall
echo "Removing vendor directory for clean reinstall..."
rm -rf vendor/

echo "✅ Cache cleared"

# Step 2: Reinstall dependencies
echo ""
echo "Step 2: Reinstalling dependencies..."
composer install --no-dev --optimize-autoloader --no-cache

if [ $? -ne 0 ]; then
    echo "❌ Failed to install dependencies"
    exit 1
fi

echo "✅ Dependencies installed"

# Step 3: Regenerate autoload
echo ""
echo "Step 3: Regenerating autoload..."
composer dump-autoload --optimize

if [ $? -ne 0 ]; then
    echo "❌ Failed to regenerate autoload"
    exit 1
fi

echo "✅ Autoload regenerated"

# Step 4: Run Laravel commands
echo ""
echo "Step 4: Running Laravel optimization commands..."

# Clear Laravel caches
php artisan optimize:clear 2>/dev/null || echo "⚠️  optimize:clear failed (might be normal)"

# Run package discovery
php artisan package:discover 2>/dev/null || echo "⚠️  package:discover failed (might be normal)"

# Publish DomPDF config
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --tag=config 2>/dev/null || echo "⚠️  vendor:publish failed (might be normal)"

# Cache for production
php artisan config:cache 2>/dev/null || echo "⚠️  config:cache failed (might be normal)"
php artisan route:cache 2>/dev/null || echo "⚠️  route:cache failed (might be normal)"
php artisan view:cache 2>/dev/null || echo "⚠️  view:cache failed (might be normal)"

echo "✅ Laravel commands completed"

# Step 5: Test the fix
echo ""
echo "Step 5: Testing DomPDF ServiceProvider..."
php -r "
try {
    require_once 'vendor/autoload.php';
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo '✅ SUCCESS: DomPDF ServiceProvider is now available!\n';
    } else {
        echo '❌ FAILED: DomPDF ServiceProvider still not found\n';
        exit(1);
    }
} catch (Exception \$e) {
    echo '❌ ERROR: ' . \$e->getMessage() . '\n';
    exit(1);
}
"

if [ $? -eq 0 ]; then
    echo ""
    echo "🎉 SUCCESS! DomPDF ServiceProvider error has been fixed!"
    echo "Your website should now work properly."
else
    echo ""
    echo "❌ The fix did not work. Please check the following:"
    echo "1. Make sure PHP version is >= 8.1"
    echo "2. Check file permissions: chmod -R 755 storage bootstrap/cache"
    echo "3. Verify .env file exists and is properly configured"
    echo "4. Check server error logs for more details"
fi

echo ""
echo "=== Fix completed ==="
