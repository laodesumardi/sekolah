# DomPDF Production Fix Script for Windows
Write-Host "=== DomPDF Production Fix Script ===" -ForegroundColor Green
Write-Host "This script will fix the 'Class Barryvdh\DomPDF\ServiceProvider not found' error" -ForegroundColor Yellow
Write-Host ""

# Check if we're in the right directory
if (!(Test-Path "composer.json")) {
    Write-Host "❌ composer.json not found. Please run this script from the project root." -ForegroundColor Red
    exit 1
}

Write-Host "✅ Found composer.json" -ForegroundColor Green

# Step 1: Remove all cache and temporary files
Write-Host ""
Write-Host "Step 1: Clearing all cache and temporary files..." -ForegroundColor Cyan

# Clear Laravel caches
if (Test-Path "bootstrap/cache") { Remove-Item -Path "bootstrap/cache/*" -Recurse -Force -ErrorAction SilentlyContinue }
if (Test-Path "storage/framework/cache") { Remove-Item -Path "storage/framework/cache/*" -Recurse -Force -ErrorAction SilentlyContinue }
if (Test-Path "storage/framework/sessions") { Remove-Item -Path "storage/framework/sessions/*" -Recurse -Force -ErrorAction SilentlyContinue }
if (Test-Path "storage/framework/views") { Remove-Item -Path "storage/framework/views/*" -Recurse -Force -ErrorAction SilentlyContinue }
if (Test-Path "storage/logs") { Remove-Item -Path "storage/logs/*" -Recurse -Force -ErrorAction SilentlyContinue }

# Remove vendor directory to force clean reinstall
Write-Host "Removing vendor directory for clean reinstall..." -ForegroundColor Yellow
if (Test-Path "vendor") { Remove-Item -Path "vendor" -Recurse -Force -ErrorAction SilentlyContinue }

Write-Host "✅ Cache cleared" -ForegroundColor Green

# Step 2: Reinstall dependencies
Write-Host ""
Write-Host "Step 2: Reinstalling dependencies..." -ForegroundColor Cyan
$composerResult = & composer install --no-dev --optimize-autoloader --no-cache 2>&1

if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to install dependencies" -ForegroundColor Red
    Write-Host $composerResult
    exit 1
}

Write-Host "✅ Dependencies installed" -ForegroundColor Green

# Step 3: Regenerate autoload
Write-Host ""
Write-Host "Step 3: Regenerating autoload..." -ForegroundColor Cyan
$autoloadResult = & composer dump-autoload --optimize 2>&1

if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to regenerate autoload" -ForegroundColor Red
    Write-Host $autoloadResult
    exit 1
}

Write-Host "✅ Autoload regenerated" -ForegroundColor Green

# Step 4: Run Laravel commands
Write-Host ""
Write-Host "Step 4: Running Laravel optimization commands..." -ForegroundColor Cyan

# Clear Laravel caches
try { & php artisan optimize:clear 2>$null } catch { Write-Host "⚠️  optimize:clear failed (might be normal)" -ForegroundColor Yellow }

# Run package discovery
try { & php artisan package:discover 2>$null } catch { Write-Host "⚠️  package:discover failed (might be normal)" -ForegroundColor Yellow }

# Publish DomPDF config
try { & php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --tag=config 2>$null } catch { Write-Host "⚠️  vendor:publish failed (might be normal)" -ForegroundColor Yellow }

# Cache for production
try { & php artisan config:cache 2>$null } catch { Write-Host "⚠️  config:cache failed (might be normal)" -ForegroundColor Yellow }
try { & php artisan route:cache 2>$null } catch { Write-Host "⚠️  route:cache failed (might be normal)" -ForegroundColor Yellow }
try { & php artisan view:cache 2>$null } catch { Write-Host "⚠️  view:cache failed (might be normal)" -ForegroundColor Yellow }

Write-Host "✅ Laravel commands completed" -ForegroundColor Green

# Step 5: Test the fix
Write-Host ""
Write-Host "Step 5: Testing DomPDF ServiceProvider..." -ForegroundColor Cyan

$testScript = @"
try {
    require_once 'vendor/autoload.php';
    if (class_exists('Barryvdh\\DomPDF\\ServiceProvider')) {
        echo '✅ SUCCESS: DomPDF ServiceProvider is now available!' . PHP_EOL;
    } else {
        echo '❌ FAILED: DomPDF ServiceProvider still not found' . PHP_EOL;
        exit(1);
    }
} catch (Exception `$e) {
    echo '❌ ERROR: ' . `$e->getMessage() . PHP_EOL;
    exit(1);
}
"@

$testResult = & php -r $testScript 2>&1
Write-Host $testResult

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "🎉 SUCCESS! DomPDF ServiceProvider error has been fixed!" -ForegroundColor Green
    Write-Host "Your website should now work properly." -ForegroundColor Green
} else {
    Write-Host ""
    Write-Host "❌ The fix did not work. Please check the following:" -ForegroundColor Red
    Write-Host "1. Make sure PHP version is >= 8.1" -ForegroundColor Yellow
    Write-Host "2. Check file permissions" -ForegroundColor Yellow
    Write-Host "3. Verify .env file exists and is properly configured" -ForegroundColor Yellow
    Write-Host "4. Check server error logs for more details" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "=== Fix completed ===" -ForegroundColor Green
