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
        Schema::table('candidates', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'hired',
                'rejected',
                'interview_scheduled',
                'interview_completed',
                'passed',
                'failed',
                'second_interview_scheduled'
            ])
            ->default('pending')
            ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'hired',
                'rejected',
                'interview_scheduled',
                'interview_completed',
                'passed',
                'failed',
                'second_interview_scheduled'
            ])
            ->default(null)
            ->change();
        });
    }
};
