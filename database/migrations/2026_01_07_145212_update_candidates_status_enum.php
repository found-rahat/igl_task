<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to modify the enum to include the new value
        DB::statement("ALTER TABLE candidates MODIFY COLUMN status ENUM('pending', 'hired', 'rejected', 'interview_scheduled', 'interview_completed', 'passed', 'failed', 'second_interview_scheduled')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the 'second_interview_scheduled' option when rolling back
        DB::statement("ALTER TABLE candidates MODIFY COLUMN status ENUM('pending', 'hired', 'rejected', 'interview_scheduled', 'interview_completed', 'passed', 'failed')");
    }
};
