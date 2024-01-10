<?php

use App\Http\Controllers\Application\OnBoardingForm\CreateController;

Route::prefix('on-boarding-form')->name('on-boarding-form')->group(function () {
    Route::post('/', CreateController::class)->name('store');
});
