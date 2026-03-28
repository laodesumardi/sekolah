@extends('layouts.admin')

@section('title', 'Edit Visi & Misi - Upload Gambar')
@section('page-title', 'Edit Visi & Misi - Upload Gambar')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Edit Visi & Misi - Upload Gambar</h3>
            <p class="text-sm text-gray-500">Upload gambar untuk bagian Visi & Misi</p>
        </div>
        
        <form action="{{ route('admin.school-profile.update', $schoolProfile) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Content Display -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-md font-semibold text-gray-900 mb-2">Konten Saat Ini:</h4>
                <div class="text-sm text-gray-700">
                    <strong>Judul:</strong> {{ $schoolProfile->title }}<br>
                    <strong>Konten:</strong> {{ Str::limit($schoolProfile->content, 200) }}
                </div>
            </div>
            
            <!-- Image Upload Section -->
            <div class="space-y-6">
                <h4 class="text-lg font-semibold text-gray-900">Upload Gambar Visi & Misi</h4>
                
                <!-- Current Image Display -->
                @if($schoolProfile->image)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini:</h5>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $schoolProfile->image_url }}" alt="{{ $schoolProfile->image_alt }}" 
                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        <div class="text-sm text-gray-600">
                            <p><strong>File:</strong> {{ basename($schoolProfile->image) }}</p>
                            <p><strong>Alt Text:</strong> {{ $schoolProfile->image_alt ?: 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- New Image Upload -->
                <div class="space-y-4">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Gambar Baru
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPEG, PNG, JPG, GIF, SVG, WEBP. Maksimal 5MB.</p>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">
                            Alt Text untuk Gambar
                        </label>
                        <input type="text" name="image_alt" id="image_alt" 
                               value="{{ old('image_alt', $schoolProfile->image_alt) }}"
                               placeholder="Deskripsi gambar untuk aksesibilitas"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror">
                        @error('image_alt')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Image Preview -->
                <div id="image-preview" class="hidden">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</h5>
                    <img id="preview-img" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            </div>
            
            <!-- Hidden fields to preserve existing content -->
            <input type="hidden" name="title" value="{{ $schoolProfile->title }}">
            <input type="hidden" name="content" value="{{ $schoolProfile->content }}">
            <input type="hidden" name="subtitle" value="{{ $schoolProfile->subtitle }}">
            <input type="hidden" name="description" value="{{ $schoolProfile->description }}">
            <input type="hidden" name="is_active" value="{{ $schoolProfile->is_active ? 1 : 0 }}">
            <input type="hidden" name="sort_order" value="{{ $schoolProfile->sort_order }}">
            
            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.school-profile.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Batal
                </a>
                
                <button type="submit" 
                        class="px-6 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Simpan Gambar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('image-preview').classList.add('hidden');
    }
});
</script>
@endsection
