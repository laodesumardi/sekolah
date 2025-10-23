<?php
use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('title', 'Profil Sekolah - SMP Negeri 01 Namrole'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white">
    <!-- Hero Section -->
    <div class="text-white relative flex items-center justify-center" 
         <?php if(isset($profilData['hero_background']) && $profilData['hero_background']): ?>
         style="background-image: url('<?php echo e(Storage::url($profilData['hero_background'])); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 500px;"
         <?php else: ?>
         style="background: linear-gradient(135deg, #14213d 0%, #1e3a8a 100%); min-height: 500px;"
         <?php endif; ?>>
        <!-- Overlay untuk kontras teks -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        
        <!-- Konten di tengah -->
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 text-white leading-tight">
                    <?php echo e($profilData['hero_title'] ?? 'Profil Sekolah'); ?>

                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    <?php echo e($profilData['hero_subtitle'] ?? 'SMP Negeri 01 Namrole - Sekolah Unggul Berkarakter'); ?>

                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <button onclick="showSection('sejarah')" class="tab-button active py-4 px-1 border-b-2 border-primary-500 text-primary-600 font-medium text-sm whitespace-nowrap">
                    Sejarah
                </button>
                <button onclick="showSection('struktur')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm whitespace-nowrap">
                    Struktur Organisasi
                </button>
                <button onclick="showSection('visi-misi')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm whitespace-nowrap">
                    Visi & Misi
                </button>
                <button onclick="showSection('akreditasi')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm whitespace-nowrap">
                    Akreditasi & Prestasi
                </button>
            </nav>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Sejarah Section -->
        <div id="sejarah" class="content-section">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900"><?php echo e($profilData['sejarah']['judul']); ?></h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <p class="text-gray-700 leading-relaxed text-lg mb-6"><?php echo e($profilData['sejarah']['konten']); ?></p>
                        
                        <div class="bg-primary-50 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-primary-800 mb-4">Informasi Sekolah</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Tahun Berdiri:</strong> <?php echo e($profilData['sejarah']['tahun_berdiri']); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Lokasi:</strong> <?php echo e($profilData['sejarah']['lokasi']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg p-6 text-white">
                            <h3 class="text-xl font-semibold mb-4">Fakta Menarik</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Sekolah Berakreditasi A</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Fasilitas Lengkap</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Guru Berpengalaman</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Struktur Organisasi Section -->
        <div id="struktur" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900"><?php echo e($profilData['struktur_organisasi']['judul']); ?></h2>
                </div>

                <!-- Struktur Organisasi Image -->
                <div class="text-center">
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <img src="<?php echo e(asset($profilData['struktur_organisasi']['gambar'])); ?>" 
                             alt="<?php echo e($profilData['struktur_organisasi']['judul']); ?>" 
                             class="max-w-full h-auto mx-auto rounded-lg shadow-lg"
                             onerror="this.src='<?php echo e(asset('images/default-struktur.png')); ?>'">
                    </div>
                    <p class="text-gray-600 text-lg"><?php echo e($profilData['struktur_organisasi']['deskripsi']); ?></p>
                </div>
            </div>
        </div>

        <!-- Visi & Misi Section -->
        <div id="visi-misi" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Visi & Misi</h2>
                </div>

                <!-- Gambar Visi Misi -->
                <?php if(isset($profilData['visi_misi']['gambar']) && count($profilData['visi_misi']['gambar']) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $profilData['visi_misi']['gambar']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $gambar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 cursor-pointer" 
                         onclick="openImageModal('<?php echo e($gambar['url']); ?>', '<?php echo e($gambar['alt'] ?: 'Dokumentasi Visi Misi ' . ($index + 1)); ?>', '<?php echo e($gambar['title'] ?: 'Dokumentasi Visi Misi ' . ($index + 1)); ?>')">
                        <div class="aspect-w-16 aspect-h-12">
                            <img src="<?php echo e($gambar['url']); ?>" 
                                 alt="<?php echo e($gambar['alt'] ?: 'Dokumentasi Visi Misi ' . ($index + 1)); ?>" 
                                 class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='<?php echo e(asset('images/default-school-image.png')); ?>'">
                        </div>
                        <div class="p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($gambar['title'] ?: 'Dokumentasi Visi Misi ' . ($index + 1)); ?></h4>
                            <?php if($gambar['alt']): ?>
                            <p class="text-sm text-gray-600"><?php echo e($gambar['alt']); ?></p>
                            <?php endif; ?>
                            <div class="mt-2 flex items-center text-blue-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                                Klik untuk memperbesar
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada gambar</h3>
                    <p class="mt-1 text-sm text-gray-500">Gambar Visi & Misi akan ditampilkan di sini.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Akreditasi & Prestasi Section -->
        <div id="akreditasi" class="content-section hidden">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-primary-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Akreditasi & Prestasi</h2>
                </div>

                <!-- Akreditasi -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Akreditasi Sekolah</h3>
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-2xl font-bold"><?php echo e($profilData['akreditasi']['status']); ?></h4>
                                <p class="text-green-100">Nomor: <?php echo e($profilData['akreditasi']['nomor_akreditasi']); ?></p>
                                <p class="text-green-100">Tahun: <?php echo e($profilData['akreditasi']['tahun_akreditasi']); ?></p>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-bold"><?php echo e($profilData['akreditasi']['skor']); ?></div>
                                <div class="text-green-100">Skor Akreditasi</div>
                                <div class="text-sm text-green-200">Berlaku: <?php echo e($profilData['akreditasi']['masa_berlaku']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prestasi -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Prestasi Akademik -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Prestasi Akademik
                        </h3>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $profilData['prestasi']['akademik']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1"><?php echo e($prestasi['prestasi']); ?></h4>
                                        <?php if($prestasi['participant']): ?>
                                        <p class="text-sm text-gray-600 mb-2"><?php echo e($prestasi['participant']); ?></p>
                                        <?php endif; ?>
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <?php echo e($prestasi['level']); ?>

                                            </span>
                                            <span class="text-sm text-gray-600">Tahun <?php echo e($prestasi['tahun']); ?></span>
                                            <?php if($prestasi['position']): ?>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($prestasi['position']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="bg-blue-500 text-white rounded-full p-2 ml-4">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <p class="mt-2">Belum ada prestasi akademik</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Prestasi Non-Akademik -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Prestasi Non-Akademik
                        </h3>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $profilData['prestasi']['non_akademik']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1"><?php echo e($prestasi['prestasi']); ?></h4>
                                        <?php if($prestasi['participant']): ?>
                                        <p class="text-sm text-gray-600 mb-2"><?php echo e($prestasi['participant']); ?></p>
                                        <?php endif; ?>
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <?php echo e($prestasi['level']); ?>

                                            </span>
                                            <span class="text-sm text-gray-600">Tahun <?php echo e($prestasi['tahun']); ?></span>
                                            <?php if($prestasi['position']): ?>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($prestasi['position']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="bg-green-500 text-white rounded-full p-2 ml-4">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <p class="mt-2">Belum ada prestasi non-akademik</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript for Tab Navigation -->
<script>
function showSection(sectionId) {
    // Hide all content sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.add('hidden');
    });

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.tab-button');
    tabs.forEach(tab => {
        tab.classList.remove('active', 'border-primary-500', 'text-primary-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected section
    document.getElementById(sectionId).classList.remove('hidden');

    // Add active class to clicked tab
    event.target.classList.add('active', 'border-primary-500', 'text-primary-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}

// Handle URL anchors on page load
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash.substring(1); // Remove the # symbol
    if (hash) {
        // Find the corresponding tab button
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => {
            if (button.getAttribute('onclick') && button.getAttribute('onclick').includes(hash)) {
                // Simulate click on the tab button
                button.click();
            }
        });
    }
});
</script>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full w-full h-full flex items-center justify-center">
        <!-- Close button -->
        <button onclick="closeImageModal()" class="absolute top-4 right-4 z-10 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full p-2 transition-all duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Image container -->
        <div class="relative w-full h-full flex items-center justify-center">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        </div>
        
        <!-- Image info -->
        <div id="modalImageInfo" class="absolute bottom-4 left-4 right-4 bg-black bg-opacity-50 text-white p-4 rounded-lg">
            <h3 id="modalImageTitle" class="text-lg font-semibold mb-2"></h3>
            <p id="modalImageAlt" class="text-sm opacity-90"></p>
        </div>
    </div>
</div>

<script>
// Image modal functions
function openImageModal(imageUrl, imageAlt, imageTitle) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalImageTitle = document.getElementById('modalImageTitle');
    const modalImageAlt = document.getElementById('modalImageAlt');
    
    modalImage.src = imageUrl;
    modalImage.alt = imageAlt;
    modalImageTitle.textContent = imageTitle;
    modalImageAlt.textContent = imageAlt;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\website-sekolah-namrole21\resources\views/profil/index.blade.php ENDPATH**/ ?>