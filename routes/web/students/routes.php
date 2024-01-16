<?php

use App\Http\Controllers\Application\Students\CreateController;
use App\Http\Controllers\Application\Students\IndexController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::get('/create', CreateController::class)->name('create');
    Route::post('/create', [CreateController::class, 'store']);
    Route::get('/edit', CreateController::class)->name('edit');
    Route::get('/delete', CreateController::class)->name('delete');
});
