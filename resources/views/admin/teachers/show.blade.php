@extends('layouts.admin')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Detail Guru')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 sm:px-6 py-6 sm:py-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center">
                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}" class="h-16 w-16 rounded-full object-cover mr-4 border-2 border-gray-200" onerror="this.src='/images/default-teacher.png'">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">{{ $teacher->name }}</h1>
                    <p class="text-primary-100 mt-2 text-sm sm:text-base">NIP: {{ $teacher->nip }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Informasi Guru</h3>
            </div>
            <div class="p-4 sm:p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIP</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->nip }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->subject ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $teacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $teacher->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Guru
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
