<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PPDB;
use App\Models\PPDBRegistration;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PPDBController extends Controller
{
    /**
     * Display PPDB information page
     */
    public function index()
    {
        $ppdb = PPDB::active()->first();
        
        if (!$ppdb) {
            return view('ppdb.index', compact('ppdb'));
        }
        
        return view('ppdb.index', compact('ppdb'));
    }

    /**
     * Show registration form
     */
    public function register()
    {
        $ppdb = PPDB::active()->first();
        
        if (!$ppdb || !$ppdb->isRegistrationOpen()) {
            return redirect()->route('ppdb.index')
                           ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        // Check if authenticated student already has PPDB registration
        if (auth()->check() && auth()->user()->role === 'student') {
            $existingRegistration = PPDBRegistration::where('email', auth()->user()->email)
                ->orWhere('phone_number', auth()->user()->phone)
                ->first();
            
            if ($existingRegistration) {
                return redirect()->route('student.ppdb-status')
                               ->with('info', 'Anda sudah memiliki pendaftaran PPDB.');
            }
        }
        
        return view('ppdb.register', compact('ppdb'));
    }

    /**
     * Store registration data
     */
    public function store(Request $request)
    {
        $ppdb = PPDB::active()->first();
        
        if (!$ppdb || !$ppdb->isRegistrationOpen()) {
            return redirect()->route('ppdb.index')
                           ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        $request->validate([
            'student_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_occupation' => 'required|string|max:255',
            'previous_school' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'motivation' => 'nullable|string',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'family_card' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'report_card' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();
        $data['registration_number'] = PPDBRegistration::generateRegistrationNumber();

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadFile($request->file('photo'), 'photos');
        }
        if ($request->hasFile('birth_certificate')) {
            $data['birth_certificate'] = $this->uploadFile($request->file('birth_certificate'), 'documents');
        }
        if ($request->hasFile('family_card')) {
            $data['family_card'] = $this->uploadFile($request->file('family_card'), 'documents');
        }
        if ($request->hasFile('report_card')) {
            $data['report_card'] = $this->uploadFile($request->file('report_card'), 'documents');
        }

        PPDBRegistration::create($data);

        // If user is authenticated student, redirect to status page
        if (auth()->check() && auth()->user()->role === 'student') {
            return redirect()->route('student.ppdb-status')
                           ->with('success', 'Pendaftaran PPDB berhasil! Nomor pendaftaran Anda: ' . $data['registration_number']);
        }

        return redirect()->route('ppdb.success')
                       ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $data['registration_number'])
                       ->with('registration_number', $data['registration_number']);
    }

    /**
     * Show registration success page
     */
    public function success()
    {
        // Create notification for admin when someone visits success page
        Notification::createSystem(
            'PPDB Success Page Accessed',
            'Seseorang telah mengakses halaman sukses PPDB',
            'green'
        );
        
        return view('ppdb.success');
    }

    /**
     * Check registration status
     */
    public function checkStatus(Request $request)
    {
        $registrationNumber = $request->input('registration_number');
        
        if (!$registrationNumber) {
            return view('ppdb.check-status');
        }

        $registration = PPDBRegistration::with('user')->where('registration_number', $registrationNumber)->first();
        
        return view('ppdb.check-status', compact('registration'));
    }

    /**
     * Refresh CSRF token for mobile
     */
    public function refreshToken()
    {
        return response()->json([
            'token' => csrf_token(),
            'success' => true
        ]);
    }

    /**
     * Download registration form as PDF
     */
    public function downloadForm(Request $request)
    {
        $registrationNumber = $request->input('registration_number');
        
        if (!$registrationNumber) {
            return redirect()->route('ppdb.success')
                           ->with('error', 'Nomor pendaftaran tidak ditemukan!');
        }

        $registration = PPDBRegistration::where('registration_number', $registrationNumber)->first();
        
        if (!$registration) {
            return redirect()->route('ppdb.success')
                           ->with('error', 'Data pendaftaran tidak ditemukan!');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ppdb.pdf-form', compact('registration'));
        
        return $pdf->download('Form_Pendaftaran_PPDB_' . $registrationNumber . '.pdf');
    }

    /**
     * Create student account automatically when registration is approved
     */
    public function createStudentAccount(PPDBRegistration $registration)
    {
        // Check if student account already exists
        $existingUser = User::where('email', $registration->email)
                           ->orWhere('nip', $registration->registration_number)
                           ->first();
        
        if ($existingUser) {
            return $existingUser;
        }

        // Generate NIS (Nomor Induk Siswa)
        $nis = $this->generateNIS();
        
        // Create student account
        $user = User::create([
            'name' => $registration->student_name,
            'email' => $registration->email ?: $registration->registration_number . '@student.smpnamrole.sch.id',
            'password' => Hash::make($nis), // Password is the same as NIS
            'role' => 'student',
            'nip' => $nis,
            'student_id' => $nis, // Use NIS as student_id
            'class_level' => 'SMP', // Default class level for PPDB students
            'phone' => $registration->phone_number,
            'address' => $registration->address,
            'date_of_birth' => $registration->birth_date,
            'gender' => $registration->gender == 'L' ? 'male' : 'female',
            'religion' => $registration->religion,
            'parent_name' => $registration->parent_name,
            'parent_phone' => $registration->parent_phone,
            'parent_occupation' => $registration->parent_occupation,
            'parent_address' => $registration->address, // Using student address as parent address
            'student_class' => null, // Will be assigned later by admin
            'is_active' => true,
        ]);

        // Update registration with user ID and NIS
        $registration->update([
            'user_id' => $user->id,
            'nis' => $nis,
            'status' => 'approved'
        ]);

        return $user;
    }

    /**
     * Generate NIS (Nomor Induk Siswa)
     */
    private function generateNIS()
    {
        // Format: YYYY + 4 digit sequential number
        $currentYear = date('Y');
        $lastStudent = User::where('role', 'student')
                          ->where('nip', 'like', $currentYear . '%')
                          ->orderBy('nip', 'desc')
                          ->first();
        
        if ($lastStudent && $lastStudent->nip) {
            $lastNIS = $lastStudent->nip;
            $lastNumber = (int) substr($lastNIS, 4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $currentYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Upload file helper
     */
    private function uploadFile($file, $folder)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("ppdb/{$folder}", $filename, 'public');
        return $path;
    }
}
