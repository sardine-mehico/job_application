<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Employer\ApplicationIndex;
use App\Livewire\JobApplicationWizard;
use Illuminate\Support\Facades\Route;

Route::get('/', JobApplicationWizard::class)->name('application.form');

Route::middleware('guest')->group(function () {
    Route::get('/employer/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/employer/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/employer', fn () => redirect()->route('employer.applications'))->name('employer.home');
    Route::get('/employer/applications', ApplicationIndex::class)->name('employer.applications');
    Route::post('/employer/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
