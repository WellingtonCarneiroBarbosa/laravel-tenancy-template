<?php

use App\Http\Controllers\Application\Students\CreateController;
use App\Http\Controllers\Application\Students\EditController;
use App\Http\Controllers\Application\Students\IndexController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', IndexController::class)->name('index');

    Route::get('/create', CreateController::class)->name('create');
    Route::post('/create', [CreateController::class, 'store']);

    Route::prefix('{user}')->group(function () {
        Route::get('/edit', EditController::class)->name('edit');
        Route::put('/edit', [EditController::class, 'update']);
        Route::get('/delete', CreateController::class)->name('delete');
    });
});
