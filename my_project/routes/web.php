<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news/add', [NewsController::class, 'add'])->name('news.add');
Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/list', [NewsController::class, 'list'])->name('news.list');
Route::get('/news/show/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
Route::post('/news/update/{id}', [NewsController::class, 'update'])->name('news.update');
Route::delete('/news/delete/{id}', [NewsController::class, 'destroy']);