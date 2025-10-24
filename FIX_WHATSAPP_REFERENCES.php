<?php
/**
 * FIX WHATSAPP REFERENCES - Script untuk memperbaiki referensi WhatsApp Image di database
 * Akses: https://odetune.shop/FIX_WHATSAPP_REFERENCES.php
 */

echo "<h1>🔧 FIX WHATSAPP REFERENCES</h1>";
echo "<p>Memperbaiki referensi WhatsApp Image di database...</p>";

// 1. Check database for WhatsApp Image references
echo "<h2>📋 Database Check</h2>";

try {
    // Check school_profiles table
    echo "<h3>School Profiles Table</h3>";
    $profiles = DB::table('school_profiles')->get();
    
    foreach ($profiles as $profile) {
        $hasWhatsApp = false;
        $fields = ['image', 'image_2', 'image_3', 'image_4'];
        
        foreach ($fields as $field) {
            if (isset($profile->$field) && strpos($profile->$field, 'WhatsApp') !== false) {
                echo "<p>❌ Found WhatsApp reference in $field: " . $profile->$field . "</p>";
                $hasWhatsApp = true;
            }
        }
        
        if (!$hasWhatsApp) {
            echo "<p>✅ No WhatsApp references in profile ID: " . $profile->id . "</p>";
        }
    }
    
    // Check home_sections table
    echo "<h3>Home Sections Table</h3>";
    $sections = DB::table('home_sections')->get();
    
    foreach ($sections as $section) {
        $hasWhatsApp = false;
        $fields = ['image', 'image_2', 'image_3', 'image_4'];
        
        foreach ($fields as $field) {
            if (isset($section->$field) && strpos($section->$field, 'WhatsApp') !== false) {
                echo "<p>❌ Found WhatsApp reference in $field: " . $section->$field . "</p>";
                $hasWhatsApp = true;
            }
        }
        
        if (!$hasWhatsApp) {
            echo "<p>✅ No WhatsApp references in section ID: " . $section->id . "</p>";
        }
    }
    
    // Check galleries table
    echo "<h3>Galleries Table</h3>";
    $galleries = DB::table('galleries')->get();
    
    foreach ($galleries as $gallery) {
        if (isset($gallery->image) && strpos($gallery->image, 'WhatsApp') !== false) {
            echo "<p>❌ Found WhatsApp reference in gallery: " . $gallery->image . "</p>";
        } else {
            echo "<p>✅ No WhatsApp references in gallery ID: " . $gallery->id . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
}

// 2. Update WhatsApp references to new names
echo "<h2>🔄 Update References</h2>";

try {
    // Update school_profiles table
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
    
    // Update home_sections table
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
    
    // Update galleries table
    for ($i = 0; $i < count($oldNames); $i++) {
        $updated = DB::table('galleries')
            ->where('image', $oldNames[$i])
            ->update(['image' => $newNames[$i]]);
        
        if ($updated > 0) {
            echo "<p>✅ Updated gallery image: {$oldNames[$i]} → {$newNames[$i]} ($updated records)</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p>❌ Update error: " . $e->getMessage() . "</p>";
}

// 3. Verify updates
echo "<h2>✅ Verification</h2>";

try {
    $profiles = DB::table('school_profiles')->get();
    $sections = DB::table('home_sections')->get();
    $galleries = DB::table('galleries')->get();
    
    $allTables = [
        'school_profiles' => $profiles,
        'home_sections' => $sections,
        'galleries' => $galleries
    ];
    
    foreach ($allTables as $tableName => $records) {
        $hasWhatsApp = false;
        
        foreach ($records as $record) {
            $fields = ['image', 'image_2', 'image_3', 'image_4'];
            
            foreach ($fields as $field) {
                if (isset($record->$field) && strpos($record->$field, 'WhatsApp') !== false) {
                    $hasWhatsApp = true;
                    echo "<p>❌ Still found WhatsApp reference in $tableName.$field: " . $record->$field . "</p>";
                }
            }
        }
        
        if (!$hasWhatsApp) {
            echo "<p>✅ No WhatsApp references found in $tableName</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p>❌ Verification error: " . $e->getMessage() . "</p>";
}

echo "<h2>🎉 WHATSAPP REFERENCES FIX COMPLETE!</h2>";
echo "<p>All WhatsApp Image references have been updated to use new URL-friendly names.</p>";
?>
