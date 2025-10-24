@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Tambah User</h1>
                        <p class="text-sm text-gray-500">Tambah user baru (Admin, Guru, atau Siswa)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.user-management.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.user-management.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informasi Dasar</h2>
                <p class="text-sm text-gray-500 mt-1">Informasi dasar user yang akan ditambahkan</p>
            </div>
            
            <div class="px-6 py-4 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Konfirmasi password">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Guru</option>
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Siswa</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                            NIP/NIS
                        </label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nip') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan NIP atau NIS">
                        @error('nip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                No. Telepon
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Masukkan nomor telepon">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin
                            </label>
                            <select id="gender" name="gender"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">
                                Agama
                            </label>
                            <input type="text" id="religion" name="religion" value="{{ old('religion') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('religion') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Masukkan agama">
                            @error('religion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea id="address" name="address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Teacher Specific Fields -->
                <div id="teacher-fields" class="border-t border-gray-200 pt-6" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Guru</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Mata Pelajaran
                            </label>
                            <select id="subject" name="subject"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="">Pilih Mata Pelajaran</option>
                                <option value="Matematika" {{ old('subject') === 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                <option value="Bahasa Indonesia" {{ old('subject') === 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                <option value="Bahasa Inggris" {{ old('subject') === 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                <option value="IPA" {{ old('subject') === 'IPA' ? 'selected' : '' }}>IPA</option>
                                <option value="IPS" {{ old('subject') === 'IPS' ? 'selected' : '' }}>IPS</option>
                                <option value="Pendidikan Agama" {{ old('subject') === 'Pendidikan Agama' ? 'selected' : '' }}>Pendidikan Agama</option>
                                <option value="PJOK" {{ old('subject') === 'PJOK' ? 'selected' : '' }}>PJOK</option>
                                <option value="Seni Budaya" {{ old('subject') === 'Seni Budaya' ? 'selected' : '' }}>Seni Budaya</option>
                                <option value="Prakarya" {{ old('subject') === 'Prakarya' ? 'selected' : '' }}>Prakarya</option>
                            </select>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">
                                Tingkat Pendidikan
                            </label>
                            <select id="education_level" name="education_level"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('education_level') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="">Pilih Tingkat Pendidikan</option>
                                <option value="SD" {{ old('education_level') === 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('education_level') === 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('education_level') === 'SMA' ? 'selected' : '' }}>SMA</option>
                            </select>
                            @error('education_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="education" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendidikan Terakhir
                            </label>
                            <input type="text" id="education" name="education" value="{{ old('education') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('education') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Contoh: S1 Matematika">
                            @error('education')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Guru
                            </label>
                            <select id="type" name="type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="">Pilih Jenis Guru</option>
                                <option value="Guru Kelas" {{ old('type') === 'Guru Kelas' ? 'selected' : '' }}>Guru Kelas</option>
                                <option value="Guru Mata Pelajaran" {{ old('type') === 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                                <option value="Guru BK" {{ old('type') === 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                                <option value="Guru Agama" {{ old('type') === 'Guru Agama' ? 'selected' : '' }}>Guru Agama</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="classes" class="block text-sm font-medium text-gray-700 mb-2">
                            Kelas yang Diampu
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="1" {{ in_array('1', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 1</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="2" {{ in_array('2', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 2</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="3" {{ in_array('3', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 3</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="4" {{ in_array('4', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 4</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="5" {{ in_array('5', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 5</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="6" {{ in_array('6', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 6</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="7" {{ in_array('7', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 7</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="8" {{ in_array('8', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 8</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="classes[]" value="9" {{ in_array('9', old('classes', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Kelas 9</span>
                            </label>
                        </div>
                        @error('classes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Student Specific Fields -->
                <div id="student-fields" class="border-t border-gray-200 pt-6" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Siswa</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="student_class" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelas
                            </label>
                            <select id="student_class" name="student_class"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('student_class') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="">Pilih Kelas</option>
                                <option value="1" {{ old('student_class') === '1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="2" {{ old('student_class') === '2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="3" {{ old('student_class') === '3' ? 'selected' : '' }}>Kelas 3</option>
                                <option value="4" {{ old('student_class') === '4' ? 'selected' : '' }}>Kelas 4</option>
                                <option value="5" {{ old('student_class') === '5' ? 'selected' : '' }}>Kelas 5</option>
                                <option value="6" {{ old('student_class') === '6' ? 'selected' : '' }}>Kelas 6</option>
                                <option value="7" {{ old('student_class') === '7' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="8" {{ old('student_class') === '8' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="9" {{ old('student_class') === '9' ? 'selected' : '' }}>Kelas 9</option>
                            </select>
                            @error('student_class')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Orang Tua
                            </label>
                            <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parent_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Masukkan nama orang tua">
                            @error('parent_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                No. Telepon Orang Tua
                            </label>
                            <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parent_phone') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Masukkan nomor telepon orang tua">
                            @error('parent_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_occupation" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Orang Tua
                            </label>
                            <input type="text" id="parent_occupation" name="parent_occupation" value="{{ old('parent_occupation') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parent_occupation') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Masukkan pekerjaan orang tua">
                            @error('parent_occupation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="parent_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Orang Tua
                        </label>
                        <textarea id="parent_address" name="parent_address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parent_address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                  placeholder="Masukkan alamat orang tua">{{ old('parent_address') }}</textarea>
                        @error('parent_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            User aktif
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">User yang tidak aktif tidak dapat login ke sistem</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('admin.user-management.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const teacherFields = document.getElementById('teacher-fields');
    const studentFields = document.getElementById('student-fields');
    
    function toggleFields() {
        const selectedRole = roleSelect.value;
        
        // Hide all specific fields first
        teacherFields.style.display = 'none';
        studentFields.style.display = 'none';
        
        // Show relevant fields based on role
        if (selectedRole === 'teacher') {
            teacherFields.style.display = 'block';
        } else if (selectedRole === 'student') {
            studentFields.style.display = 'block';
        }
    }
    
    // Add event listener to role select
    roleSelect.addEventListener('change', toggleFields);
    
    // Initialize on page load
    toggleFields();
});
</script>
@endsection
