<?php $__env->startSection('title', 'Beranda - SMP Negeri 01 Namrole'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white">
    <!-- Hero Section -->
    <?php if(isset($sections['hero']) && $sections['hero']->is_active): ?>
        <?php
            $heroBgStyle = '';
            $heroClasses = 'py-24 relative overflow-hidden';
            $textColorClass = $sections['hero']->text_color ?? 'text-white';
            $hasImage = false;

            if ($sections['hero']->image) {
                $imageUrl = asset('storage/' . str_replace('public/', '', $sections['hero']->image));
                $heroBgStyle = "background-image: url('{$imageUrl}'); background-size: cover; background-position: center; background-repeat: no-repeat;";
                $hasImage = true;
            } else {
                $heroClasses .= ' ' . ($sections['hero']->background_color ?? 'bg-gradient-to-r from-primary-500 to-primary-600');
            }
        ?>
    <div class="<?php echo e($heroClasses); ?> <?php echo e($textColorClass); ?>" <?php if($hasImage): ?> style="<?php echo e($heroBgStyle); ?>" <?php endif; ?>>
        <?php if($hasImage): ?>
            
            <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
        <?php endif; ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
            <div class="text-center">
                <!-- Logo Sekolah -->
                <div class="mb-8">
                    <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo SMP Negeri 01 Namrole" class="mx-auto h-20 w-auto">
                        </div>
                
                <!-- Content -->
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 leading-tight"><?php echo e($sections['hero']->title ?? 'Selamat Datang di SMP Negeri 01 Namrole'); ?></h1>
                    <p class="text-base sm:text-lg lg:text-xl <?php echo e($sections['hero']->text_color ?? 'text-primary-100'); ?> mb-8 leading-relaxed"><?php echo e($sections['hero']->subtitle ?? 'Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global'); ?></p>
                    
                    <?php if($sections['hero']->button_text): ?>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="<?php echo e($sections['hero']->button_link ?? route('profil')); ?>" class="bg-white text-primary-600 px-10 py-4 rounded-lg font-semibold text-lg hover:bg-primary-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <?php echo e($sections['hero']->button_text); ?>

                        </a>
                        <?php if($sections['hero']->description): ?>
                        <a href="<?php echo e(route('ppdb.index')); ?>" class="border-2 border-white text-white px-10 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                            Informasi Pendaftaran
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
                                </div>
    <?php else: ?>
    <!-- Default Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Logo Sekolah -->
            <div class="mb-8">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo SMP Negeri 01 Namrole" class="mx-auto h-20 w-auto">
                                        </div>

            <div class="max-w-4xl mx-auto">
                <h1 class="text-6xl font-bold mb-6 leading-tight">Selamat Datang di SMP Negeri 01 Namrole</h1>
                <p class="text-2xl text-primary-100 mb-12 leading-relaxed">Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global</p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="<?php echo e(route('profil')); ?>" class="bg-white text-primary-600 px-10 py-4 rounded-lg font-semibold text-lg hover:bg-primary-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Lihat Profil Sekolah
                    </a>
                    <a href="<?php echo e(route('ppdb.index')); ?>" class="border-2 border-white text-white px-10 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                        Informasi Pendaftaran
                    </a>
                </div>
                                        </div>
                                    </div>
                                </div>
    <?php endif; ?>

    <!-- Quick Info Section -->
    <?php if(isset($sections['quick_info']) && $sections['quick_info']->is_active): ?>
    <div class="<?php echo e($sections['quick_info']->background_color ?? 'bg-gray-50'); ?> <?php echo e($sections['quick_info']->text_color ?? 'text-gray-900'); ?> py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4"><?php echo e($sections['quick_info']->title ?? 'Keunggulan Sekolah Kami'); ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php echo e($sections['quick_info']->subtitle ?? 'Mengapa memilih SMP Negeri 01 Namrole?'); ?></p>
                                </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Guru Berkualitas -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        <?php echo e(isset($sections['guru_berkualitas']) && $sections['guru_berkualitas']->is_active ? $sections['guru_berkualitas']->title : 'Guru Berkualitas'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(isset($sections['guru_berkualitas']) && $sections['guru_berkualitas']->is_active ? $sections['guru_berkualitas']->subtitle : 'Tenaga pendidik berpengalaman dan berkompeten'); ?>

                    </p>
                    <?php if(isset($sections['guru_berkualitas']) && $sections['guru_berkualitas']->is_active && $sections['guru_berkualitas']->description): ?>
                    <p class="text-sm text-gray-500 mt-4"><?php echo e($sections['guru_berkualitas']->description); ?></p>
                    <?php endif; ?>
                                </div>

                <!-- Akreditasi A -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                                </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        <?php echo e(isset($sections['akreditasi_a']) && $sections['akreditasi_a']->is_active ? $sections['akreditasi_a']->title : 'Akreditasi A'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(isset($sections['akreditasi_a']) && $sections['akreditasi_a']->is_active ? $sections['akreditasi_a']->subtitle : 'Sekolah terakreditasi A dengan skor 95'); ?>

                    </p>
                    <?php if(isset($sections['akreditasi_a']) && $sections['akreditasi_a']->is_active && $sections['akreditasi_a']->description): ?>
                    <p class="text-sm text-gray-500 mt-4"><?php echo e($sections['akreditasi_a']->description); ?></p>
                    <?php endif; ?>
                                </div>

                <!-- Fasilitas Lengkap -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        <?php echo e(isset($sections['fasilitas_lengkap']) && $sections['fasilitas_lengkap']->is_active ? $sections['fasilitas_lengkap']->title : 'Fasilitas Lengkap'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(isset($sections['fasilitas_lengkap']) && $sections['fasilitas_lengkap']->is_active ? $sections['fasilitas_lengkap']->subtitle : 'Fasilitas pembelajaran yang modern dan memadai'); ?>

                    </p>
                    <?php if(isset($sections['fasilitas_lengkap']) && $sections['fasilitas_lengkap']->is_active && $sections['fasilitas_lengkap']->description): ?>
                    <p class="text-sm text-gray-500 mt-4"><?php echo e($sections['fasilitas_lengkap']->description); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Headmaster Greeting Section -->
    <?php if(isset($headmasterGreeting) && $headmasterGreeting): ?>
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <!-- Photo Section -->
                    <div class="p-8 lg:p-12 flex items-center justify-center bg-gray-50">
                        <div class="text-center">
                            <?php if($headmasterGreeting->photo_url): ?>
                                <img src="<?php echo e($headmasterGreeting->photo_url); ?>" alt="<?php echo e($headmasterGreeting->headmaster_name); ?>" 
                                     class="w-48 h-60 rounded-lg mx-auto mb-6 shadow-lg object-cover">
                            <?php else: ?>
                                <div class="w-48 h-60 rounded-lg mx-auto mb-6 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-5xl text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($headmasterGreeting->headmaster_name); ?></h3>
                            <p class="text-gray-600 text-base">Kepala Sekolah</p>
                        </div>
                    </div>
                    
                    <!-- Greeting Content -->
                    <div class="p-8 lg:p-12 flex items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Sambutan Kepala Sekolah</h2>
                            <div class="text-gray-700 leading-relaxed text-base max-h-80 overflow-y-auto">
                                <?php
                                    $message = $headmasterGreeting->greeting_message;
                                    $maxLength = 500; // Batasi panjang teks
                                    if (strlen($message) > $maxLength) {
                                        $message = substr($message, 0, $maxLength) . '...';
                                    }
                                ?>
                                <?php echo nl2br(e($message)); ?>

                            </div>
                            <div class="mt-6 flex items-center text-primary-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <span class="font-semibold text-sm">SMP Negeri 01 Namrole</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Admin Dashboard Section for Logged In Users -->
    <?php if(auth()->guard()->check()): ?>
    <div class="bg-primary-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary-900 mb-4">Selamat Datang, <?php echo e(Auth::user()->name); ?>!</h2>
                <?php if(auth()->user()->role === 'admin'): ?>
                    <p class="text-lg text-gray-600">Akses dashboard admin untuk mengelola website sekolah</p>
                <?php elseif(auth()->user()->role === 'teacher'): ?>
                    <p class="text-lg text-gray-600">Akses dashboard guru untuk mengelola kelas dan pembelajaran</p>
                <?php elseif(auth()->user()->role === 'student'): ?>
                    <p class="text-lg text-gray-600">Akses dashboard siswa untuk melihat pembelajaran dan tugas</p>
                <?php else: ?>
                    <p class="text-lg text-gray-600">Akses dashboard untuk mengelola akun Anda</p>
                <?php endif; ?>
            </div>

            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-6">
                        <div class="flex justify-center mb-4">
                            <div class="bg-primary-100 rounded-full p-4">
                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                <?php elseif(auth()->user()->role === 'teacher'): ?>
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                <?php elseif(auth()->user()->role === 'student'): ?>
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Admin Dashboard</h3>
                            <p class="text-gray-600">Kelola profil sekolah, guru, dan prestasi</p>
                        <?php elseif(auth()->user()->role === 'teacher'): ?>
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Dashboard Guru</h3>
                            <p class="text-gray-600">Kelola kelas, materi, dan penilaian siswa</p>
                        <?php elseif(auth()->user()->role === 'student'): ?>
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Dashboard Siswa</h3>
                            <p class="text-gray-600">Lihat pembelajaran, tugas, dan nilai</p>
                        <?php else: ?>
                            <h3 class="text-2xl font-bold text-primary-900 mb-2">Dashboard</h3>
                            <p class="text-gray-600">Kelola akun dan informasi Anda</p>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-4">
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Buka Dashboard
                            </a>
                        <?php elseif(auth()->user()->role === 'teacher'): ?>
                            <a href="<?php echo e(route('teacher.dashboard')); ?>" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Buka Dashboard
                            </a>
                        <?php elseif(auth()->user()->role === 'student'): ?>
                            <a href="<?php echo e(route('student.dashboard')); ?>" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                Buka Dashboard
                            </a>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- News Section -->
    <?php if($latestNews->count() > 0): ?>
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <?php if(isset($sections['news']) && $sections['news']->is_active): ?>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?php echo e($sections['news']->title); ?></h2>
                    <?php if($sections['news']->subtitle): ?>
                        <p class="text-lg text-gray-600 mb-4"><?php echo e($sections['news']->subtitle); ?></p>
                    <?php endif; ?>
                    <?php if($sections['news']->content): ?>
                        <p class="text-gray-600"><?php echo e($sections['news']->content); ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Berita & Pengumuman Terbaru</h2>
                    <p class="text-lg text-gray-600">Informasi terkini dari SMP Negeri 01 Namrole</p>
                <?php endif; ?>
            </div>

            <!-- Featured News -->
            <?php if($featuredNews->count() > 0): ?>
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Utama</h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <?php $__currentLoopData = $featuredNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <?php if($news->featured_image): ?>
                        <img src="<?php echo e($news->featured_image_url); ?>" alt="<?php echo e($news->title); ?>" class="w-full h-48 object-cover">
                        <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <?php echo e($news->getCategoryLabel()); ?>

                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($news->type == 'news' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                    <?php echo e($news->getTypeLabel()); ?>

                                </span>
                            </div>
                            
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                                <a href="<?php echo e(route('news.show', $news->slug)); ?>" class="hover:text-primary-600 transition-colors">
                                    <?php echo e($news->title); ?>

                                </a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3"><?php echo e($news->excerpt); ?></p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span><?php echo e($news->published_at->format('d M Y')); ?></span>
                                <span><?php echo e($news->views); ?> views</span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Latest News -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Terbaru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $latestNews->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <?php if($news->featured_image): ?>
                        <img src="<?php echo e($news->featured_image_url); ?>" alt="<?php echo e($news->title); ?>" class="w-full h-32 object-cover">
                        <?php else: ?>
                        <div class="w-full h-32 bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <?php endif; ?>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <?php echo e($news->getCategoryLabel()); ?>

                                </span>
                                <span class="text-xs text-gray-500"><?php echo e($news->published_at->format('d M Y')); ?></span>
                            </div>
                            
                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="<?php echo e(route('news.show', $news->slug)); ?>" class="hover:text-primary-600 transition-colors">
                                    <?php echo e($news->title); ?>

                                </a>
                            </h4>
                            
                            <p class="text-sm text-gray-600 line-clamp-2"><?php echo e($news->excerpt); ?></p>
                        </div>
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- View All News Button -->
            <div class="text-center">
                <a href="<?php echo e(route('news.index')); ?>" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Gallery Section -->
    <?php if($featuredGalleries->count() > 0 || $latestGalleries->count() > 0): ?>
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Galeri Sekolah</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dokumentasi kegiatan dan momen berharga di SMP Negeri 01 Namrole
                </p>
            </div>

            <!-- Featured Galleries -->
            <?php if($featuredGalleries->count() > 0): ?>
            <div class="mb-12">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Galeri Unggulan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $featuredGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                        <div class="relative">
                            <img src="<?php echo e($gallery->cover_image_url); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-600 text-white">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Unggulan
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="<?php echo e(route('gallery.show', $gallery->slug)); ?>" class="hover:text-primary-600 transition-colors">
                                    <?php echo e($gallery->title); ?>

                                </a>
                            </h4>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($gallery->description); ?></p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo e($gallery->getItemCount()); ?> item
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <?php echo e($gallery->category_label); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Latest Galleries -->
            <?php if($latestGalleries->count() > 0): ?>
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Galeri Terbaru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $latestGalleries->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                        <div class="relative">
                            <img src="<?php echo e($gallery->cover_image_url); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="<?php echo e(route('gallery.show', $gallery->slug)); ?>" class="hover:text-primary-600 transition-colors">
                                    <?php echo e($gallery->title); ?>

                                </a>
                            </h4>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($gallery->description); ?></p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo e($gallery->getItemCount()); ?> item
                                </span>
                                <span class="text-xs text-gray-500"><?php echo e($gallery->created_at->format('d M Y')); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- View All Galleries Button -->
            <div class="text-center">
                <a href="<?php echo e(route('gallery.index')); ?>" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Lihat Semua Galeri
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Contact Form Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kirim Pesan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Ada pertanyaan atau ingin berkomunikasi dengan kami? Kirimkan pesan Anda melalui form di bawah ini.
                </p>
            </div>

            <div class="max-w-2xl mx-auto">
                <?php if(session('success')): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Masukkan nama lengkap Anda">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Masukkan email Anda">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon
                        </label>
                        <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Masukkan nomor telepon Anda">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subjek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Masukkan subjek pesan Anda">
                        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Tuliskan pesan Anda di sini..."><?php echo e(old('message')); ?></textarea>
                        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="text-center">
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-semibold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\website-sekolah-namrole21\resources\views/welcome.blade.php ENDPATH**/ ?>