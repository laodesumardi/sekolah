<?php
/**
 * QUICK WHATSAPP FIX - Script cepat untuk memperbaiki referensi WhatsApp Image
 * Akses: https://odetune.shop/QUICK_WHATSAPP_FIX.php
 */

echo "<h1>🚀 QUICK WHATSAPP FIX</h1>";

// 1. Update school_profiles table
echo "<h2>📋 Updating School Profiles</h2>";

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

$fields = ['image', 'image_2', 'image_3', 'image_4'];

foreach ($fields as $field) {
    for ($i = 0; $i < count($oldNames); $i++) {
        $updated = DB::table('school_profiles')
            ->where($field, $oldNames[$i])
            ->update([$field => $newNames[$i]]);
        
        if ($updated > 0) {
            echo "<p>✅ Updated $field: {$oldNames[$i]} → {$newNames[$i]} ($updated records)</p>";
        }
    }
}

// 2. Update home_sections table
echo "<h2>📋 Updating Home Sections</h2>";

foreach ($fields as $field) {
    for ($i = 0; $i < count($oldNames); $i++) {
        $updated = DB::table('home_sections')
            ->where($field, $oldNames[$i])
            ->update([$field => $newNames[$i]]);
        
        if ($updated > 0) {
            echo "<p>✅ Updated $field: {$oldNames[$i]} → {$newNames[$i]} ($updated records)</p>";
        }
    }
}

// 3. Update galleries table
echo "<h2>📋 Updating Galleries</h2>";

for ($i = 0; $i < count($oldNames); $i++) {
    $updated = DB::table('galleries')
        ->where('image', $oldNames[$i])
        ->update(['image' => $newNames[$i]]);
    
    if ($updated > 0) {
        echo "<p>✅ Updated gallery image: {$oldNames[$i]} → {$newNames[$i]} ($updated records)</p>";
    }
}

// 4. Clear cache
echo "<h2>🧹 Clearing Cache</h2>";
echo "<p>Clearing application cache...</p>";

// Clear view cache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "<p>✅ OPcache cleared</p>";
}

echo "<h2>✅ QUICK FIX COMPLETE!</h2>";
echo "<p>WhatsApp Image references have been updated to use new URL-friendly names.</p>";
echo "<p>Please refresh the page to see the changes.</p>";
?>
