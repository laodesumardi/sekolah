<?php
/**
 * FIX_HOSTING_IMAGES.php
 *
 * Tujuan:
 * - Mencoba membuat symlink `public/storage` -> `storage/app/public` via `php artisan storage:link`
 * - Jika hosting tidak mendukung symlink, lakukan fallback: salin file secara rekursif
 *   dari `storage/app/public` ke `public/storage`
 * - Membuat .htaccess sederhana untuk mengizinkan akses file statis dan mencegah directory listing
 *
 * Cara pakai di hosting:
 * 1) Upload file ini ke root project Laravel (folder yang sama dengan composer.json)
 * 2) Jalankan: `php FIX_HOSTING_IMAGES.php`
 * 3) Cek halaman: /perpustakaan dan fitur lain yang pakai file di storage
 */

function logln(string $msg): void {
    echo $msg . "\n";
}

function ensureDir(string $path): bool {
    if (!is_dir($path)) {
        return mkdir($path, 0755, true);
    }
    return true;
}

function rcopy(string $src, string $dst): array {
    $copied = 0; $skipped = 0; $errors = 0;

    if (!is_dir($src)) {
        return [$copied, $skipped, ++$errors];
    }
    if (!ensureDir($dst)) {
        return [$copied, $skipped, ++$errors];
    }

    $dir = opendir($src);
    if ($dir === false) {
        return [$copied, $skipped, ++$errors];
    }

    while (false !== ($file = readdir($dir))) {
        if ($file === '.' || $file === '..') continue;
        $srcPath = $src . DIRECTORY_SEPARATOR . $file;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $file;

        if (is_dir($srcPath)) {
            [$c, $s, $e] = rcopy($srcPath, $dstPath);
            $copied += $c; $skipped += $s; $errors += $e;
        } else {
            if (file_exists($dstPath)) {
                $skipped++;
            } else {
                if (@copy($srcPath, $dstPath)) {
                    $copied++;
                } else {
                    $errors++;
                }
            }
        }
    }
    closedir($dir);
    return [$copied, $skipped, $errors];
}

logln("=== Hosting Images Fix (storage:link + fallback copy) ===\n");

// Validasi lokasi
if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'composer.json')) {
    logln('❌ composer.json tidak ditemukan. Jalankan skrip dari root project.');
    exit(1);
}

$projectRoot = __DIR__;
$storageAppPublic = $projectRoot . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public';
$publicStorage = $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'storage';

if (!is_dir($storageAppPublic)) {
    logln('❌ Folder sumber tidak ditemukan: ' . $storageAppPublic);
    exit(1);
}

// Coba artisan storage:link
$symlinkCreated = false;
if (function_exists('exec')) {
    logln('Mencoba membuat symlink via: php artisan storage:link');
    @exec('php artisan storage:link 2>&1', $output, $code);
    foreach (($output ?? []) as $line) {
        logln('> ' . $line);
    }
    logln('Exit code: ' . ($code ?? 'unknown'));

    // Deteksi symlink
    if (is_link($publicStorage)) {
        $symlinkCreated = true;
        logln('✅ Symlink public/storage berhasil dibuat.');
    } else {
        logln('⚠️  Symlink tidak terdeteksi atau tidak didukung hosting. Melanjutkan ke fallback copy.');
    }
} else {
    logln('⚠️  Fungsi exec() tidak tersedia. Langsung fallback copy.');
}

// Fallback: salin file dari storage/app/public ke public/storage
if (!$symlinkCreated) {
    logln('Menyalin file dari storage/app/public ke public/storage ...');
    if (!ensureDir($publicStorage)) {
        logln('❌ Gagal membuat folder: ' . $publicStorage);
        exit(1);
    }

    [$copied, $skipped, $errors] = rcopy($storageAppPublic, $publicStorage);
    logln("📦 Hasil copy => copied: $copied, skipped: $skipped, errors: $errors");

    // Buat .htaccess sederhana
    $htaccessPath = $publicStorage . DIRECTORY_SEPARATOR . '.htaccess';
    $htaccessContent = "Options -Indexes\n<IfModule mod_headers.c>\n    Header set Access-Control-Allow-Origin \"*\"\n</IfModule>\n";
    @file_put_contents($htaccessPath, $htaccessContent);
    logln('✅ .htaccess ditulis di ' . $htaccessPath);
}

// Ringkasan & Next Steps
logln("\n=== Selesai ===");
if ($symlinkCreated) {
    logln('Publikasi storage menggunakan symlink telah aktif.');
} else {
    logln('Fallback copy aktif: file disalin ke public/storage.');
}
logln("Cek halaman gambar: /perpustakaan, galeri, fasilitas, profil sekolah.");
logln("Jika gambar masih tidak muncul: pastikan APP_URL=https://odetune.shop, dan clear cache: php artisan optimize:clear");