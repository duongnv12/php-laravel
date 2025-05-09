<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Xác thực đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('users', AdminController::class);
    Route::resource('programs', ProgramController::class);
});

Route::middleware(['auth', CheckRole::class . ':teacher'])->group(function () {
    Route::get('/teacher', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
});

Route::middleware(['auth', CheckRole::class . ':student'])->group(function () {
    Route::get('/student', [StudentController::class, 'dashboard'])->name('student.dashboard');
});

// Xử lý lỗi truy cập
Route::fallback(function () {
    return response()->view('errors.403', [], 403);
});


// Sinh viên
Route::resource('students', StudentController::class);

Route::resource('courses', CourseController::class);

Route::resource('enrollments', EnrollmentController::class);