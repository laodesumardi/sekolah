@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Edit Section Kalender Akademik')
@section('page-title', 'Edit Section Kalender Akademik')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-900">Edit Section Kalender Akademik</h2>
                        <p class="text-gray-600 mt-1">Edit konten section yang ditampilkan di halaman kalender akademik</p>
                    </div>
                    <a href="{{ route('admin.academic-calendar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.academic-calendar.update-section') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left: Form Fields -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subtitle -->
                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                                    Subjudul
                                </label>
                                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $section->subtitle) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('subtitle') border-red-500 @enderror">
                                @error('subtitle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea name="description" id="description" rows="6"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                          placeholder="Masukkan deskripsi section">{{ old('description', $section->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Active -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
                            </div>
                        </div>

                        <!-- Right: Live Preview & Info -->
                        <div class="space-y-6">
                            <!-- Live Preview -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-blue-900 mb-3">Pratinjau Section</h3>
                                <div class="space-y-2">
                                    <h4 class="text-blue-900 font-bold" id="preview-title">{{ $section->title }}</h4>
                                    <p class="text-blue-700" id="preview-subtitle">{{ $section->subtitle }}</p>
                                    <p class="text-gray-700 text-sm" id="preview-description">{{ $section->description }}</p>
                                </div>
                            </div>


                            <!-- Section Info -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-blue-900 mb-3">Informasi Section</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Section Key:</span>
                                        <span class="text-blue-900 font-medium">academic-calendar</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Status:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Sort Order:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->sort_order }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Dibuat:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Diperbarui:</span>
                                        <span class="text-blue-900 font-medium">{{ $section->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('admin.academic-calendar.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md text-sm font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Real-time preview update
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('preview-title').textContent = this.value;
});

document.getElementById('subtitle').addEventListener('input', function() {
    document.getElementById('preview-subtitle').textContent = this.value;
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview-description').textContent = this.value;
});

// Tidak ada pratinjau gambar di halaman edit
</script>
@endsection
