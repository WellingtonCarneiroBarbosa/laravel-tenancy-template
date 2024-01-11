<?php

use App\Http\Middleware\StudentsApp\InitializeTenant;
use App\Http\Middleware\StudentsApp\TenantNotInitialized;
use Inertia\Inertia;

Route::prefix('/students-app')
    ->name('students-app.')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Index');
        })->middleware(TenantNotInitialized::class)->name('index');

        Route::prefix("/{tenant}")->middleware([
            InitializeTenant::class,
        ])->name('initialized-app.')->group(function () {
            Route::get('/', function () {
                return 'agora faca login';
            })->name('index');

            Route::middleware([
                'auth:sanctum',
                config('jetstream.auth_session'),
                'verified',
            ])->prefix('/app')->group(function () {
                Route::get('/', function () {
                    return 'home';
                })->name('home');
            });
        });
    });
