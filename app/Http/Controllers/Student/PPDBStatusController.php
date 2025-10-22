<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PPDBRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PPDBStatusController extends Controller
{
    /**
     * Display PPDB status for the authenticated student
     */
    public function index()
    {
        $user = Auth::user();
        
        // Find PPDB registration by email or phone
        $ppdbRegistration = PPDBRegistration::where('email', $user->email)
            ->orWhere('phone_number', $user->phone)
            ->first();

        if (!$ppdbRegistration) {
            return redirect()->route('student.ppdb-required')
                ->with('warning', 'Anda belum mendaftar PPDB. Silakan daftar terlebih dahulu.');
        }

        return view('student.ppdb-status', compact('ppdbRegistration'));
    }

    /**
     * Display PPDB required page
     */
    public function required()
    {
        return view('student.ppdb-required');
    }
}
