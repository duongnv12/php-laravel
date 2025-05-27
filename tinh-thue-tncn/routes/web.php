<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxCalculatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TaxBracketController; 
use App\Http\Controllers\Admin\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes cho tính thuế
    Route::get('/tax-calculator', [TaxCalculatorController::class, 'showCalculatorForm'])->name('tax.form');
    Route::post('/tax-calculator', [TaxCalculatorController::class, 'calculateTax'])->name('tax.calculate');

    // Route cho trang lịch sử
    Route::get('/tax-history', [TaxCalculatorController::class, 'showTaxHistory'])->name('tax.history');

    // Routes cho xuất Excel và PDF TỔNG HỢP
    Route::get('/tax-calculations/export-excel', [TaxCalculatorController::class, 'exportExcel'])->name('tax.export.excel');
    Route::get('/tax-calculations/export-pdf-all', [TaxCalculatorController::class, 'exportPdfAll'])->name('tax.export.pdf.all');

    // Route cho chức năng xem chi tiết
    Route::get('/tax-calculations/{calculation}', [TaxCalculatorController::class, 'showTaxCalculationDetail'])->name('tax.detail');

    // Route cho chức năng xóa
    Route::delete('/tax-calculations/{calculation}', [TaxCalculatorController::class, 'deleteTaxCalculation'])->name('tax.delete');

    // Routes cho chức năng nhập liệu hàng loạt
    Route::get('/tax-import', [TaxCalculatorController::class, 'showImportForm'])->name('tax.import.form');
    Route::post('/tax-import', [TaxCalculatorController::class, 'processImport'])->name('tax.import.process');

    // Admin routes (đảm bảo middleware 'admin' đã được cấu hình nếu bạn dùng nó)
    Route::middleware('admin')->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::get('/admin/tax-settings', [TaxCalculatorController::class, 'showTaxSettingsForm'])->name('admin.tax_settings');
        Route::post('/admin/tax-settings', [TaxCalculatorController::class, 'saveTaxSettings'])->name('admin.tax_settings.save');

        // Routes mới cho quản lý bậc thuế
        Route::prefix('admin/tax-brackets')->name('admin.tax_brackets.')->group(function () {
            Route::get('/', [TaxBracketController::class, 'index'])->name('index');
            Route::get('/create', [TaxBracketController::class, 'create'])->name('create');
            Route::post('/', [TaxBracketController::class, 'store'])->name('store');
            Route::get('/{taxBracket}/edit', [TaxBracketController::class, 'edit'])->name('edit');
            Route::put('/{taxBracket}', [TaxBracketController::class, 'update'])->name('update');
            Route::delete('/{taxBracket}', [TaxBracketController::class, 'destroy'])->name('destroy');
        });

        // User Management Routes
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');        
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Route cho xem nhật ký hoạt động
        // Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity_logs.index');
    });
});

require __DIR__.'/auth.php';