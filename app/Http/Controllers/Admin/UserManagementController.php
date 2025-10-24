<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display user management page
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('role')
                      ->orderBy('name')
                      ->paginate(20);

        return view('admin.user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.user-management.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student',
            'is_active' => 'boolean',
            'nip' => 'nullable|string|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'religion' => 'nullable|string|max:100',
            // Teacher specific fields
            'subject' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'classes' => 'nullable|array',
            'classes.*' => 'string|in:1,2,3,4,5,6,7,8,9',
            // Student specific fields
            'student_class' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_occupation' => 'nullable|string|max:255',
            'parent_address' => 'nullable|string|max:500',
        ]);

        $userData = $request->all();
        $userData['password'] = Hash::make($request->password);
        $userData['is_active'] = $request->has('is_active');

        User::create($userData);

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('admin.user-management.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student',
            'is_active' => 'boolean',
            'nip' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'religion' => 'nullable|string|max:100',
            // Teacher specific fields
            'subject' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'classes' => 'nullable|array',
            'classes.*' => 'string|in:1,2,3,4,5,6,7,8,9',
            // Student specific fields
            'student_class' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_occupation' => 'nullable|string|max:255',
            'parent_address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $userData = $request->except('password');
        $userData['is_active'] = $request->has('is_active');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            
            // Store new photo based on user role
            if ($user->role === 'teacher') {
                $photoPath = $request->file('photo')->store('teachers/photos', 'public');
            } elseif ($user->role === 'student') {
                $photoPath = $request->file('photo')->store('students/photos', 'public');
            } else {
                $photoPath = $request->file('photo')->store('admins/photos', 'public');
            }
            
            $userData['photo'] = $photoPath;
            
            // Ensure the file is accessible via public storage
            $this->syncFileToPublicStorage($photoPath);
        }

        $user->update($userData);

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Sync file from storage to public storage
     */
    private function syncFileToPublicStorage($filePath)
    {
        $sourcePath = storage_path('app/public/' . $filePath);
        $targetPath = public_path('storage/' . $filePath);
        
        // Create target directory if it doesn't exist
        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        // Copy file if source exists and target doesn't
        if (file_exists($sourcePath) && !file_exists($targetPath)) {
            copy($sourcePath, $targetPath);
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting the current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(User $user)
    {
        // Prevent deactivating the current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.user-management.index')
            ->with('success', "User {$user->name} berhasil {$status}!");
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        return view('admin.user-management.show', compact('user'));
    }
}
