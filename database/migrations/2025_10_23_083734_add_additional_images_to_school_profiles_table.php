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
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('image_2')->nullable();
            $table->string('image_2_alt')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_3_alt')->nullable();
            $table->string('image_4')->nullable();
            $table->string('image_4_alt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'image_2',
                'image_2_alt',
                'image_3',
                'image_3_alt',
                'image_4',
                'image_4_alt'
            ]);
        });
    }
};
