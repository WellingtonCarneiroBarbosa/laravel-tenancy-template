<?php

use App\Http\Middleware\ShouldHaveAtLeastTwoOnBoardingForms;
use Inertia\Inertia;

require __DIR__ . '/on-boarding-form/routes.php';

Route::middleware([
    ShouldHaveAtLeastTwoOnBoardingForms::class,
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
