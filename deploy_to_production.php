<?php

echo "🚀 Deploying to Production...\n\n";

// 1. Clear all caches
echo "1. Clearing caches...\n";
exec('php artisan config:cache');
exec('php artisan route:cache');
exec('php artisan view:cache');
exec('php artisan optimize');

echo "✅ Caches cleared\n\n";

// 2. Set proper permissions
echo "2. Setting permissions...\n";
$directories = [
    'storage',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0755);
        echo "✅ Set permissions for: $dir\n";
    }
}

echo "\n3. Creating storage symlinks...\n";
exec('php artisan storage:link');

echo "\n4. Checking environment...\n";
if (file_exists('.env')) {
    echo "✅ .env file exists\n";
} else {
    echo "❌ .env file missing - copy from .env.example\n";
}

echo "\n5. Final optimizations...\n";
exec('composer install --optimize-autoloader --no-dev');
exec('php artisan config:cache');
exec('php artisan route:cache');
exec('php artisan view:cache');

echo "\n🎉 Deployment completed!\n";
echo "\n📋 Next steps:\n";
echo "1. Upload files to hosting\n";
echo "2. Set APP_URL=https://smpnegeri01namrole.sch.id\n";
echo "3. Configure database credentials\n";
echo "4. Test the website\n";
