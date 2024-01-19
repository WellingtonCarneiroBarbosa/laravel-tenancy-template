<?php

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

require __DIR__ . '/users/routes.php';
