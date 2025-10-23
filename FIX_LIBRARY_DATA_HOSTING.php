<?php
/**
 * FIX LIBRARY DATA HOSTING - Script untuk memperbaiki data perpustakaan di hosting
 * Akses: https://odetune.shop/FIX_LIBRARY_DATA_HOSTING.php
 */

echo "<h1>🔧 FIX LIBRARY DATA HOSTING</h1>";
echo "<p>Memperbaiki data perpustakaan yang rusak...</p>";

// Bootstrap Laravel
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Library;

echo "<h2>📋 Current Library Data</h2>";

// Check current data
$libraries = Library::all();
if ($libraries->count() > 0) {
    echo "<p>Found {$libraries->count()} library records:</p>";
    echo "<ul>";
    foreach ($libraries as $library) {
        echo "<li>ID: {$library->id} - Name: {$library->name} - Active: " . ($library->is_active ? 'Yes' : 'No') . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No library records found</p>";
}

echo "<h2>🗑️ Cleaning Data</h2>";

// Delete all existing library data
Library::truncate();
echo "<p>✅ All existing library data deleted</p>";

echo "<h2>📝 Creating Proper Data</h2>";

// Create proper library data
$library = Library::create([
    'name' => 'Perpustakaan SMP Negeri 01 Namrole',
    'description' => 'Perpustakaan sekolah yang menyediakan berbagai koleksi buku dan sumber belajar untuk mendukung proses pembelajaran siswa. Perpustakaan ini dilengkapi dengan fasilitas modern dan koleksi yang lengkap.',
    'location' => 'Gedung Utama Lantai 2, SMP Negeri 01 Namrole',
    'phone' => '(0381) 123456',
    'email' => 'perpustakaan@smpn01namrole.sch.id',
    'opening_hours' => "Senin - Jumat: 07:00 - 15:00\nSabtu: 08:00 - 12:00\nMinggu: Tutup",
    'services' => "• Peminjaman buku\n• Baca di tempat\n• Akses internet\n• Fotokopi\n• Konsultasi literasi\n• Program literasi sekolah",
    'rules' => "1. Dilarang makan dan minum di dalam perpustakaan\n2. Harus menjaga ketenangan\n3. Buku yang dipinjam harus dikembalikan tepat waktu\n4. Dilarang merusak atau mencoret-coret buku\n5. Wajib menjaga kebersihan perpustakaan",
    'librarian_name' => 'Siti Aminah, S.Pd',
    'librarian_phone' => '081234567890',
    'librarian_email' => 'siti.aminah@smpn01namrole.sch.id',
    'organization_chart' => 'libraries/1761143094_68f8e936e11f1.png',
    'facilities' => "• Ruang baca dengan kapasitas 50 orang\n• 10 unit komputer untuk akses digital\n• Ruang diskusi kelompok\n• Area koleksi referensi\n• Ruang multimedia",
    'collection_info' => "• Total koleksi: 5.000+ buku\n• Buku pelajaran: 2.500 eksemplar\n• Buku referensi: 1.000 eksemplar\n• Buku fiksi: 1.000 eksemplar\n• Majalah dan koran: 500 eksemplar\n• Koleksi digital: 500 judul",
    'membership_info' => "• Gratis untuk semua siswa dan guru SMP Negeri 01 Namrole\n• Pendaftaran keanggotaan dilakukan di perpustakaan\n• Membawa kartu pelajar/guru untuk pendaftaran\n• Masa berlaku keanggotaan: 1 tahun akademik",
    'is_active' => true,
]);

echo "<p>✅ Library data created successfully!</p>";
echo "<p>ID: {$library->id}</p>";
echo "<p>Name: {$library->name}</p>";

echo "<h2>🔍 Verification</h2>";

// Verify data
$verifyLibrary = Library::where('is_active', true)->first();
if ($verifyLibrary) {
    echo "<p>✅ Library found and active</p>";
    echo "<p>Name: {$verifyLibrary->name}</p>";
    echo "<p>Phone: {$verifyLibrary->phone}</p>";
    echo "<p>Email: {$verifyLibrary->email}</p>";
} else {
    echo "<p>❌ No active library found</p>";
}

echo "<h2>🎉 FIX COMPLETE!</h2>";
echo "<p>The library page should now display proper information.</p>";
echo "<p><a href='/perpustakaan' target='_blank'>Test Library Page</a></p>";
?>
