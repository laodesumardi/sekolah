

<?php $__env->startSection('title', 'Galeri Foto & Video - SMP Negeri 01 Namrole'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white">
    <!-- Hero Section with Full Width Image -->
    <?php if($gallerySection && $gallerySection->image): ?>
    <div class="relative h-96 overflow-hidden">
        <img src="<?php echo e($gallerySection->image_url ?? get_correct_asset_url('images/default-gallery.png')); ?>" 
             alt="<?php echo e($gallerySection->image_alt); ?>" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <?php if($gallerySection->title): ?>
                        <?php echo e($gallerySection->title); ?>

                    <?php else: ?>
                        Galeri Foto & Video
                    <?php endif; ?>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-4">
                    <?php if($gallerySection->subtitle): ?>
                        <?php echo e($gallerySection->subtitle); ?>

                    <?php else: ?>
                        Dokumentasi kegiatan dan dinamika sekolah
                    <?php endif; ?>
                </p>
                <?php if($gallerySection->content): ?>
                    <p class="text-lg text-gray-300 max-w-3xl mx-auto"><?php echo e($gallerySection->content); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Fallback Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Galeri Foto & Video</h1>
                <p class="text-xl text-primary-100">Dokumentasi kegiatan dan dinamika sekolah</p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Links -->
    <div class="bg-primary-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Jelajahi Galeri</h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo e(route('gallery.featured')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Galeri Unggulan
                    </a>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('gallery.category', $key)); ?>" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <?php echo e($label); ?>

                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="Cari galeri..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Category Filter -->
                <div>
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(request('category') == $key ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <!-- Type Filter -->
                <div>
                    <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Jenis</option>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(request('type') == $key ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Galleries Grid -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if($galleries->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Gallery Cover -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo e($gallery->cover_image_url); ?>" 
                                 alt="<?php echo e($gallery->title); ?>" 
                                 class="w-full h-full object-cover">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <div class="text-center text-white">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <p class="text-sm font-medium">Lihat Galeri</p>
                                </div>
                            </div>

                            <!-- Type Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?php echo e($gallery->type == 'photo' ? 'bg-blue-100 text-blue-800' : 
                                       ($gallery->type == 'video' ? 'bg-red-100 text-red-800' : 'bg-purple-100 text-purple-800')); ?>">
                                    <?php echo e($gallery->type_label); ?>

                                </span>
                            </div>

                            <!-- Featured Badge -->
                            <?php if($gallery->is_featured): ?>
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Unggulan
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Gallery Info -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($gallery->title); ?></h3>
                            
                            <?php if($gallery->description): ?>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e($gallery->description); ?></p>
                            <?php endif; ?>

                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2H8z"></path>
                                    </svg>
                                    <?php echo e($gallery->category_label); ?>

                                </span>
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo e($gallery->getItemCount()); ?> item
                                </span>
                            </div>

                            <a href="<?php echo e(route('gallery.show', $gallery->slug)); ?>" 
                               class="block w-full bg-primary-600 text-white text-center py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors">
                                Lihat Galeri
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <?php echo e($galleries->links()); ?>

                </div>
            <?php else: ?>
                <!-- No Galleries Found -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada galeri</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada galeri yang sesuai dengan filter yang dipilih.</p>
                </div>
            <?php endif; ?>
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
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\website-sekolah-namrole21\resources\views/gallery/index.blade.php ENDPATH**/ ?>