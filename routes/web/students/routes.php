<?php

use App\Http\Controllers\Application\Students\CreateController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', CreateController::class)->name('index');
    Route::get('/create', CreateController::class)->name('create');
    Route::post('/create', [CreateController::class, 'store']);
});
