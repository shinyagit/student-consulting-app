<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GuidanceRecordController;
use App\Http\Controllers\GuidanceRecordPdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->except(['show', 'destroy']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class)->except(['destroy']);
    Route::resource('teachers', TeacherController::class)->except(['destroy']);
    Route::resource('guidance-records', GuidanceRecordController::class)
        ->except(['index', 'show', 'destroy']);
    Route::get('/guidance-records/{guidanceRecord}/pdf', [GuidanceRecordPdfController::class, 'show'])
        ->name('guidance-records.pdf');
});