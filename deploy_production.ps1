# Production Deployment Script for Windows
Write-Host "=== Production Deployment Script ===" -ForegroundColor Green
Write-Host "Fixing DomPDF ServiceProvider issue..." -ForegroundColor Yellow

# 1. Clear all caches
Write-Host "1. Clearing all Laravel caches..." -ForegroundColor Cyan
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Reinstall dependencies
Write-Host "2. Reinstalling dependencies..." -ForegroundColor Cyan
composer install --no-dev --optimize-autoloader --no-cache

# 3. Regenerate autoload
Write-Host "3. Regenerating autoload..." -ForegroundColor Cyan
composer dump-autoload --optimize

# 4. Run package discovery
Write-Host "4. Running package discovery..." -ForegroundColor Cyan
php artisan package:discover

# 5. Publish DomPDF config
Write-Host "5. Publishing DomPDF configuration..." -ForegroundColor Cyan
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --tag=config

# 6. Cache configuration
Write-Host "6. Caching configuration..." -ForegroundColor Cyan
php artisan config:cache

# 7. Cache routes
Write-Host "7. Caching routes..." -ForegroundColor Cyan
php artisan route:cache

# 8. Cache views
Write-Host "8. Caching views..." -ForegroundColor Cyan
php artisan view:cache

Write-Host "=== Deployment completed! ===" -ForegroundColor Green
Write-Host "All caches cleared and optimized for production." -ForegroundColor Yellow
