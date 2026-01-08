<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateController;

// Guest routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard route - redirects based on user role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // User management routes
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Additional candidate routes (defined first to ensure priority)
        Route::get('/candidates/import/form', [CandidateController::class, 'importForm'])->name('candidates.import.form');
        Route::post('/candidates/import', [CandidateController::class, 'import'])->name('candidates.import');
        Route::get('/candidates/all', [CandidateController::class, 'allCandidates'])->name('candidates.all');
        Route::get('/candidates/hired', [CandidateController::class, 'hiredCandidates'])->name('candidates.hired');
        Route::get('/candidates/rejected', [CandidateController::class, 'rejectedCandidates'])->name('candidates.rejected');
        Route::get('/candidates/schedule/interview/form', [CandidateController::class, 'scheduleInterviewForm'])->name('candidates.schedule.form');
        Route::post('/candidates/schedule/interview', [CandidateController::class, 'scheduleInterview'])->name('candidates.schedule.interview');
        Route::get('/candidates/upcoming-interviews', [CandidateController::class, 'upcomingInterviews'])->name('candidates.upcoming-interviews');
        Route::get('/candidates/second-interviews', [CandidateController::class, 'secondInterviews'])->name('candidates.second.interviews');
        Route::get('/candidates/completed-interviews', [CandidateController::class, 'completedInterviews'])->name('candidates.completed-interviews');
        Route::post('/candidates/{id}/mark-status', [CandidateController::class, 'markInterviewStatus'])->name('candidates.mark.status');
        Route::get('/candidates/download/phones', [CandidateController::class, 'downloadPhoneNumbers'])->name('candidates.download.phones');
        Route::get('/candidates/{candidate}/schedule-second-interview', [CandidateController::class, 'scheduleSecondInterviewForm'])->name('candidates.schedule.second.interview.form');
        Route::post('/candidates/{candidate}/schedule-second-interview', [CandidateController::class, 'scheduleSecondInterview'])->name('candidates.schedule.second.interview');

        // Define only the necessary resource routes to avoid conflicts
        Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/create', [CandidateController::class, 'create'])->name('candidates.create');
        Route::post('/candidates', [CandidateController::class, 'store'])->name('candidates.store');
        Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
        Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
        Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
        Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::post('/candidates/bulk-schedule-second-interview', [CandidateController::class, 'bulkScheduleSecondInterview'])->name('candidates.bulk.schedule.second.interview');
    });

    // Staff routes
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/staff/dashboard', function () {
            return view('staff.dashboard');
        })->name('staff.dashboard');

        // Staff can view candidates
        Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
        Route::get('/candidates/import/form', [CandidateController::class, 'importForm'])->name('candidates.import.form');
        Route::post('/candidates/import', [CandidateController::class, 'import'])->name('candidates.import');
    });

});

// Public candidate search route (no authentication required) - should be outside the auth middleware
Route::get('/candidate/search', [CandidateController::class, 'searchForm'])->name('candidate.search.form');
Route::post('/candidate/search', [CandidateController::class, 'search'])->name('candidate.search');

// Default route - show home page with company information
Route::get('/', function () {
    return view('home');
})->name('home');
