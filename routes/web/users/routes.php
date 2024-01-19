<?php

use App\Http\Controllers\Application\Users\CreateController;
use App\Http\Controllers\Application\Users\DeleteController;
use App\Http\Controllers\Application\Users\EditController;
use App\Http\Controllers\Application\Users\IndexController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', IndexController::class)->name('index');

    Route::get('/create', CreateController::class)->name('create');
    Route::post('/create', [CreateController::class, 'store']);

    Route::prefix('{user}')->group(function () {
        Route::get('/edit', EditController::class)->name('edit');
        Route::put('/edit', [EditController::class, 'update']);
        Route::delete('/delete', DeleteController::class)->name('delete');
    });
});
