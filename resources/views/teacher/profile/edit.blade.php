@extends('layouts.teacher')

@section('title', 'Edit Profil Guru')
@section('page-title', 'Edit Profil')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Profil Guru</h1>
            <p class="text-gray-600">Perbarui informasi profil Anda</p>
        </div>

        <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Photo Profile Section -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Foto Profil</h2>
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex-shrink-0">
                        @if($teacher->photo)
                            <img src="{{ $teacher->photo_url }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border-2 border-primary-200 shadow-sm" id="current-photo-preview" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        @if(!$teacher->photo)
                            <div class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-4xl font-bold border-2 border-primary-200 shadow-sm" id="current-photo-preview-fallback">
                                {{ substr($teacher->name, 0, 1) }}
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
                        @if($teacher->photo)
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
                           value="{{ old('name', $teacher->name) }}"
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
                           value="{{ old('email', $teacher->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Teacher Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Guru</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                            NIP (Nomor Induk Pegawai)
                        </label>
                        <input type="text" 
                               id="nip" 
                               name="nip" 
                               value="{{ old('nip', $teacher->nip) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('nip') border-red-500 @enderror"
                               placeholder="Masukkan NIP">
                        @error('nip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $teacher->phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('phone') border-red-500 @enderror"
                               placeholder="Masukkan nomor telepon">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('address') border-red-500 @enderror"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $teacher->address) }}</textarea>
                    @error('address')
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
                               value="{{ old('date_of_birth', $teacher->date_of_birth ? $teacher->date_of_birth->format('Y-m-d') : '') }}"
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
                            <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
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
                        <option value="Islam" {{ old('religion', $teacher->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('religion', $teacher->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('religion', $teacher->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('religion', $teacher->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion', $teacher->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion', $teacher->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('religion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Professional Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Profesional</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Mata Pelajaran
                        </label>
                        <select id="subject" 
                                name="subject" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('subject') border-red-500 @enderror">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach(\App\Models\Subject::active()->ordered()->get() as $subjectOption)
                                <option value="{{ $subjectOption->name }}" {{ old('subject', $teacher->subject) == $subjectOption->name ? 'selected' : '' }}>
                                    {{ $subjectOption->name }} ({{ $subjectOption->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                            Jabatan
                        </label>
                        <select id="position" 
                                name="position" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('position') border-red-500 @enderror">
                            <option value="">Pilih Jabatan</option>
                            <option value="Guru" {{ old('position', $teacher->position) == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Wali Kelas" {{ old('position', $teacher->position) == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="Kepala Sekolah" {{ old('position', $teacher->position) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="Wakil Kepala Sekolah" {{ old('position', $teacher->position) == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                            <option value="Kepala TU" {{ old('position', $teacher->position) == 'Kepala TU' ? 'selected' : '' }}>Kepala TU</option>
                            <option value="Staff TU" {{ old('position', $teacher->position) == 'Staff TU' ? 'selected' : '' }}>Staff TU</option>
                            <option value="Guru BK" {{ old('position', $teacher->position) == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                            <option value="Guru Piket" {{ old('position', $teacher->position) == 'Guru Piket' ? 'selected' : '' }}>Guru Piket</option>
                        </select>
                        @error('position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="classes" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas yang Diampu
                    </label>
                    <select id="classes" 
                            name="classes[]" 
                            multiple
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('classes') border-red-500 @enderror">
                        <option value="VII A" {{ in_array('VII A', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VII A</option>
                        <option value="VII B" {{ in_array('VII B', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VII B</option>
                        <option value="VII C" {{ in_array('VII C', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VII C</option>
                        <option value="VIII A" {{ in_array('VIII A', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VIII A</option>
                        <option value="VIII B" {{ in_array('VIII B', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VIII B</option>
                        <option value="VIII C" {{ in_array('VIII C', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>VIII C</option>
                        <option value="IX A" {{ in_array('IX A', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>IX A</option>
                        <option value="IX B" {{ in_array('IX B', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>IX B</option>
                        <option value="IX C" {{ in_array('IX C', old('classes', $teacher->classes ?? [])) ? 'selected' : '' }}>IX C</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Tekan Ctrl/Cmd untuk memilih multiple kelas</p>
                    @error('classes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Education Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendidikan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="education" class="block text-sm font-medium text-gray-700 mb-2">
                            Pendidikan Terakhir
                        </label>
                        <select id="education" 
                                name="education" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('education') border-red-500 @enderror">
                            <option value="">Pilih Pendidikan</option>
                            <option value="S1" {{ old('education', $teacher->education) == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                            <option value="S2" {{ old('education', $teacher->education) == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                            <option value="S3" {{ old('education', $teacher->education) == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                            <option value="D3" {{ old('education', $teacher->education) == 'D3' ? 'selected' : '' }}>D3 (Diploma)</option>
                            <option value="D4" {{ old('education', $teacher->education) == 'D4' ? 'selected' : '' }}>D4 (Diploma)</option>
                            <option value="SMA" {{ old('education', $teacher->education) == 'SMA' ? 'selected' : '' }}>SMA</option>
                        </select>
                        @error('education')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Jurusan/Program Studi
                        </label>
                        <input type="text" 
                               id="education_level" 
                               name="education_level" 
                               value="{{ old('education_level', $teacher->education_level) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('education_level') border-red-500 @enderror"
                               placeholder="e.g., Pendidikan Matematika, Teknik Informatika">
                        @error('education_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kepegawaian</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Kepegawaian
                        </label>
                        <select id="employment_status" 
                                name="employment_status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('employment_status') border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="PNS" {{ old('employment_status', $teacher->employment_status) == 'PNS' ? 'selected' : '' }}>PNS (Pegawai Negeri Sipil)</option>
                            <option value="CPNS" {{ old('employment_status', $teacher->employment_status) == 'CPNS' ? 'selected' : '' }}>CPNS (Calon Pegawai Negeri Sipil)</option>
                            <option value="Guru Honorer" {{ old('employment_status', $teacher->employment_status) == 'Guru Honorer' ? 'selected' : '' }}>Guru Honorer</option>
                            <option value="Guru Kontrak" {{ old('employment_status', $teacher->employment_status) == 'Guru Kontrak' ? 'selected' : '' }}>Guru Kontrak</option>
                            <option value="Guru Bantu" {{ old('employment_status', $teacher->employment_status) == 'Guru Bantu' ? 'selected' : '' }}>Guru Bantu</option>
                        </select>
                        @error('employment_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="join_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Bergabung
                        </label>
                        <input type="date" 
                               id="join_date" 
                               name="join_date" 
                               value="{{ old('join_date', $teacher->join_date) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('join_date') border-red-500 @enderror">
                        @error('join_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis
                    </label>
                    <select id="type" 
                            name="type" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('type') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="teacher" {{ old('type', $teacher->type) == 'teacher' ? 'selected' : '' }}>Guru</option>
                        <option value="staff" {{ old('type', $teacher->type) == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Guru Aktif
                        </label>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
                
                <div class="mt-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Biografi
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('bio') border-red-500 @enderror"
                              placeholder="Masukkan biografi singkat">{{ old('bio', $teacher->bio) }}</textarea>
                    @error('bio')
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
                <a href="{{ route('teacher.profile') }}" 
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
        <form id="delete-photo-form" action="{{ route('teacher.profile.photo.delete') }}" method="POST" style="display: none;">
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

    // Password confirmation validation
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Password confirmation does not match');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }
        
        password.addEventListener('input', validatePassword);
        passwordConfirmation.addEventListener('input', validatePassword);
    });
</script>
@endsection
