<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('users', 'education_level')) {
                $table->string('education_level')->nullable()->after('education');
            }
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type')->nullable()->after('education_level');
            }
            if (!Schema::hasColumn('users', 'student_class')) {
                $table->string('student_class')->nullable()->after('class_section');
            }
            if (!Schema::hasColumn('users', 'parent_occupation')) {
                $table->string('parent_occupation')->nullable()->after('parent_phone');
            }
            if (!Schema::hasColumn('users', 'parent_address')) {
                $table->text('parent_address')->nullable()->after('parent_occupation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'education_level',
                'type',
                'student_class',
                'parent_occupation',
                'parent_address'
            ]);
        });
    }
};
