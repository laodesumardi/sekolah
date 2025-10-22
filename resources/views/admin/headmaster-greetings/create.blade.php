@extends('layouts.admin')

@section('title', 'Tambah Sambutan Kepala Sekolah')

@section('content')
<div class="bg-white">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 sm:px-6 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold">Tambah Sambutan Kepala Sekolah</h1>
                    <p class="text-primary-100 mt-2 text-sm sm:text-base">Buat sambutan kepala sekolah baru untuk halaman utama</p>
                </div>
                <a href="{{ route('admin.headmaster-greetings.index') }}" class="bg-white text-primary-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center text-sm sm:text-base">
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
                <h2 class="text-lg font-semibold text-gray-900">Form Tambah Sambutan Kepala Sekolah</h2>
                <p class="text-sm text-gray-600 mt-1">Lengkapi informasi sambutan kepala sekolah yang akan ditampilkan di halaman utama</p>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <form action="{{ route('admin.headmaster-greetings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Name and Photo Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Headmaster Name -->
                        <div>
                            <label for="headmaster_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kepala Sekolah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="headmaster_name" 
                                   name="headmaster_name" 
                                   value="{{ old('headmaster_name') }}" 
                                   placeholder="Masukkan nama lengkap kepala sekolah"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('headmaster_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   required>
                            @error('headmaster_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Photo Upload -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Kepala Sekolah
                            </label>
                            <input type="file" 
                                   id="photo" 
                                   name="photo" 
                                   accept="image/*" 
                                   onchange="previewImage(this)"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('photo') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                        </div>
                    </div>

                    <!-- Greeting Message -->
                    <div>
                        <label for="greeting_message" class="block text-sm font-medium text-gray-700 mb-2">
                            Sambutan Kepala Sekolah <span class="text-red-500">*</span>
                        </label>
                        <textarea id="greeting_message" 
                                  name="greeting_message" 
                                  rows="8" 
                                  placeholder="Tuliskan sambutan kepala sekolah yang akan ditampilkan di halaman utama..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('greeting_message') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                  required>{{ old('greeting_message') }}</textarea>
                        @error('greeting_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                            Tampilkan di halaman utama
                        </label>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview Foto:</label>
                        <div class="flex justify-center">
                            <img id="preview-img" 
                                 src="" 
                                 alt="Preview" 
                                 class="max-w-xs max-h-48 rounded-lg shadow-md object-cover">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.headmaster-greetings.index') }}" 
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
function previewImage(input) {
    const preview = document.getElementById('preview-img');
    const previewContainer = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.classList.add('hidden');
    }
}
</script>
@endsection
