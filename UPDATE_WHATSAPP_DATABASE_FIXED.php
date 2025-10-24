<?php
/**
 * UPDATE WHATSAPP DATABASE FIXED - Script untuk mengupdate database WhatsApp Image references
 * Jalankan: php UPDATE_WHATSAPP_DATABASE_FIXED.php
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Updating WhatsApp Image references in database...\n";

// 1. Update school_profiles table
echo "Updating school_profiles table...\n";

$oldNames = [
    'WhatsApp Image 2025-10-23 at 17.16.29_1bc98572.jpg',
    'WhatsApp Image 2025-10-23 at 17.16.30_9bd4caf6.jpg',
    'WhatsApp Image 2025-10-23 at 17.16.30_a0f5753c.jpg'
];

$newNames = [
    'visi-misi-1.jpg',
    'visi-misi-2.jpg',
    'visi-misi-3.jpg'
];

// Check which columns exist in school_profiles
$schoolProfileColumns = DB::select("SHOW COLUMNS FROM school_profiles");
$schoolProfileFields = array_column($schoolProfileColumns, 'Field');

$fields = ['image', 'image_2', 'image_3', 'image_4'];
$existingFields = array_intersect($fields, $schoolProfileFields);

foreach ($existingFields as $field) {
    for ($i = 0; $i < count($oldNames); $i++) {
        $updated = DB::table('school_profiles')
            ->where($field, $oldNames[$i])
            ->update([$field => $newNames[$i]]);
        
        if ($updated > 0) {
            echo "✅ Updated $field: {$oldNames[$i]} → {$newNames[$i]} ($updated records)\n";
        }
    }
}

// 2. Update home_sections table
echo "Updating home_sections table...\n";

// Check which columns exist in home_sections
$homeSectionColumns = DB::select("SHOW COLUMNS FROM home_sections");
$homeSectionFields = array_column($homeSectionColumns, 'Field');

$existingFields = array_intersect($fields, $homeSectionFields);

foreach ($existingFields as $field) {
    for ($i = 0; $i < count($oldNames); $i++) {
        $updated = DB::table('home_sections')
            ->where($field, $oldNames[$i])
            ->update([$field => $newNames[$i]]);
        
        if ($updated > 0) {
            echo "✅ Updated $field: {$oldNames[$i]} → {$newNames[$i]} ($updated records)\n";
        }
    }
}

// 3. Update galleries table
echo "Updating galleries table...\n";

for ($i = 0; $i < count($oldNames); $i++) {
    $updated = DB::table('galleries')
        ->where('image', $oldNames[$i])
        ->update(['image' => $newNames[$i]]);
    
    if ($updated > 0) {
        echo "✅ Updated gallery image: {$oldNames[$i]} → {$newNames[$i]} ($updated records)\n";
    }
}

// 4. Clear cache
echo "Clearing cache...\n";
Artisan::call('cache:clear');
Artisan::call('view:clear');
Artisan::call('config:clear');

echo "✅ Database update complete!\n";
echo "WhatsApp Image references have been updated to use new URL-friendly names.\n";
?>
