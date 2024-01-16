<?php

use App\Http\Controllers\Application\OnBoardingForm\CreateController;
use App\Http\Controllers\Application\OnBoardingForm\CreateInitialController;
use App\Http\Controllers\Application\OnBoardingForm\IndexController;
use App\Http\Controllers\Application\OnBoardingForm\UpdateController;

Route::prefix('on-boarding-form')->name('on-boarding-form.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::get('/create-initial', CreateInitialController::class)->name('create-initial');
    Route::get('/create', CreateController::class)->name('create');
    Route::post('/create', [CreateController::class, 'store']);

    Route::prefix('/{onBoardingForm}')->group(function () {
        Route::get('/edit', UpdateController::class)->name('edit');
        Route::put('/edit', [UpdateController::class, 'update']);

        Route::delete('/delete', [UpdateController::class, 'update'])->name('delete');
    });
});
