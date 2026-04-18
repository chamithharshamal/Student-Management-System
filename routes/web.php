<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('admin.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::put('/students/{student}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/students/{student}', [AdminController::class, 'deleteStudent'])->name('admin.students.destroy');
    Route::get('/students/export/csv', [AdminController::class, 'exportCsv'])->name('admin.students.export.csv');
    Route::get('/students/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.students.export.pdf');
    Route::post('/students/import', [AdminController::class, 'importStudents'])->name('admin.students.import');
    // Teachers
    Route::get('/teachers', [App\Http\Controllers\TeacherController::class, 'index'])->name('admin.teachers');
    Route::post('/teachers', [App\Http\Controllers\TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::put('/teachers/{teacher}', [App\Http\Controllers\TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/teachers/{teacher}', [App\Http\Controllers\TeacherController::class, 'destroy'])->name('admin.teachers.destroy');

    // Courses
    Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index'])->name('admin.courses');
    Route::post('/courses', [App\Http\Controllers\CourseController::class, 'store'])->name('admin.courses.store');
    Route::put('/courses/{course}', [App\Http\Controllers\CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('admin.courses.destroy');

    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
