<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TeacherController;
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

    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/students/export/csv', [AdminController::class, 'exportCsv'])->name('admin.students.export.csv');
    Route::get('/students/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.students.export.pdf');
    Route::post('/students/import', [AdminController::class, 'importStudents'])->name('admin.students.import');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::put('/students/{student}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/students/{student}', [AdminController::class, 'deleteStudent'])->name('admin.students.destroy');

    // Teachers
    Route::get('/teachers', [TeacherController::class, 'index'])->name('admin.teachers');
    Route::get('/teachers/export/csv', [TeacherController::class, 'exportCsv'])->name('admin.teachers.export.csv');
    Route::get('/teachers/export/pdf', [TeacherController::class, 'exportPdf'])->name('admin.teachers.export.pdf');
    Route::post('/teachers/import', [TeacherController::class, 'import'])->name('admin.teachers.import');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');

    // Courses
    Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses');
    Route::get('/courses/export/csv', [CourseController::class, 'exportCsv'])->name('admin.courses.export.csv');
    Route::get('/courses/export/pdf', [CourseController::class, 'exportPdf'])->name('admin.courses.export.pdf');
    Route::post('/courses/import', [CourseController::class, 'import'])->name('admin.courses.import');
    Route::post('/courses', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');

    // Enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('admin.enrollments');
    Route::get('/enrollments/export/csv', [EnrollmentController::class, 'exportCsv'])->name('admin.enrollments.export.csv');
    Route::get('/enrollments/export/pdf', [EnrollmentController::class, 'exportPdf'])->name('admin.enrollments.export.pdf');
    Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');
    Route::put('/enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('admin.enrollments.update');
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('admin.enrollments.destroy');

    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
