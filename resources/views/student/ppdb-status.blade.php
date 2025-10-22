@extends('layouts.app')

@section('title', 'Status PPDB')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 sm:px-6 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl font-bold">Status Pendaftaran PPDB</h1>
                <p class="text-primary-100 mt-2 text-sm sm:text-base">SMP Negeri 01 Namrole</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Status Card -->
            <div class="p-6 sm:p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4
                        @if($ppdbRegistration->status === 'approved') bg-green-100 text-green-600
                        @elseif($ppdbRegistration->status === 'rejected') bg-red-100 text-red-600
                        @else bg-yellow-100 text-yellow-600 @endif">
                        @if($ppdbRegistration->status === 'approved')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @elseif($ppdbRegistration->status === 'rejected')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        @if($ppdbRegistration->status === 'approved')
                            Pendaftaran Diterima
                        @elseif($ppdbRegistration->status === 'rejected')
                            Pendaftaran Ditolak
                        @else
                            Menunggu Konfirmasi
                        @endif
                    </h2>
                    
                    <p class="text-gray-600">
                        @if($ppdbRegistration->status === 'approved')
                            Selamat! Pendaftaran PPDB Anda telah diterima. Anda sekarang dapat mengakses portal siswa.
                        @elseif($ppdbRegistration->status === 'rejected')
                            Maaf, pendaftaran PPDB Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                        @else
                            Pendaftaran PPDB Anda sedang dalam proses review. Silakan tunggu konfirmasi dari admin.
                        @endif
                    </p>
                </div>

                <!-- Registration Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pendaftaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor Pendaftaran</label>
                            <p class="text-gray-900 font-semibold">{{ $ppdbRegistration->registration_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="text-gray-900">{{ $ppdbRegistration->student_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <p class="text-gray-900">{{ $ppdbRegistration->birth_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <p class="text-gray-900">{{ $ppdbRegistration->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <p class="text-gray-900">{{ $ppdbRegistration->phone_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-gray-900">{{ $ppdbRegistration->email ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <p class="text-gray-900">{{ $ppdbRegistration->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                @if($ppdbRegistration->status === 'pending')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Pendaftaran Sedang Diproses</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Pendaftaran PPDB Anda sedang dalam proses review oleh admin. Silakan tunggu konfirmasi lebih lanjut.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($ppdbRegistration->status === 'rejected')
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Pendaftaran Ditolak</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>Maaf, pendaftaran PPDB Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                    @if($ppdbRegistration->notes)
                                        <p class="mt-2"><strong>Catatan:</strong> {{ $ppdbRegistration->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($ppdbRegistration->status === 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">Pendaftaran Diterima</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>Selamat! Pendaftaran PPDB Anda telah diterima. Anda sekarang dapat mengakses portal siswa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($ppdbRegistration->status === 'approved')
                        <a href="{{ route('student.dashboard') }}" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Masuk Portal Siswa
                        </a>
                    @else
                        <a href="{{ route('ppdb.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke PPDB
                        </a>
                    @endif
                    
                    <a href="{{ route('contact.index') }}" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
