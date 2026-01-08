<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Redirect (ROLE BASED)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'staff'     => redirect()->route('staff.dashboard'),
            'candidate' => redirect()->route('candidate.dashboard'),
            default     => abort(403),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Candidate management
        Route::get('/candidates/import/form', [CandidateController::class, 'importForm'])->name('candidates.import.form');
        Route::post('/candidates/import', [CandidateController::class, 'import'])->name('candidates.import');

        Route::get('/candidates/all', [CandidateController::class, 'allCandidates'])->name('candidates.all');
        Route::get('/candidates/hired', [CandidateController::class, 'hiredCandidates'])->name('candidates.hired');
        Route::get('/candidates/rejected', [CandidateController::class, 'rejectedCandidates'])->name('candidates.rejected');

        Route::get('/candidates/upcoming-interviews', [CandidateController::class, 'upcomingInterviews'])->name('candidates.upcoming-interviews');
        Route::get('/candidates/completed-interviews', [CandidateController::class, 'completedInterviews'])->name('candidates.completed-interviews');
        Route::get('/candidates/second-interviews', [CandidateController::class, 'secondInterviews'])->name('candidates.second.interviews');

        Route::get('/candidates/schedule/interview/form', [CandidateController::class, 'scheduleInterviewForm'])->name('candidates.schedule.form');
        Route::post('/candidates/schedule/interview', [CandidateController::class, 'scheduleInterview'])->name('candidates.schedule.interview');

        Route::get('/candidates/{candidate}/schedule-second-interview', [CandidateController::class, 'scheduleSecondInterviewForm'])
            ->name('candidates.schedule.second.interview.form');

        Route::post('/candidates/{candidate}/schedule-second-interview', [CandidateController::class, 'scheduleSecondInterview'])
            ->name('candidates.schedule.second.interview');

        Route::post('/candidates/bulk-schedule-second-interview',
            [CandidateController::class, 'bulkScheduleSecondInterview']
        )->name('candidates.bulk.schedule.second.interview');

        Route::post('/candidates/{id}/mark-status',
            [CandidateController::class, 'markInterviewStatus']
        )->name('candidates.mark.status');

        Route::get('/candidates/download/phones',
            [CandidateController::class, 'downloadPhoneNumbers']
        )->name('candidates.download.phones');

        // Resource routes (ADMIN ONLY)
        Route::resource('candidates', CandidateController::class)
            ->except(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | STAFF ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|staff')->group(function () {

        Route::get('/staff/dashboard', function () {
            return view('staff.dashboard');
        })->name('staff.dashboard');

        // Staff can only VIEW
        Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    });

    /*
    |--------------------------------------------------------------------------
    | CANDIDATE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|staff|candidate')->group(function () {

        Route::get('/candidate/dashboard', function () {
            return view('candidate.dashboard');
        })->name('candidate.dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');
