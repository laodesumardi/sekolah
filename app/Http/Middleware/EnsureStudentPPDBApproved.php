<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentPPDBApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Log middleware execution
        \Log::info('EnsureStudentPPDBApproved middleware', [
            'user_id' => $user ? $user->id : 'null',
            'user_role' => $user ? $user->role : 'null',
            'url' => $request->url()
        ]);
        
        // Only apply to students
        if ($user && $user->role === 'student') {
            // Check if student has PPDB registration by email or phone
            $ppdbRegistration = \App\Models\PPDBRegistration::where('email', $user->email)
                ->orWhere('phone_number', $user->phone)
                ->first();
                
            if (!$ppdbRegistration) {
                // No PPDB registration, redirect to PPDB
                \Log::info('Student has no PPDB registration', [
                    'user_id' => $user->id,
                    'user_email' => $user->email
                ]);
                return redirect()->route('ppdb.register')
                    ->with('error', 'Anda belum mendaftar PPDB. Silakan daftar terlebih dahulu.');
            }
            
            // Check if PPDB registration is approved
            if ($ppdbRegistration->status !== 'approved') {
                // PPDB not approved, redirect to PPDB status check
                \Log::info('Student PPDB not approved', [
                    'user_id' => $user->id,
                    'ppdb_status' => $ppdbRegistration->status
                ]);
                return redirect()->route('ppdb.check-status')
                    ->with('error', 'Pendaftaran PPDB Anda belum disetujui. Silakan tunggu konfirmasi dari admin.');
            }
        }
        
        return $next($request);
    }
}