@extends('layouts.student')

@section('title', 'Kelas Saya')
@section('page-title', 'Kelas Saya')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-graduation-cap mr-3 text-primary-600"></i>
                    Kelas Saya
                </h1>
                <p class="text-gray-600 mt-1">Kelas yang sedang Anda ikuti</p>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Total {{ $enrolledCourses->count() }} kelas aktif</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('student.courses.index') }}" class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Daftar Kelas Baru</span>
                </a>
                <a href="{{ route('student.assignments.index') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-tasks mr-2"></i>
                    <span>Semua Tugas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Enrolled Courses -->
    @if($enrolledCourses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrolledCourses as $course)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $course->code }}</p>
                            <p class="text-gray-700 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-medium rounded-full
                            @if($course->status === 'active') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $course->status_label }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ $course->teacher->name }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-book mr-2"></i>
                            <span>{{ $course->subject }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>Kelas {{ $course->class_level }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-users mr-2"></i>
                            <span>{{ $course->enrollments()->where('status', 'approved')->count() }} siswa</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="text-sm text-gray-500">
                            @if($course->start_date)
                                Dimulai: {{ $course->start_date->format('d M Y') }}
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('student.courses.show', $course) }}" class="inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-door-open mr-2"></i>
                                <span>Masuk Kelas</span>
                            </a>
                            
                            <a href="{{ route('student.assignments.index', ['course' => $course->id]) }}" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-tasks mr-2"></i>
                                <span>Tugas</span>
                            </a>
                            
                            <a href="{{ route('student.forums.index', ['course' => $course->id]) }}" class="inline-flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-black px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-comments mr-2"></i>
                                <span>Forum</span>
                            </a>
                            
                            <a href="{{ route('student.grades.index', ['course' => $course->id]) }}" class="inline-flex items-center justify-center bg-orange-600 hover:bg-orange-700 text-black px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-chart-line mr-2"></i>
                                <span>Nilai</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <i class="fas fa-graduation-cap text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada kelas</h3>
            <p class="text-gray-600 mb-6">Daftar ke kelas untuk memulai pembelajaran.</p>
            <a href="{{ route('student.courses.index') }}" class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-search mr-3"></i>
                <span>Lihat Kelas Tersedia</span>
            </a>
        </div>
    @endif
</div>
@endsection
