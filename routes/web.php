<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuidanceRecordController;
use App\Http\Controllers\GuidanceRecordPdfController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPdfExportController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentFileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('home');

    Route::resource('users', UserController::class)->except(['show', 'destroy']);
    Route::resource('students', StudentController::class)->except(['destroy']);
    Route::resource('teachers', TeacherController::class)->except(['destroy']);
    Route::resource('guidance-records', GuidanceRecordController::class)
        ->except(['index', 'show', 'destroy']);

    Route::get('/guidance-records/{guidanceRecord}/pdf', [GuidanceRecordPdfController::class, 'show'])
        ->name('guidance-records.pdf');

    Route::get('/students/export/all-pdfs', [StudentPdfExportController::class, 'exportAll'])
        ->name('students.export.all-pdfs');

    Route::post('/students/{student}/files', [StudentFileController::class, 'store'])
        ->name('students.files.store');

    Route::get('/students/{student}/files/{studentFile}', [StudentFileController::class, 'show'])
        ->name('students.files.show');

    Route::delete('/students/{student}/files/{studentFile}', [StudentFileController::class, 'destroy'])
        ->name('students.files.destroy');
    Route::get('/students/{student}/pdf', [StudentPdfExportController::class, 'exportStudent'])
        ->name('students.pdf');
});