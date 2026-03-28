@extends('layouts.teacher')

@section('title', 'Kelas Saya')
@section('page-title', 'Kelas Saya')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kelas Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_courses'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Materi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_lessons'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-graduation-cap mr-3 text-primary-600"></i>
                    Kelas Saya
                </h1>
                <p class="text-gray-600 mt-1">Kelas yang Anda kelola</p>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Total {{ $courses->count() }} kelas</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Buat Kelas Baru</span>
                </a>
                <a href="{{ route('teacher.assignments.overview') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-tasks mr-2"></i>
                    <span>Semua Tugas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $course->code }}</p>
                        <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($course->description, 100) }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($course->status === 'active') bg-green-100 text-green-800
                            @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $course->status_label }}
                        </span>
                        @if($course->is_public)
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                            Publik
                        </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        {{ $course->enrolled_students_count }} Siswa
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ $course->lessons->count() }} Materi
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="text-sm text-gray-500">
                        {{ $course->subject }} • {{ $course->class_level }}
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('teacher.courses.show', $course) }}" class="inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-door-open mr-2"></i>
                            <span>Masuk Kelas</span>
                        </a>
                        
                        <a href="{{ route('teacher.courses.assignments.index', $course) }}" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-tasks mr-2"></i>
                            <span>Tugas</span>
                        </a>
                        
                        <a href="{{ route('teacher.courses.forums.index', $course) }}" class="inline-flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-black px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-comments mr-2"></i>
                            <span>Forum</span>
                        </a>
                        
                        <a href="{{ route('teacher.courses.edit', $course) }}" class="inline-flex items-center justify-center bg-orange-600 hover:bg-orange-700 text-black px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-edit mr-2"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        Dibuat: {{ $course->created_at->format('d M Y') }}
                    </div>
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('teacher.courses.toggle-status', $course) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full transition-colors duration-200
                                @if($course->status === 'active') bg-yellow-100 text-yellow-800 hover:bg-yellow-200
                                @else bg-green-100 text-green-800 hover:bg-green-200
                                @endif">
                                <i class="fas fa-power-off mr-1"></i>
                                @if($course->status === 'active')
                                    Nonaktifkan
                                @else
                                    Aktifkan
                                @endif
                            </button>
                        </form>
                        
                        <button onclick="confirmDelete('{{ $course->id }}', '{{ $course->title }}')" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 hover:bg-red-200 transition-colors duration-200">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kelas</h3>
                <p class="mt-1 text-sm text-gray-500">Gunakan menu "Buat Kelas Baru" di sidebar untuk membuat kelas pertama Anda.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
    <div class="mt-8">
        {{ $courses->links() }}
    </div>
    @endif
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(courseId, courseTitle) {
    if (confirm(`Apakah Anda yakin ingin menghapus kelas "${courseTitle}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait kelas ini.`)) {
        const form = document.getElementById('delete-form');
        form.action = `/teacher/courses/${courseId}`;
        form.submit();
    }
}
</script>
@endsection
