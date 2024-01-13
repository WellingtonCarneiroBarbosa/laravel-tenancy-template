<?php

use App\Http\Controllers\Application\OnBoardingForm\CreateController;
use App\Http\Controllers\Application\OnBoardingForm\CreateInitialController;

Route::prefix('on-boarding-form')->name('on-boarding-form.')->group(function () {
    Route::get('/create-initial', CreateInitialController::class)->name('create-initial');
    Route::get('/', CreateController::class)->name('create');
    Route::post('/', [CreateController::class, 'store']);
});
