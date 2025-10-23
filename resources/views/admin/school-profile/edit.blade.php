@extends('layouts.admin')

@section('title', 'Edit Profil Sekolah')
@section('page-title', 'Edit Profil Sekolah')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Edit Profil Sekolah</h3>
            <p class="text-sm text-gray-500">Perbarui informasi sekolah</p>
        </div>
        
        <form action="{{ route('admin.school-profile.update', $schoolProfile) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="school_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah *</label>
                        <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $schoolProfile->school_name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('school_name') border-red-500 @enderror" required>
                        @error('school_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="established_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Berdiri *</label>
                        <input type="text" name="established_year" id="established_year" value="{{ old('established_year', $schoolProfile->established_year) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('established_year') border-red-500 @enderror" required>
                        @error('established_year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi *</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $schoolProfile->location) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('location') border-red-500 @enderror" required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Visi & Misi</h4>
                <div class="space-y-4">
                    <div>
                        <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">Visi *</label>
                        <textarea name="vision" id="vision" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('vision') border-red-500 @enderror" required>{{ old('vision', $schoolProfile->vision) }}</textarea>
                        @error('vision')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="mission" class="block text-sm font-medium text-gray-700 mb-2">Misi *</label>
                        <textarea name="mission" id="mission" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('mission') border-red-500 @enderror" required>{{ old('mission', $schoolProfile->mission) }}</textarea>
                        @error('mission')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- History -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Sejarah Sekolah</h4>
                <div>
                    <label for="history" class="block text-sm font-medium text-gray-700 mb-2">Sejarah Singkat *</label>
                    <textarea name="history" id="history" rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('history') border-red-500 @enderror" required>{{ old('history', $schoolProfile->history) }}</textarea>
                    @error('history')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Headmaster Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kepala Sekolah</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="headmaster_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kepala Sekolah *</label>
                        <input type="text" name="headmaster_name" id="headmaster_name" value="{{ old('headmaster_name', $schoolProfile->headmaster_name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('headmaster_name') border-red-500 @enderror" required>
                        @error('headmaster_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="headmaster_position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                        <input type="text" name="headmaster_position" id="headmaster_position" value="{{ old('headmaster_position', $schoolProfile->headmaster_position) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('headmaster_position') border-red-500 @enderror" required>
                        @error('headmaster_position')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="headmaster_education" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan *</label>
                        <input type="text" name="headmaster_education" id="headmaster_education" value="{{ old('headmaster_education', $schoolProfile->headmaster_education) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('headmaster_education') border-red-500 @enderror" required>
                        @error('headmaster_education')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Accreditation Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akreditasi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="accreditation_status" class="block text-sm font-medium text-gray-700 mb-2">Status Akreditasi *</label>
                        <input type="text" name="accreditation_status" id="accreditation_status" value="{{ old('accreditation_status', $schoolProfile->accreditation_status) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('accreditation_status') border-red-500 @enderror" required>
                        @error('accreditation_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="accreditation_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Akreditasi *</label>
                        <input type="text" name="accreditation_number" id="accreditation_number" value="{{ old('accreditation_number', $schoolProfile->accreditation_number) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('accreditation_number') border-red-500 @enderror" required>
                        @error('accreditation_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="accreditation_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Akreditasi *</label>
                        <input type="text" name="accreditation_year" id="accreditation_year" value="{{ old('accreditation_year', $schoolProfile->accreditation_year) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('accreditation_year') border-red-500 @enderror" required>
                        @error('accreditation_year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="accreditation_score" class="block text-sm font-medium text-gray-700 mb-2">Skor Akreditasi *</label>
                        <input type="number" name="accreditation_score" id="accreditation_score" value="{{ old('accreditation_score', $schoolProfile->accreditation_score) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('accreditation_score') border-red-500 @enderror" required>
                        @error('accreditation_score')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="accreditation_valid_until" class="block text-sm font-medium text-gray-700 mb-2">Berlaku Hingga *</label>
                        <input type="text" name="accreditation_valid_until" id="accreditation_valid_until" value="{{ old('accreditation_valid_until', $schoolProfile->accreditation_valid_until) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('accreditation_valid_until') border-red-500 @enderror" required>
                        @error('accreditation_valid_until')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Image Upload Section -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Gambar Sekolah</h4>
                <div class="space-y-6">
                    <!-- Main Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                        @if($schoolProfile->image)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $schoolProfile->image_url }}" alt="{{ $schoolProfile->image_alt }}" class="h-32 w-48 object-cover rounded-lg">
                                <div>
                                    <p class="text-sm text-gray-600">{{ basename($schoolProfile->image) }}</p>
                                    <p class="text-xs text-gray-500">Upload gambar baru untuk mengganti</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Max size: 5MB. Supported formats: JPEG, PNG, JPG, GIF, SVG, WEBP</p>
                    </div>

                    <!-- Image Alt Text -->
                    <div>
                        <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">Alt Text untuk Gambar Utama</label>
                        <input type="text" name="image_alt" id="image_alt" value="{{ old('image_alt', $schoolProfile->image_alt) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_alt') border-red-500 @enderror"
                               placeholder="Deskripsi gambar untuk aksesibilitas">
                        @error('image_alt')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Images for Visi Misi -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h4 class="text-lg font-semibold text-blue-800 mb-4">Gambar Visi & Misi</h4>
                        <p class="text-sm text-blue-600 mb-4">Upload 3 gambar untuk ditampilkan di bagian Visi & Misi pada halaman profil sekolah.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Image 2 -->
                            <div>
                                <label for="image_2" class="block text-sm font-medium text-gray-700 mb-2">Gambar Visi & Misi 1</label>
                                @if($schoolProfile->image_2)
                                <div class="mb-2">
                                    <img src="{{ $schoolProfile->image_2_url }}" alt="{{ $schoolProfile->image_2_alt }}" class="h-24 w-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">{{ basename($schoolProfile->image_2) }}</p>
                                </div>
                                @else
                                <div class="mb-2">
                                    <img src="{{ asset('WhatsApp Image 2025-10-23 at 17.16.29_1bc98572.jpg') }}" alt="Gambar Default 1" class="h-24 w-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">WhatsApp Image 2025-10-23 at 17.16.29_1bc98572.jpg</p>
                                </div>
                                @endif
                                <input type="file" name="image_2" id="image_2" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_2') border-red-500 @enderror">
                                @error('image_2')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text" name="image_2_alt" id="image_2_alt" value="{{ old('image_2_alt', $schoolProfile->image_2_alt ?: 'Dokumentasi Visi Misi SMP Negeri 01 Namrole') }}"
                                       class="w-full px-2 py-1 mt-2 text-sm border border-gray-300 rounded focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Deskripsi gambar">
                            </div>

                            <!-- Image 3 -->
                            <div>
                                <label for="image_3" class="block text-sm font-medium text-gray-700 mb-2">Gambar Visi & Misi 2</label>
                                @if($schoolProfile->image_3)
                                <div class="mb-2">
                                    <img src="{{ $schoolProfile->image_3_url }}" alt="{{ $schoolProfile->image_3_alt }}" class="h-24 w-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">{{ basename($schoolProfile->image_3) }}</p>
                                </div>
                                @else
                                <div class="mb-2">
                                    <img src="{{ asset('WhatsApp Image 2025-10-23 at 17.16.30_9bd4caf6.jpg') }}" alt="Gambar Default 2" class="h-24 w-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">WhatsApp Image 2025-10-23 at 17.16.30_9bd4caf6.jpg</p>
                                </div>
                                @endif
                                <input type="file" name="image_3" id="image_3" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_3') border-red-500 @enderror">
                                @error('image_3')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text" name="image_3_alt" id="image_3_alt" value="{{ old('image_3_alt', $schoolProfile->image_3_alt ?: 'Visi dan Misi SMP Negeri 01 Namrole') }}"
                                       class="w-full px-2 py-1 mt-2 text-sm border border-gray-300 rounded focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Deskripsi gambar">
                            </div>

                            <!-- Image 4 -->
                            <div>
                                <label for="image_4" class="block text-sm font-medium text-gray-700 mb-2">Gambar Visi & Misi 3</label>
                                @if($schoolProfile->image_4)
                                <div class="mb-2">
                                    <img src="{{ $schoolProfile->image_4_url }}" alt="{{ $schoolProfile->image_4_alt }}" class="h-24 w-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">{{ basename($schoolProfile->image_4) }}</p>
                                </div>
                                @else
                                <div class="mb-2">
                                    <img src="{{ asset('WhatsApp Image 2025-10-23 at 17.16.30_a0f5753c.jpg') }}" alt="Gambar Default 3" class="h-24 w-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">WhatsApp Image 2025-10-23 at 17.16.30_a0f5753c.jpg</p>
                                </div>
                                @endif
                                <input type="file" name="image_4" id="image_4" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('image_4') border-red-500 @enderror">
                                @error('image_4')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text" name="image_4_alt" id="image_4_alt" value="{{ old('image_4_alt', $schoolProfile->image_4_alt ?: 'Tujuan Sekolah SMP Negeri 01 Namrole') }}"
                                       class="w-full px-2 py-1 mt-2 text-sm border border-gray-300 rounded focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Deskripsi gambar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.school-profile.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Update Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
