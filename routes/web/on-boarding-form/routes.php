<?php

use App\Http\Controllers\Application\OnBoardingForm\CreateController;
use App\Http\Controllers\Application\OnBoardingForm\CreateInitialController;
use App\Http\Controllers\Application\OnBoardingForm\IndexController;

Route::prefix('on-boarding-form')->name('on-boarding-form.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::get('/create-initial', CreateInitialController::class)->name('create-initial');
    Route::get('/create', CreateController::class)->name('create');
    Route::post('/create', [CreateController::class, 'store']);
});
