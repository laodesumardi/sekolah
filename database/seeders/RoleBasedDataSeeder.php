<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleBasedDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin credentials configurable via env
        $adminEmail = env('ADMIN_EMAIL', 'admin@smpnamrole.sch.id');
        $adminPassword = env('ADMIN_PASSWORD', 'admin123');

        // Create 1 Admin User
        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Administrator Sekolah',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'phone' => '081234567000',
                'address' => 'Jl. Pendidikan No. 1, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create 1 Teacher User
        User::updateOrCreate(
            ['email' => 'guru@smpnamrole.sch.id'],
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'guru@smpnamrole.sch.id',
                'password' => Hash::make('guru123'),
                'role' => 'teacher',
                'teacher_id' => 'T001',
                'phone' => '081234567001',
                'address' => 'Jl. Guru No. 1, Namrole',
                'birth_date' => '1985-05-15',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Tambahkan detail guru pada User yang sudah dibuat
        User::updateOrCreate(
            ['email' => 'guru@smpnamrole.sch.id'],
            [
                'nip' => '198505151990031001',
                'name' => 'Budi Santoso, S.Pd',
                'phone' => '081234567001',
                'address' => 'Jl. Guru No. 1, Namrole',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'subject' => 'Matematika',
                'education' => 'S1 Pendidikan Matematika',
                'education_level' => 'S1 Pendidikan Matematika',
                'position' => 'Guru Matematika',
                'join_date' => '1990-03-01',
                'bio' => 'Guru Matematika yang berpengalaman dalam mengajar siswa SMP.',
                'type' => 'teacher',
                'is_active' => true
            ]
        );

        // Students must register through the registration form
        // No automatic student creation

        $this->command->info('Role-based data created successfully!');
        $this->command->info('=== LOGIN CREDENTIALS ===');
        $this->command->info("Admin: {$adminEmail} / {$adminPassword}");
        $this->command->info('Teacher: guru@smpnamrole.sch.id / guru123');
        $this->command->info('Students: Must register at /register');
        $this->command->info('========================');
    }
}