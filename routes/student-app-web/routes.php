<?php

use Inertia\Inertia;

Route::prefix('/students-app')
    ->name('students-app.')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Index');
        })->name('index');
    });
