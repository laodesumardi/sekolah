@extends('layouts.teacher')

@section('title', 'Detail Materi')
@section('page-title', 'Detail Materi')

@section('content')
<div class="space-y-6">
    <!-- Lesson Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $lesson->title }}</h1>
                <p class="text-sm text-gray-600 mb-2">{{ $course->title }} • {{ $course->code }}</p>
                <p class="text-sm text-gray-500">Kelas: {{ $course->class_level }}{{ $course->class_section ? ' - ' . $course->class_section : '' }}</p>
                @if($lesson->description)
                <p class="text-gray-700 mb-4">{{ $lesson->description }}</p>
                @endif
                
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    @if($lesson->due_date)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Due: {{ $lesson->due_date->format('d M Y, H:i') }}
                    </div>
                    @endif
                    @if($lesson->points)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ $lesson->points }} poin
                    </div>
                    @endif
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Urutan: {{ $lesson->order }}
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($lesson->type === 'lesson') bg-blue-100 text-blue-800
                    @elseif($lesson->type === 'assignment') bg-green-100 text-green-800
                    @elseif($lesson->type === 'quiz') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($lesson->type) }}
                </span>
                @if($lesson->is_published)
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                    Aktif
                </span>
                @else
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                    Draft
                </span>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('teacher.courses.lessons.edit', [$course, $lesson]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Edit Materi
            </a>
            
            <form action="{{ route('teacher.courses.lessons.toggle-published', [$course, $lesson]) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    @if($lesson->is_published)
                        Sembunyikan
                    @else
                        Publikasikan
                    @endif
                </button>
            </form>
            
            <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Kembali ke Daftar Materi
            </a>
        </div>
    </div>

    <!-- Lesson Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Konten Materi</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($lesson->content)) !!}
        </div>
    </div>

    <!-- Attachments -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Lampiran</h2>
            <span class="text-sm text-gray-500">{{ $lesson->attachments ? count($lesson->attachments) : 0 }} file</span>
        </div>
        
        @if($lesson->attachments && count($lesson->attachments) > 0)
            <div class="space-y-3">
                @foreach($lesson->attachments as $index => $attachment)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1">
                            <div class="flex-shrink-0">
                                @php
                                    $extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                                @endphp
                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-green-600"></i>
                                    </div>
                                @elseif(in_array($extension, ['pdf']))
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-red-600"></i>
                                    </div>
                                @elseif(in_array($extension, ['doc', 'docx']))
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-word text-blue-600"></i>
                                    </div>
                                @elseif(in_array($extension, ['xls', 'xlsx']))
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-excel text-green-600"></i>
                                    </div>
                                @elseif(in_array($extension, ['ppt', 'pptx']))
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-powerpoint text-orange-600"></i>
                                    </div>
                                @elseif(in_array($extension, ['zip', 'rar', '7z']))
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-archive text-purple-600"></i>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file text-gray-600"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ basename($attachment) }}</p>
                                <p class="text-xs text-gray-500">
                                    @if(file_exists(storage_path('app/public/' . $attachment)))
                                        {{ number_format(filesize(storage_path('app/public/' . $attachment)) / 1024, 1) }} KB
                                    @endif
                                    • {{ strtoupper($extension) }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <a href="{{ Storage::url($attachment) }}" target="_blank" class="inline-flex items-center px-3 py-1 text-sm bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat
                            </a>
                            
                            <a href="{{ Storage::url($attachment) }}" download class="inline-flex items-center px-3 py-1 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-download mr-1"></i>
                                Download
                            </a>
                            
                            <button onclick="confirmDeleteAttachment('{{ $index }}', '{{ basename($attachment) }}')" class="inline-flex items-center px-3 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-paperclip text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada lampiran</h3>
                <p class="text-gray-500 mb-4">Tambahkan lampiran untuk melengkapi materi ini.</p>
                <a href="{{ route('teacher.courses.lessons.edit', [$course, $lesson]) }}" class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Lampiran
                </a>
            </div>
        @endif
    </div>

    <!-- Settings -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Pengaturan Materi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Status</h3>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Publikasi:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->is_published) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $lesson->is_published ? 'Dipublikasikan' : 'Draft' }}
                        </span>
                    </div>
                    @if($lesson->published_at)
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Dipublikasikan pada:</span>
                        <span class="ml-2 text-sm text-gray-900">{{ $lesson->published_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Fitur</h3>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Komentar:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->settings['allow_comments'] ?? false) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ($lesson->settings['allow_comments'] ?? false) ? 'Diizinkan' : 'Tidak diizinkan' }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Wajib diselesaikan:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->settings['require_completion'] ?? false) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ($lesson->settings['require_completion'] ?? false) ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Tampilkan progress:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($lesson->settings['show_progress'] ?? false) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ($lesson->settings['show_progress'] ?? false) ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Attachment Form (Hidden) -->
<form id="delete-attachment-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDeleteAttachment(attachmentIndex, fileName) {
    if (confirm(`Apakah Anda yakin ingin menghapus lampiran "${fileName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
        const form = document.getElementById('delete-attachment-form');
        form.action = `/teacher/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/attachments/${attachmentIndex}`;
        form.submit();
    }
}
</script>
@endsection
