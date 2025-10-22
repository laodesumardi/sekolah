@extends('layouts.admin')

@section('title', 'Tambah Sosial Media')

@section('content')
<div class="bg-white">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 sm:px-6 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold">Tambah Sosial Media</h1>
                    <p class="text-primary-100 mt-2 text-sm sm:text-base">Tambahkan platform sosial media baru untuk ditampilkan di footer website</p>
                </div>
                <a href="{{ route('admin.social-media.index') }}" class="bg-white text-primary-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Form Tambah Sosial Media</h2>
                <p class="text-sm text-gray-600 mt-1">Lengkapi informasi platform sosial media yang akan ditampilkan di footer website</p>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <form action="{{ route('admin.social-media.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name and URL Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Social Media Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Platform <span class="text-red-500">*</span>
                            </label>
                            <select id="name" 
                                    name="name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Platform</option>
                                <option value="facebook" {{ old('name') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                <option value="instagram" {{ old('name') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                <option value="youtube" {{ old('name') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="twitter" {{ old('name') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                <option value="tiktok" {{ old('name') === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                <option value="whatsapp" {{ old('name') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="linkedin" {{ old('name') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                            </select>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- URL -->
                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700 mb-2">
                                URL Link <span class="text-red-500">*</span>
                            </label>
                            <input type="url" 
                                   id="url" 
                                   name="url" 
                                   value="{{ old('url') }}" 
                                   placeholder="https://example.com"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('url') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   required>
                            @error('url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Color and Sort Order Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                Warna Brand <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="color" 
                                       id="color" 
                                       name="color" 
                                       value="{{ old('color', '#3B82F6') }}"
                                       class="h-10 w-16 border border-gray-300 rounded-lg cursor-pointer @error('color') border-red-300 @enderror">
                                <input type="text" 
                                       id="color_text" 
                                       value="{{ old('color', '#3B82F6') }}"
                                       placeholder="#3B82F6"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('color') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            </div>
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Pilih warna yang sesuai dengan brand platform</p>
                        </div>
                        
                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Urutan Tampil <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 1) }}" 
                                   min="0"
                                   placeholder="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sort_order') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Angka lebih kecil akan ditampilkan lebih dulu</p>
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Tampilkan di footer website
                        </label>
                    </div>

                    <!-- Preview -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">Preview</h3>
                        <div class="flex items-center space-x-3">
                            <div id="preview-icon" class="h-10 w-10 rounded-full flex items-center justify-center text-white" style="background-color: #3B82F6;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div>
                                <p id="preview-name" class="text-sm font-medium text-gray-900">Pilih platform</p>
                                <p id="preview-url" class="text-xs text-gray-500">URL akan muncul di sini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.social-media.index') }}" 
                           class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Color picker synchronization
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
    updatePreview();
});

document.getElementById('color_text').addEventListener('input', function() {
    document.getElementById('color').value = this.value;
    updatePreview();
});

// Name change handler
document.getElementById('name').addEventListener('change', function() {
    updatePreview();
});

// URL change handler
document.getElementById('url').addEventListener('input', function() {
    updatePreview();
});

function updatePreview() {
    const name = document.getElementById('name').value;
    const url = document.getElementById('url').value;
    const color = document.getElementById('color').value;
    
    // Update preview icon background
    const previewIcon = document.getElementById('preview-icon');
    previewIcon.style.backgroundColor = color;
    
    // Update preview text
    document.getElementById('preview-name').textContent = name || 'Pilih platform';
    document.getElementById('preview-url').textContent = url || 'URL akan muncul di sini';
    
    // Update icon based on platform
    if (name) {
        const iconMap = {
            'facebook': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'instagram': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.348-1.051-2.348-2.348s1.051-2.348 2.348-2.348 2.348 1.051 2.348 2.348-1.051 2.348-2.348 2.348zm7.718 0c-1.297 0-2.348-1.051-2.348-2.348s1.051-2.348 2.348-2.348 2.348 1.051 2.348 2.348-1.051 2.348-2.348 2.348z"/></svg>',
            'youtube': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
            'twitter': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
            'tiktok': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.58.41 3.16 1.05 4.66.64 1.48 1.55 2.79 2.73 3.87 1.18 1.08 2.57 1.93 4.08 2.5v3.5c-1.5-.57-2.9-1.42-4.08-2.5-1.18-1.08-2.09-2.39-2.73-3.87-.64-1.5-.97-3.08-1.05-4.66-1.3.01-2.6-.01-3.91.02zM12.525 6.02v6.5c-1.5-.57-2.9-1.42-4.08-2.5-1.18-1.08-2.09-2.39-2.73-3.87-.64-1.5-.97-3.08-1.05-4.66-1.3.01-2.6-.01-3.91.02v-6.5c1.5.57 2.9 1.42 4.08 2.5 1.18 1.08 2.09 2.39 2.73 3.87.64 1.5.97 3.08 1.05 4.66 1.3-.01 2.6.01 3.91-.02z"/></svg>',
            'whatsapp': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>',
            'linkedin': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>'
        };
        
        previewIcon.innerHTML = iconMap[name] || '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>';
    }
}

// Initialize preview
updatePreview();
</script>
@endsection
