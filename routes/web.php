<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Container Tracking Route (Public)
Route::get('/track', [ContainerController::class, 'track'])->name('containers.track');
Route::post('/track', [ContainerController::class, 'trackSearch'])->name('containers.track.search');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('customers', CustomerController::class);
    Route::resource('containers', ContainerController::class);

    // Queue Management Routes
    Route::get('/containers-queue', [ContainerController::class, 'queue'])->name('containers.queue');
    Route::post('/containers-queue/process-next', [ContainerController::class, 'processNext'])->name('containers.queue.process-next');
    Route::post('/containers/{container}/complete-processing', [ContainerController::class, 'completeProcessing'])->name('containers.complete-processing');
    Route::get('/containers-queue/simulation', [ContainerController::class, 'queueSimulation'])->name('containers.queue.simulation');

    // Penalty Management Routes
    Route::get('/penalty-report', [ContainerController::class, 'penaltyReport'])->name('containers.penalty-report');
    Route::post('/containers/{container}/update-penalty', [ContainerController::class, 'updatePenalty'])->name('containers.update-penalty');
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});
