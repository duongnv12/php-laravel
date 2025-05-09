<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProgressController;

// Trang chủ public
Route::get('/', function () {
    return view('welcome');
});

// Nhóm route dành cho những người dùng đã xác thực và (nếu cần) đã xác minh email
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Các route quản lý profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Các resource route cho module của đề tài
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('progresses', ProgressController::class);
});

// Các route xác thực mặc định của Laravel Breeze/Jetstream …
require __DIR__.'/auth.php';
