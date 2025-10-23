<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use App\Models\Accreditation;
use App\Models\Achievement;

class ProfilController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $sections = SchoolProfile::where('is_active', true)
                                ->orderBy('sort_order')
                                ->get()
                                ->keyBy('section_key');
        
        // Ambil data akreditasi dan prestasi dari database
        $accreditation = Accreditation::active()->first();
        $achievements = Achievement::active()->orderBy('year', 'desc')->get();
        
        // Data profil sekolah dari database
        $profilData = [
            'hero_title' => $sections->get('hero')->title ?? 'Profil Sekolah',
            'hero_subtitle' => $sections->get('hero')->subtitle ?? $sections->get('hero')->content ?? 'SMP Negeri 01 Namrole - Sekolah Unggul Berkarakter',
            'hero_background' => $sections->get('hero')->image ?? null,
            'sejarah' => [
                'judul' => $sections->get('sejarah')->title ?? 'Sejarah Singkat SMP Negeri 01 Namrole',
                'konten' => $sections->get('sejarah')->content ?? 'SMP Negeri 01 Namrole didirikan pada tahun 1985 sebagai salah satu sekolah menengah pertama negeri di Kabupaten Maluku Tengah. Sekolah ini dibangun dengan tujuan untuk memberikan akses pendidikan yang berkualitas kepada masyarakat di wilayah Namrole dan sekitarnya. Sejak berdiri, sekolah ini telah mengalami berbagai perkembangan dan peningkatan fasilitas untuk mendukung proses pembelajaran yang optimal.',
                'tahun_berdiri' => '1985',
                'lokasi' => 'Namrole, Maluku Tengah'
            ],
            'visi_misi' => [
                'gambar' => $this->getVisiMisiImages()
            ],
            'struktur_organisasi' => [
                'gambar' => ($sections->get('struktur') ? $sections->get('struktur')->image_url : asset('images/default-school-profile.png')),
                'judul' => $sections->get('struktur')->title ?? 'Struktur Organisasi SMP Negeri 01 Namrole',
                'deskripsi' => $sections->get('struktur')->content ?? 'Struktur organisasi sekolah yang menunjukkan hierarki kepemimpinan dan pembagian tugas di SMP Negeri 01 Namrole.'
            ],
            'tenaga_pendidik' => [
                'content' => $sections->get('tenaga-pendidik')->content ?? 'SMP Negeri 01 Namrole memiliki tenaga pendidik yang berkualitas dan berpengalaman. Semua guru telah memenuhi kualifikasi akademik dan memiliki sertifikasi pendidik. Mereka berkomitmen untuk memberikan pendidikan terbaik kepada siswa.',
                'guru_mata_pelajaran' => [
                    ['nama' => 'Dr. Maria Magdalena, M.Pd', 'mata_pelajaran' => 'Matematika', 'pendidikan' => 'S3 Pendidikan Matematika'],
                    ['nama' => 'Ahmad Fauzi, S.Pd', 'mata_pelajaran' => 'Bahasa Indonesia', 'pendidikan' => 'S1 Pendidikan Bahasa Indonesia'],
                    ['nama' => 'Sarah Johnson, S.Pd', 'mata_pelajaran' => 'Bahasa Inggris', 'pendidikan' => 'S1 Pendidikan Bahasa Inggris'],
                    ['nama' => 'Prof. Dr. Budi Hartono, M.Pd', 'mata_pelajaran' => 'IPA', 'pendidikan' => 'S3 Pendidikan IPA'],
                    ['nama' => 'Siti Aminah, S.Pd', 'mata_pelajaran' => 'IPS', 'pendidikan' => 'S1 Pendidikan IPS'],
                    ['nama' => 'Muhammad Ali, S.Pd', 'mata_pelajaran' => 'Pendidikan Agama Islam', 'pendidikan' => 'S1 Pendidikan Agama Islam'],
                    ['nama' => 'Eka Sari, S.Pd', 'mata_pelajaran' => 'Seni Budaya', 'pendidikan' => 'S1 Pendidikan Seni'],
                    ['nama' => 'Rudi Hartono, S.Pd', 'mata_pelajaran' => 'PJOK', 'pendidikan' => 'S1 Pendidikan Olahraga']
                ],
                'tenaga_kependidikan' => [
                    ['nama' => 'Sari Indah, S.Pd', 'jabatan' => 'Tata Usaha', 'pendidikan' => 'S1 Administrasi Pendidikan'],
                    ['nama' => 'Bambang Sutrisno', 'jabatan' => 'Petugas Kebersihan', 'pendidikan' => 'SMA'],
                    ['nama' => 'Dewi Kartika, S.Pd', 'jabatan' => 'Pustakawan', 'pendidikan' => 'S1 Ilmu Perpustakaan'],
                    ['nama' => 'Ahmad Rifai', 'jabatan' => 'Satpam', 'pendidikan' => 'SMA']
                ]
            ],
            'akreditasi' => [
                'content' => $sections->get('akreditasi')->content ?? 'SMP Negeri 01 Namrole telah terakreditasi A dengan skor 95. Akreditasi ini menunjukkan kualitas pendidikan yang tinggi dan komitmen sekolah dalam memberikan pelayanan terbaik kepada siswa dan masyarakat.',
                'status' => $accreditation->status ?? 'Terakreditasi A',
                'nomor_akreditasi' => $accreditation->certificate_number ?? 'BAN-SM-2023-001',
                'tahun_akreditasi' => $accreditation->year ?? '2023',
                'skor' => $accreditation->score ?? '95',
                'masa_berlaku' => $accreditation->valid_until ?? '2023-2028'
            ],
            'prestasi' => [
                'akademik' => $achievements->where('type', 'academic')->map(function($achievement) {
                    return [
                        'prestasi' => $achievement->title,
                        'tahun' => $achievement->year,
                        'level' => $achievement->level_label,
                        'position' => $achievement->position,
                        'participant' => $achievement->participant_name
                    ];
                })->toArray(),
                'non_akademik' => $achievements->where('type', 'non_academic')->map(function($achievement) {
                    return [
                        'prestasi' => $achievement->title,
                        'tahun' => $achievement->year,
                        'level' => $achievement->level_label,
                        'position' => $achievement->position,
                        'participant' => $achievement->participant_name
                    ];
                })->toArray()
            ]
        ];

        return view('profil.index', compact('profilData'));
    }

    /**
     * Get Visi Misi images from database
     */
    private function getVisiMisiImages()
    {
        $images = [];
        
        // Get the main school profile (ID 3)
        $mainProfile = SchoolProfile::find(3);
        
        if ($mainProfile) {
            // Add main image
            if ($mainProfile->image) {
                $images[] = [
                    'url' => $mainProfile->image_url,
                    'alt' => $mainProfile->image_alt ?: 'Dokumentasi Visi Misi SMP Negeri 01 Namrole',
                    'title' => 'Profil Sekolah'
                ];
            }
            
            // Add additional images
            if ($mainProfile->image_2) {
                $images[] = [
                    'url' => $mainProfile->image_2_url,
                    'alt' => $mainProfile->image_2_alt ?: 'Visi dan Misi SMP Negeri 01 Namrole',
                    'title' => 'Visi & Misi'
                ];
            }
            
            if ($mainProfile->image_3) {
                $images[] = [
                    'url' => $mainProfile->image_3_url,
                    'alt' => $mainProfile->image_3_alt ?: 'Tujuan Sekolah SMP Negeri 01 Namrole',
                    'title' => 'Tujuan Sekolah'
                ];
            }
            
            if ($mainProfile->image_4) {
                $images[] = [
                    'url' => $mainProfile->image_4_url,
                    'alt' => $mainProfile->image_4_alt ?: 'Dokumentasi Tambahan SMP Negeri 01 Namrole',
                    'title' => 'Dokumentasi Tambahan'
                ];
            }
        }
        
        // If no images in database, use default WhatsApp images
        if (empty($images)) {
            $images = [
                [
                    'url' => asset('visi-misi-1.jpg'),
                    'alt' => 'Dokumentasi Visi Misi SMP Negeri 01 Namrole',
                    'title' => 'Profil Sekolah'
                ],
                [
                    'url' => asset('visi-misi-2.jpg'),
                    'alt' => 'Visi dan Misi SMP Negeri 01 Namrole',
                    'title' => 'Visi & Misi'
                ],
                [
                    'url' => asset('visi-misi-3.jpg'),
                    'alt' => 'Tujuan Sekolah SMP Negeri 01 Namrole',
                    'title' => 'Tujuan Sekolah'
                ]
            ];
        }
        
        return $images;
    }

}
