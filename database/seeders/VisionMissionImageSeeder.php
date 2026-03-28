<?php

namespace Database\Seeders;

use App\Models\VisionMission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VisionMissionImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan direktori storage untuk vision-missions ada
        Storage::disk('public')->makeDirectory('vision-missions');

        // Daftar file publik yang akan dimasukkan
        $publicImages = [
            'visi-misi-1.jpg',
            'visi-misi-2.jpg',
            'visi-misi-3.jpg'
        ];

        // Salin gambar dari public ke storage/app/public/vision-missions
        foreach ($publicImages as $imageName) {
            $publicPath = public_path($imageName);
            $storagePath = 'vision-missions/' . $imageName;

            if (file_exists($publicPath)) {
                // Copy ke storage disk 'public'
                $content = @file_get_contents($publicPath);
                if ($content !== false) {
                    Storage::disk('public')->put($storagePath, $content);
                }

                // Copy ke public/storage untuk hosting tanpa symlink
                if (function_exists('copy_storage_to_public')) {
                    @copy_storage_to_public($storagePath);
                }
            }
        }

        // Ambil record VisionMission pertama, jika ada update image, jika tidak buat baru
        $firstImage = 'vision-missions/visi-misi-1.jpg';
        $existing = VisionMission::first();
        if ($existing) {
            $existing->update([
                'image' => $firstImage,
                'is_active' => true,
            ]);
        } else {
            VisionMission::create([
                'vision' => 'Menjadi sekolah unggul yang berkarakter, berprestasi, dan berdaya saing global.',
                'missions' => [
                    'Menyelenggarakan pendidikan yang berkualitas dengan mengintegrasikan nilai-nilai karakter',
                    'Mengembangkan potensi siswa melalui pembelajaran yang kreatif dan inovatif',
                    'Membina hubungan yang harmonis antara sekolah, orang tua, dan masyarakat',
                    'Menyediakan fasilitas pembelajaran yang memadai dan modern',
                    'Membentuk siswa yang memiliki kepedulian sosial dan lingkungan'
                ],
                'is_active' => true,
                'image' => $firstImage,
            ]);
        }
    }
}