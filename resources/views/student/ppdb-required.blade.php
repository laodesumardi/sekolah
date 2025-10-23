@extends('layouts.student')

@section('title', 'PPDB Diperlukan')
@section('page-title', 'PPDB Diperlukan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">PPDB Diperlukan</h2>
            <p class="text-lg text-gray-600 mb-8">
                Untuk mengakses portal siswa, Anda harus mendaftar PPDB terlebih dahulu.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="text-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Langkah-langkah Pendaftaran</h3>
                <p class="text-gray-600">Ikuti langkah-langkah berikut untuk mendaftar PPDB:</p>
            </div>

            <div class="space-y-4 mb-8">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 font-semibold text-sm">1</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Isi Form Pendaftaran</h4>
                        <p class="text-sm text-gray-600">Lengkapi semua data yang diperlukan dengan benar</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 font-semibold text-sm">2</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Upload Dokumen</h4>
                        <p class="text-sm text-gray-600">Upload dokumen pendukung yang diperlukan</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 font-semibold text-sm">3</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Tunggu Persetujuan</h4>
                        <p class="text-sm text-gray-600">Admin akan memeriksa dan menyetujui pendaftaran Anda</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-semibold text-sm">4</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Akses Portal</h4>
                        <p class="text-sm text-gray-600">Setelah disetujui, Anda dapat mengakses portal siswa</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <a href="{{ route('ppdb.register') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar PPDB Sekarang
                </a>
                
                <a href="{{ route('ppdb.check-status') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Cek Status Pendaftaran
                </a>
            </div>
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-500">
                Butuh bantuan? <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-500">Hubungi Admin</a>
            </p>
        </div>
    </div>
</div>
@endsection