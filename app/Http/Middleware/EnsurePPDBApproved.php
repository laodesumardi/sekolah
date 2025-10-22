<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PPDBRegistration;

class EnsurePPDBApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user is a student
        if ($user->role !== 'student') {
            return $next($request);
        }

        // Check if student has PPDB registration
        $ppdbRegistration = PPDBRegistration::where('email', $user->email)
            ->orWhere('phone_number', $user->phone)
            ->first();

        if (!$ppdbRegistration) {
            // Student hasn't registered for PPDB
            return redirect()->route('student.ppdb-required')
                ->with('warning', 'Anda harus mendaftar PPDB terlebih dahulu sebelum dapat mengakses portal siswa.');
        }

        // Check PPDB status
        if ($ppdbRegistration->status === 'pending') {
            return redirect()->route('student.ppdb-status')
                ->with('info', 'Pendaftaran PPDB Anda sedang dalam proses review. Silakan tunggu konfirmasi dari admin.');
        }

        if ($ppdbRegistration->status === 'rejected') {
            return redirect()->route('student.ppdb-status')
                ->with('error', 'Pendaftaran PPDB Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
        }

        if ($ppdbRegistration->status === 'approved') {
            // PPDB approved, allow access to student portal
            return $next($request);
        }

        // Default case - redirect to PPDB status page
        return redirect()->route('student.ppdb-status');
    }
}
