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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('experience_years');
            $table->json('previous_experience'); // JSON: institute name as key, job position as value
            $table->integer('age');
            $table->enum('status', ['pending', 'hired', 'rejected', 'interview_scheduled', 'interview_completed', 'passed', 'failed'])->default('pending');
            $table->dateTime('interview_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
