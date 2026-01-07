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
            case 'candidate':
                return redirect()->route('candidate.dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Candidate management routes
        Route::resource('candidates', CandidateController::class);

        // Additional candidate routes
        Route::get('/candidates/import/form', [CandidateController::class, 'importForm'])->name('candidates.import.form');
        Route::post('/candidates/import', [CandidateController::class, 'import'])->name('candidates.import');
        Route::get('/candidates/all', [CandidateController::class, 'allCandidates'])->name('candidates.all');
        Route::get('/candidates/hired', [CandidateController::class, 'hiredCandidates'])->name('candidates.hired');
        Route::get('/candidates/rejected', [CandidateController::class, 'rejectedCandidates'])->name('candidates.rejected');
        Route::get('/candidates/schedule/interview/form', [CandidateController::class, 'scheduleInterviewForm'])->name('candidates.schedule.form');
        Route::post('/candidates/schedule/interview', [CandidateController::class, 'scheduleInterview'])->name('candidates.schedule.interview');
        Route::get('/candidates/upcoming-interviews', [CandidateController::class, 'upcomingInterviews'])->name('candidates.upcoming-interviews');
        Route::get('/candidates/completed-interviews', [CandidateController::class, 'completedInterviews'])->name('candidates.completed-interviews');
        Route::post('/candidates/{id}/mark-status', [CandidateController::class, 'markInterviewStatus'])->name('candidates.mark.status');
        Route::get('/candidates/download/phones', [CandidateController::class, 'downloadPhoneNumbers'])->name('candidates.download.phones');
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

    // Candidate routes
    Route::middleware('role:admin,staff,candidate')->group(function () {
        Route::get('/candidate/dashboard', function () {
            return view('candidate.dashboard');
        })->name('candidate.dashboard');
    });
});

// Default route - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});
