@extends('layouts.student')

@section('title', 'Status PPDB')
@section('page-title', 'Status PPDB')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Status Pendaftaran PPDB</h1>
                <p class="text-gray-600 mt-1">Lihat status pendaftaran PPDB Anda</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('ppdb.register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Daftar Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Status Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center
                    @if($ppdbRegistration->status === 'approved') bg-green-100
                    @elseif($ppdbRegistration->status === 'pending') bg-yellow-100
                    @elseif($ppdbRegistration->status === 'rejected') bg-red-100
                    @else bg-gray-100
                    @endif">
                    <i class="fas 
                        @if($ppdbRegistration->status === 'approved') fa-check text-green-600
                        @elseif($ppdbRegistration->status === 'pending') fa-clock text-yellow-600
                        @elseif($ppdbRegistration->status === 'rejected') fa-times text-red-600
                        @else fa-question text-gray-600
                        @endif text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        @if($ppdbRegistration->status === 'approved')
                            Pendaftaran Disetujui
                        @elseif($ppdbRegistration->status === 'pending')
                            Menunggu Persetujuan
                        @elseif($ppdbRegistration->status === 'rejected')
                            Pendaftaran Ditolak
                        @else
                            Status Tidak Diketahui
                        @endif
                    </h2>
                    <p class="text-gray-600">
                        @if($ppdbRegistration->status === 'approved')
                            Selamat! Pendaftaran Anda telah disetujui. Anda dapat mengakses portal siswa.
                        @elseif($ppdbRegistration->status === 'pending')
                            Pendaftaran Anda sedang dalam proses peninjauan. Silakan tunggu konfirmasi dari admin.
                        @elseif($ppdbRegistration->status === 'rejected')
                            Maaf, pendaftaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                        @else
                            Status pendaftaran tidak dapat ditentukan.
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="text-right">
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($ppdbRegistration->status === 'approved') bg-green-100 text-green-800
                    @elseif($ppdbRegistration->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($ppdbRegistration->status === 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($ppdbRegistration->status) }}
                </span>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendaftaran</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama Lengkap:</span>
                        <span class="font-medium">{{ $ppdbRegistration->full_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-medium">{{ $ppdbRegistration->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Telepon:</span>
                        <span class="font-medium">{{ $ppdbRegistration->phone_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Daftar:</span>
                        <span class="font-medium">{{ $ppdbRegistration->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($ppdbRegistration->status === 'approved')
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Disetujui:</span>
                        <span class="font-medium">{{ $ppdbRegistration->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h3>
                <div class="space-y-2">
                    @if($ppdbRegistration->birth_certificate)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Akta Kelahiran</span>
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    @endif
                    @if($ppdbRegistration->family_card)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Kartu Keluarga</span>
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    @endif
                    @if($ppdbRegistration->photo)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Foto</span>
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            @if($ppdbRegistration->status === 'approved')
                <div class="flex space-x-3">
                    <a href="{{ route('student.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Masuk Portal Siswa
                    </a>
                    <a href="{{ route('ppdb.check-status') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-refresh mr-2"></i>
                        Perbarui Status
                    </a>
                </div>
            @elseif($ppdbRegistration->status === 'pending')
                <div class="flex space-x-3">
                    <a href="{{ route('ppdb.check-status') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-refresh mr-2"></i>
                        Perbarui Status
                    </a>
                    <a href="{{ route('ppdb.register') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Pendaftaran
                    </a>
                </div>
            @elseif($ppdbRegistration->status === 'rejected')
                <div class="flex space-x-3">
                    <a href="{{ route('ppdb.register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-redo mr-2"></i>
                        Daftar Ulang
                    </a>
                    <a href="{{ route('home') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Admin
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection