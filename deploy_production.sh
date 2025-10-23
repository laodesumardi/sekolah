#!/bin/bash

echo "=== Production Deployment Script ==="
echo "Fixing DomPDF ServiceProvider issue..."

# 1. Clear all caches
echo "1. Clearing all Laravel caches..."
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Reinstall dependencies
echo "2. Reinstalling dependencies..."
composer install --no-dev --optimize-autoloader --no-cache

# 3. Regenerate autoload
echo "3. Regenerating autoload..."
composer dump-autoload --optimize

# 4. Run package discovery
echo "4. Running package discovery..."
php artisan package:discover

# 5. Publish DomPDF config
echo "5. Publishing DomPDF configuration..."
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --tag=config

# 6. Cache configuration
echo "6. Caching configuration..."
php artisan config:cache

# 7. Cache routes
echo "7. Caching routes..."
php artisan route:cache

# 8. Cache views
echo "8. Caching views..."
php artisan view:cache

# 9. Set proper permissions
echo "9. Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "=== Deployment completed! ==="
echo "All caches cleared and optimized for production."
