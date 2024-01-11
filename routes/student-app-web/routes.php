<?php

use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

Route::prefix('/students-app')
    ->name('students-app.')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Index');
        })->name('index');

        Route::prefix("/{tenant}")->middleware([
            InitializeTenancyByPath::class,
        ])->name('initialized-app.')->group(function () {
            Route::get('/', function () {
                return 'agora faca login';
            })->name('index');
        });
    });
