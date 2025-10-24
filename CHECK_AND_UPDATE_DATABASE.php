<?php
/**
 * CHECK AND UPDATE DATABASE - Script untuk cek dan update database
 * Jalankan: php CHECK_AND_UPDATE_DATABASE.php
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking and updating database...\n";

// 1. Check school_profiles table
echo "Checking school_profiles table...\n";
$profiles = DB::table('school_profiles')->get();

foreach ($profiles as $profile) {
    $fields = ['image', 'image_2', 'image_3', 'image_4'];
    
    foreach ($fields as $field) {
        if (isset($profile->$field) && strpos($profile->$field, 'WhatsApp') !== false) {
            echo "Found WhatsApp reference in $field: " . $profile->$field . "\n";
            
            // Update to new name
            if (strpos($profile->$field, '17.16.29_1bc98572') !== false) {
                DB::table('school_profiles')
                    ->where('id', $profile->id)
                    ->update([$field => 'visi-misi-1.jpg']);
                echo "Updated to: visi-misi-1.jpg\n";
            } elseif (strpos($profile->$field, '17.16.30_9bd4caf6') !== false) {
                DB::table('school_profiles')
                    ->where('id', $profile->id)
                    ->update([$field => 'visi-misi-2.jpg']);
                echo "Updated to: visi-misi-2.jpg\n";
            } elseif (strpos($profile->$field, '17.16.30_a0f5753c') !== false) {
                DB::table('school_profiles')
                    ->where('id', $profile->id)
                    ->update([$field => 'visi-misi-3.jpg']);
                echo "Updated to: visi-misi-3.jpg\n";
            }
        }
    }
}

// 2. Check home_sections table
echo "Checking home_sections table...\n";
$sections = DB::table('home_sections')->get();

foreach ($sections as $section) {
    $fields = ['image', 'image_2', 'image_3', 'image_4'];
    
    foreach ($fields as $field) {
        if (isset($section->$field) && strpos($section->$field, 'WhatsApp') !== false) {
            echo "Found WhatsApp reference in $field: " . $section->$field . "\n";
            
            // Update to new name
            if (strpos($section->$field, '17.16.29_1bc98572') !== false) {
                DB::table('home_sections')
                    ->where('id', $section->id)
                    ->update([$field => 'visi-misi-1.jpg']);
                echo "Updated to: visi-misi-1.jpg\n";
            } elseif (strpos($section->$field, '17.16.30_9bd4caf6') !== false) {
                DB::table('home_sections')
                    ->where('id', $section->id)
                    ->update([$field => 'visi-misi-2.jpg']);
                echo "Updated to: visi-misi-2.jpg\n";
            } elseif (strpos($section->$field, '17.16.30_a0f5753c') !== false) {
                DB::table('home_sections')
                    ->where('id', $section->id)
                    ->update([$field => 'visi-misi-3.jpg']);
                echo "Updated to: visi-misi-3.jpg\n";
            }
        }
    }
}

// 3. Clear cache
echo "Clearing cache...\n";
Artisan::call('cache:clear');
Artisan::call('view:clear');

echo "✅ Database check and update complete!\n";
?>
