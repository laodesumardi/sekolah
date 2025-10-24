@extends('layouts.student')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Profil</h1>
            <p class="text-gray-600">Perbarui informasi profil Anda</p>
        </div>

        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Photo Profile Section -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Foto Profil</h2>
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex-shrink-0">
                        @if($user->photo)
                            <img src="{{ $user->photo_url }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border-2 border-primary-200 shadow-sm" id="current-photo-preview" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        @if(!$user->photo)
                            <div class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-4xl font-bold border-2 border-primary-200 shadow-sm" id="current-photo-preview-fallback">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Unggah Foto Baru
                        </label>
                        <input type="file" 
                               id="photo" 
                               name="photo" 
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('photo') border-red-500 @enderror"
                               onchange="previewPhoto(event)">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, SVG (Max 2MB)</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($user->photo)
                            <button type="button" onclick="document.getElementById('delete-photo-form').submit()" class="mt-3 text-red-600 hover:text-red-800 text-sm font-medium">
                                Hapus Foto Profil
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Student Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Siswa</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                            NIP (Nomor Induk Pegawai/Siswa)
                        </label>
                        <input type="text" 
                               id="nip" 
                               name="nip" 
                               value="{{ old('nip', $user->nip) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('nip') border-red-500 @enderror"
                               placeholder="Masukkan NIP">
                        @error('nip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            NIS (Nomor Induk Siswa)
                        </label>
                        <input type="text" 
                               id="student_id" 
                               name="student_id" 
                               value="{{ old('student_id', $user->student_id) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('student_id') border-red-500 @enderror"
                               placeholder="Masukkan NIS">
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('phone') border-red-500 @enderror"
                           placeholder="Masukkan nomor telepon">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('address') border-red-500 @enderror"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Class Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kelas</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="class_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Tingkat Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="class_level" 
                                name="class_level" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('class_level') border-red-500 @enderror"
                                required>
                            <option value="">Pilih tingkat kelas</option>
                            <option value="VII" {{ old('class_level', $user->class_level) == 'VII' ? 'selected' : '' }}>VII (Kelas 7)</option>
                            <option value="VIII" {{ old('class_level', $user->class_level) == 'VIII' ? 'selected' : '' }}>VIII (Kelas 8)</option>
                            <option value="IX" {{ old('class_level', $user->class_level) == 'IX' ? 'selected' : '' }}>IX (Kelas 9)</option>
                        </select>
                        @error('class_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="class_section" class="block text-sm font-medium text-gray-700 mb-2">
                            Rombel
                        </label>
                        <select id="class_section" 
                                name="class_section" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('class_section') border-red-500 @enderror">
                            <option value="">Pilih rombel</option>
                            <option value="A" {{ old('class_section', $user->class_section) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('class_section', $user->class_section) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('class_section', $user->class_section) == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('class_section', $user->class_section) == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        @error('class_section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="student_class" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas Lengkap
                    </label>
                    <input type="text" 
                           id="student_class" 
                           name="student_class" 
                           value="{{ old('student_class', $user->student_class) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('student_class') border-red-500 @enderror"
                           placeholder="Contoh: VII-A, VIII-B, IX-C">
                    <p class="mt-1 text-sm text-gray-500">Format: Tingkat-Rombel (Contoh: VII-A, VIII-B, IX-C)</p>
                    @error('student_class')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Personal Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('date_of_birth') border-red-500 @enderror">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin
                        </label>
                        <select id="gender" 
                                name="gender" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('gender') border-red-500 @enderror">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">
                        Agama
                    </label>
                    <select id="religion" 
                            name="religion" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('religion') border-red-500 @enderror">
                        <option value="">Pilih agama</option>
                        <option value="Islam" {{ old('religion', $user->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('religion', $user->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('religion', $user->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('religion', $user->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion', $user->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion', $user->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('religion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Previous School Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sekolah Sebelumnya</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="previous_school" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Sekolah Sebelumnya
                        </label>
                        <input type="text" 
                               id="previous_school" 
                               name="previous_school" 
                               value="{{ old('previous_school', $user->previous_school) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('previous_school') border-red-500 @enderror"
                               placeholder="Masukkan nama sekolah sebelumnya">
                        @error('previous_school')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun Lulus
                        </label>
                        <input type="number" 
                               id="graduation_year" 
                               name="graduation_year" 
                               value="{{ old('graduation_year', $user->graduation_year) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('graduation_year') border-red-500 @enderror"
                               placeholder="Contoh: 2023"
                               min="2000" max="{{ date('Y') + 1 }}">
                        @error('graduation_year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="previous_school_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Sekolah Sebelumnya
                    </label>
                    <textarea id="previous_school_address" 
                              name="previous_school_address" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('previous_school_address') border-red-500 @enderror"
                              placeholder="Masukkan alamat sekolah sebelumnya">{{ old('previous_school_address', $user->previous_school_address) }}</textarea>
                    @error('previous_school_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="transfer_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Pindah Sekolah
                    </label>
                    <textarea id="transfer_reason" 
                              name="transfer_reason" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('transfer_reason') border-red-500 @enderror"
                              placeholder="Masukkan alasan pindah sekolah">{{ old('transfer_reason', $user->transfer_reason) }}</textarea>
                    @error('transfer_reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Medical Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kesehatan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Golongan Darah
                        </label>
                        <select id="blood_type" 
                                name="blood_type" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('blood_type') border-red-500 @enderror">
                            <option value="">Pilih golongan darah</option>
                            <option value="A" {{ old('blood_type', $user->blood_type) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood_type', $user->blood_type) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('blood_type', $user->blood_type) == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('blood_type', $user->blood_type) == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                        @error('blood_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">
                            Alergi
                        </label>
                        <input type="text" 
                               id="allergies" 
                               name="allergies" 
                               value="{{ old('allergies', $user->allergies) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('allergies') border-red-500 @enderror"
                               placeholder="Masukkan alergi (jika ada)">
                        @error('allergies')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="medical_conditions" class="block text-sm font-medium text-gray-700 mb-2">
                        Kondisi Kesehatan Khusus
                    </label>
                    <textarea id="medical_conditions" 
                              name="medical_conditions" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('medical_conditions') border-red-500 @enderror"
                              placeholder="Masukkan kondisi kesehatan khusus (jika ada)">{{ old('medical_conditions', $user->medical_conditions) }}</textarea>
                    @error('medical_conditions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Parent Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Orang Tua</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Orang Tua/Wali
                        </label>
                        <input type="text" 
                               id="parent_name" 
                               name="parent_name" 
                               value="{{ old('parent_name', $user->parent_name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('parent_name') border-red-500 @enderror"
                               placeholder="Masukkan nama orang tua/wali">
                        @error('parent_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon Orang Tua
                        </label>
                        <input type="tel" 
                               id="parent_phone" 
                               name="parent_phone" 
                               value="{{ old('parent_phone', $user->parent_phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('parent_phone') border-red-500 @enderror"
                               placeholder="Masukkan nomor telepon orang tua">
                        @error('parent_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="parent_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Orang Tua
                    </label>
                    <input type="email" 
                           id="parent_email" 
                           name="parent_email" 
                           value="{{ old('parent_email', $user->parent_email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('parent_email') border-red-500 @enderror"
                           placeholder="Masukkan email orang tua">
                    @error('parent_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="parent_occupation" class="block text-sm font-medium text-gray-700 mb-2">
                        Pekerjaan Orang Tua
                    </label>
                    <input type="text" 
                           id="parent_occupation" 
                           name="parent_occupation" 
                           value="{{ old('parent_occupation', $user->parent_occupation) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('parent_occupation') border-red-500 @enderror"
                           placeholder="Masukkan pekerjaan orang tua">
                    @error('parent_occupation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="parent_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Orang Tua
                    </label>
                    <textarea id="parent_address" 
                              name="parent_address" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('parent_address') border-red-500 @enderror"
                              placeholder="Masukkan alamat orang tua">{{ old('parent_address', $user->parent_address) }}</textarea>
                    @error('parent_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
                <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Saat Ini
                        </label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('current_password') border-red-500 @enderror"
                               placeholder="Masukkan password saat ini">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('password') border-red-500 @enderror"
                               placeholder="Masukkan password baru">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                           placeholder="Konfirmasi password baru">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('student.profile') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Hidden form for photo deletion -->
        <form id="delete-photo-form" action="{{ route('student.profile.photo.delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('current-photo-preview');
            const fallback = document.getElementById('current-photo-preview-fallback');
            if (output) {
                output.src = reader.result;
                output.style.display = 'block';
            }
            if (fallback) {
                fallback.style.display = 'none';
            }
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
