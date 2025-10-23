<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Download lesson attachment.
     */
    public function downloadLessonAttachment(Course $course, Lesson $lesson, $filename)
    {
        $user = Auth::user();
        
        // Debug logging
        \Log::info('Download attempt', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'filename' => $filename,
            'attachments' => $lesson->attachments
        ]);
        
        // Check if student is enrolled in the course
        $enrollment = \App\Models\CourseEnrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            \Log::warning('User not enrolled', ['user_id' => $user->id, 'course_id' => $course->id]);
            return redirect()->route('student.courses.index')
                ->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Check if lesson is published
        if (!$lesson->is_published) {
            \Log::warning('Lesson not published', ['lesson_id' => $lesson->id]);
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Materi ini belum tersedia.');
        }

        // Check if lesson belongs to the course
        if ($lesson->course_id !== $course->id) {
            \Log::warning('Lesson not belongs to course', ['lesson_id' => $lesson->id, 'course_id' => $course->id]);
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Materi tidak ditemukan.');
        }

        // Check if attachment exists - need to check full path
        $fullAttachmentPath = null;
        if ($lesson->attachments) {
            foreach ($lesson->attachments as $attachment) {
                if (basename($attachment) === $filename) {
                    $fullAttachmentPath = $attachment;
                    break;
                }
            }
        }
        
        if (!$fullAttachmentPath) {
            \Log::warning('Attachment not found in lesson', [
                'filename' => $filename,
                'attachments' => $lesson->attachments
            ]);
            return redirect()->route('student.courses.lessons.show', [$course, $lesson])
                ->with('error', 'Lampiran tidak ditemukan.');
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($fullAttachmentPath)) {
            \Log::warning('File not found in storage', ['path' => $fullAttachmentPath]);
            return redirect()->route('student.courses.lessons.show', [$course, $lesson])
                ->with('error', 'File lampiran tidak ditemukan.');
        }

        \Log::info('File download successful', ['path' => $fullAttachmentPath]);
        
        // Return file download
        return Storage::disk('public')->download($fullAttachmentPath, basename($filename));
    }

    /**
     * Download assignment attachment.
     */
    public function downloadAssignmentAttachment($assignmentId, $filename)
    {
        $user = Auth::user();
        
        // Get assignment with course
        $assignment = \App\Models\Assignment::with('course')->findOrFail($assignmentId);
        
        // Check if student is enrolled in the course
        $enrollment = \App\Models\CourseEnrollment::where('student_id', $user->id)
            ->where('course_id', $assignment->course_id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        // Check if assignment is published
        if (!$assignment->is_published) {
            return redirect()->route('student.courses.show', $assignment->course)
                ->with('error', 'Tugas ini belum tersedia.');
        }

        // Check if attachment exists
        if (!$assignment->attachments || !in_array($filename, $assignment->attachments)) {
            return redirect()->route('student.assignments.show', $assignment)
                ->with('error', 'Lampiran tidak ditemukan.');
        }

        // Get the full path to the attachment
        $attachmentPath = $filename;
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($attachmentPath)) {
            return redirect()->route('student.assignments.show', $assignment)
                ->with('error', 'File lampiran tidak ditemukan.');
        }

        // Return file download
        return Storage::disk('public')->download($attachmentPath, basename($filename));
    }
}