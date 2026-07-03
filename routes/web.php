<?php
// REPLACE: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ParqController;
use App\Http\Controllers\ProgramRecommendationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WalkInController;
use App\Http\Controllers\BookingReviewController;

// ── Public landing page ──────────────────────────────────────────
Route::get('/', function () {
    return view('booking.landing');
});

// ── Public Booking Flow (no login required) ──────────────────────

// Step 1 – Assessment form
Route::get('/booking/assessment', [PublicBookingController::class, 'assessment']);
Route::post('/assessment', [AssessmentController::class, 'store']);

// Step 2 – PAR-Q safety questionnaire
Route::get('/booking/parq/{id}', function ($id) {
    session(['assessment_id' => $id]);
    return view('booking.parq');
});
Route::post('/booking/parq', [ParqController::class, 'store']);

// Step 3 – Recommendation + slot selection
// (branches internally to Personal Training / Pilates / Open Gym view)
Route::get('/booking/program', [ProgramRecommendationController::class, 'show']);

// Step 3b – Open Gym direct access page (no trainer/program)
Route::get('/booking/open-gym', [PublicBookingController::class, 'openGym']);

// Step 3.5 – Review & Confirm page   ← ADD THIS LINE
Route::get('/booking/review', [BookingReviewController::class, 'show']);

// Step 4 – Confirm booking (policy sign-off + slot reservation)
Route::post('/booking', [BookingController::class, 'store']);

// Step 5 – Confirmation page
Route::get('/booking/confirmation/{id}', [BookingController::class, 'show'])
    ->name('booking.confirmation');

// ── Cancel / Reschedule an existing booking ──────────────────────
Route::patch('/booking/{id}/cancel',     [BookingController::class, 'cancel']);
Route::patch('/booking/{id}/reschedule', [BookingController::class, 'reschedule']);

// ── Walk-in inquiry (logged for staff follow-up) ─────────────────
Route::get('/walk-in', function () {
    return view('booking.walk_in');
});

Route::get('/booking/membership', function () {
    return view('booking.membership');
});

// ── Authenticated routes (Laravel Breeze defaults) ───────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
  ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
