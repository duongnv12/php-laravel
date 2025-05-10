<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SemesterController;

// Trang chủ public
Route::get('/', function () {
    return view('welcome');
});

// Nhóm route dành cho những người dùng đã xác thực và đã xác minh email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Các route quản lý profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Định nghĩa route cho việc import file Excel trước khi khai báo resource route của sinh viên
    Route::get('/students/import', [StudentController::class, 'importForm'])->name('students.import');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import.process');
    Route::get('courses/import', [CourseController::class, 'import'])->name('courses.import');
    Route::post('courses/import', [CourseController::class, 'importStore'])->name('courses.import.store');

    // Các resource route cho module của đề tài
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('cohorts', CohortController::class);
    Route::resource('progresses', ProgressController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('semesters', SemesterController::class);
}); // Đóng nhóm middleware

// Các route xác thực mặc định của Laravel Breeze/Jetstream …
require __DIR__.'/auth.php';
