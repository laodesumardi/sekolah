<?php
/**
 * Script untuk memperbaiki masalah login di hosting
 * Jalankan script ini di hosting untuk memperbaiki konfigurasi
 */

echo "🔧 Memperbaiki konfigurasi login untuk hosting...\n\n";

// 1. Clear semua cache
echo "1. Clearing cache...\n";
if (function_exists('exec')) {
    exec('php artisan cache:clear 2>&1', $output);
    echo "   Cache cleared\n";
    
    exec('php artisan config:clear 2>&1', $output);
    echo "   Config cleared\n";
    
    exec('php artisan route:clear 2>&1', $output);
    echo "   Routes cleared\n";
    
    exec('php artisan view:clear 2>&1', $output);
    echo "   Views cleared\n";
} else {
    echo "   exec() function not available\n";
}

// 2. Set environment untuk hosting
echo "\n2. Setting environment for hosting...\n";
$envFile = '.env';
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    
    // Update APP_URL
    $envContent = preg_replace('/APP_URL=.*/', 'APP_URL=https://odetune.shop', $envContent);
    
    // Update SESSION_DOMAIN
    $envContent = preg_replace('/SESSION_DOMAIN=.*/', 'SESSION_DOMAIN=odetune.shop', $envContent);
    
    // Update SESSION_SECURE_COOKIE
    $envContent = preg_replace('/SESSION_SECURE_COOKIE=.*/', 'SESSION_SECURE_COOKIE=true', $envContent);
    
    // Update SESSION_SAME_SITE
    $envContent = preg_replace('/SESSION_SAME_SITE=.*/', 'SESSION_SAME_SITE=lax', $envContent);
    
    // Update SESSION_HTTP_ONLY
    $envContent = preg_replace('/SESSION_HTTP_ONLY=.*/', 'SESSION_HTTP_ONLY=false', $envContent);
    
    file_put_contents($envFile, $envContent);
    echo "   Environment updated\n";
} else {
    echo "   .env file not found\n";
}

// 3. Test database connection
echo "\n3. Testing database connection...\n";
try {
    require 'vendor/autoload.php';
    $app = require 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    $userCount = App\Models\User::count();
    echo "   Database connected successfully\n";
    echo "   Users count: $userCount\n";
} catch (Exception $e) {
    echo "   Database connection failed: " . $e->getMessage() . "\n";
}

// 4. Test session configuration
echo "\n4. Testing session configuration...\n";
try {
    $sessionDriver = config('session.driver');
    $sessionLifetime = config('session.lifetime');
    $sessionDomain = config('session.domain');
    $sessionSecure = config('session.secure');
    
    echo "   Session driver: $sessionDriver\n";
    echo "   Session lifetime: $sessionLifetime\n";
    echo "   Session domain: $sessionDomain\n";
    echo "   Session secure: " . ($sessionSecure ? 'Yes' : 'No') . "\n";
} catch (Exception $e) {
    echo "   Session configuration error: " . $e->getMessage() . "\n";
}

// 5. Test login functionality
echo "\n5. Testing login functionality...\n";
try {
    $testCredentials = [
        'email' => 'admin@smpnamrole.sch.id',
        'password' => 'admin123'
    ];
    
    if (Auth::attempt($testCredentials)) {
        echo "   ✓ Login test successful\n";
        Auth::logout();
    } else {
        echo "   ✗ Login test failed\n";
    }
} catch (Exception $e) {
    echo "   Login test error: " . $e->getMessage() . "\n";
}

echo "\n✅ Hosting configuration fix completed!\n";
echo "\n📋 Next steps:\n";
echo "1. Upload this script to your hosting\n";
echo "2. Run: php fix-hosting-login.php\n";
echo "3. Test login at https://odetune.shop/login\n";
echo "4. If still having issues, check hosting logs\n";
